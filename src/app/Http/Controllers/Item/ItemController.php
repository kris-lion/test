<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\Item\ItemRequest;
use App\Http\Resources\Item\Item as ItemResource;
use App\Models\Category\Category;
use App\Models\Dictionary\Generic;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    /**
     * Эталоны
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function get(FilterRequest $request)
    {
        try {
            if ($request->has('search')) {
                $search = $request->get('search');

                if ($request->has('category')) {
                    $test = DB::select('WITH RECURSIVE r AS (SELECT id, category_id FROM categories WHERE category_id = ? UNION SELECT categories.id, categories.category_id FROM categories JOIN r ON categories.category_id = r.id) SELECT * FROM r', [$request->get('category')]);
                    $categories = Category::with('attributes')->whereIn('id', array_merge([(int) $request->get('category')], collect($test)->pluck('id')->toArray()))->get();
                } else {
                    $categories = Category::with('attributes')->get();
                }

                $sequence = Item::search(['search' => $search, 'categories' => $categories])->get()->pluck('id')->toArray();

                $items = Item::where(function ($query) use ($request) { if ($request->has('except') and !empty($request->get('except'))) { $query->whereNotIn('id', explode(',', $request->get('except'))); } })->whereIn('id', $sequence)->with('category')->with(['values' => function ($query) {
                    $query->with(['attribute' => function ($query) {
                        $query->with('type', 'options');
                    }]);
                }])->whereIn('category_id', $categories->pluck('id')->toArray());

                if ($request->has('active')) {
                    $items->where(['active' => ($request->get('active') === 'true')]);
                }

                $items = $items->orderBy('active')->orderBy('id')->paginate($request->has('limit') ? $request->get('limit') : $items->count());

                $items->setCollection($items->getCollection()->sortBy(function($item) use ($sequence) {
                    return array_search($item->getKey(), $sequence);
                }));
            } else {
                $items = Item::query();

                if ($request->has('category')) {
                    $items->where(['category_id' => $request->get('category')]);
                }

                $items = $items->with('category')->with(['values' => function ($query) {
                    $query->with(['attribute' => function ($query) {
                        $query->with('type', 'options');
                    }]);
                }]);

                if ($request->has('active')) {
                    $items->where(['active' => ($request->get('active') === 'true')]);
                }

                $items = $items->orderBy('active')->orderBy('id')->paginate($request->has('limit') ? $request->get('limit') : $items->count());
            }

            return ItemResource::collection($items);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Количество эталонов
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function count(FilterRequest $request)
    {
        try {
            $items = Item::query();

            if ($request->has('category')) {
                $items->where(['category_id' => $request->get('category')]);
            }

            return response()->json(['count' => $items->count()]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Предложения эталонов
     *
     * @return AnonymousResourceCollection
     */
    public function offers()
    {
        try {
            $items = Item::where(['active' => false])->get();

            $count = $items->count();

            $items = $items->groupBy(function ($item) {
                return $item->category_id;
            });

            $items = $items->map(function ($item) {
                return collect($item)->count();
            });

            return response()->json(['count' => $count, 'categories' => $items->toArray()]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Добавить эталон
     *
     */
    public function post(ItemRequest $request)
    {
        try {
            $category = Category::with('attributes.type')->find($request->get('category'));

            DB::beginTransaction();

            $item = $category->items()->create(['active' => Auth::user() ? true : false]);

            if ($request->has('attributes')) {
                $attributes = $request->get('attributes');

                foreach ($category->attributes as $attribute) {
                   if (array_key_exists($attribute->id, $attributes) and !empty($attributes[$attribute->id])) {

                       switch ($attribute->type->key) {
                           case 'generic':
                               $attribute->values()->create([
                                   'item_id' => $item->id,
                                   'value'   => json_encode($attributes[$attribute->id])
                               ]);
                               break;
                           case 'multiselect':
                               $attribute->values()->create([
                                   'item_id' => $item->id,
                                   'value'   => json_encode($attributes[$attribute->id])
                               ]);
                               break;
                           case 'dictionary':
                               $attribute->values()->create([
                                   'item_id' => $item->id,
                                   'value'   => trim($attributes[$attribute->id])
                               ]);

                               if (!Generic::whereRaw('LOWER(name) LIKE ? ', [trim(mb_strtolower($attributes[$attribute->id]))])->first()) {
                                   Generic::create([
                                       'name' => trim($attributes[$attribute->id])
                                   ]);
                               }
                               break;
                           default:
                               $attribute->values()->create([
                                   'item_id' => $item->id,
                                   'value'   => $attributes[$attribute->id]
                               ]);
                       }
                   }
                }
            }

            DB::commit();

            $item->load('category.attributes.type')->load(['values' => function ($query) {
                $query->with(['attribute' => function ($query) {
                    $query->with('type', 'options');
                }]);
            }]);

            $item->searchable();

            return new ItemResource($item);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Редактировать эталон
     *
     */
    public function put(ItemRequest $request, $itemId)
    {
        try {
            $category = Category::with('attributes.type')->find($request->get('category'));

            if ($item = $category->items()->find($itemId)) {

                DB::beginTransaction();

                if ($request->has('attributes')) {
                    $attributes = $request->get('attributes');

                    foreach ($category->attributes as $attribute) {
                        $value = $item->values->where('attribute_id', '=', $attribute->id)->first();

                        if (array_key_exists($attribute->id, $attributes) and !empty($attributes[$attribute->id])) {
                            switch ($attribute->type->key) {
                                case 'generic':
                                    if ($value) {
                                        $value->update([
                                            'value' => json_encode($attributes[$attribute->id])
                                        ]);
                                    } else {
                                        $attribute->values()->create([
                                            'item_id' => $item->id,
                                            'value'   => json_encode($attributes[$attribute->id])
                                        ]);
                                    }
                                    break;
                                case 'multiselect':
                                    if ($value) {
                                        $value->update([
                                            'value' => json_encode($attributes[$attribute->id])
                                        ]);
                                    } else {
                                        $attribute->values()->create([
                                            'item_id' => $item->id,
                                            'value'   => json_encode($attributes[$attribute->id])
                                        ]);
                                    }
                                    break;
                                case 'dictionary':
                                    if ($value) {
                                        $value->update([
                                            'value'   => trim($attributes[$attribute->id])
                                        ]);
                                    } else {
                                        $attribute->values()->create([
                                            'item_id' => $item->id,
                                            'value'   => trim($attributes[$attribute->id])
                                        ]);
                                    }

                                    if (!Generic::whereRaw('LOWER(name) LIKE ? ', [trim(mb_strtolower($attributes[$attribute->id]))])->first()) {
                                        Generic::create([
                                            'name' => trim($attributes[$attribute->id])
                                        ]);
                                    }
                                    break;
                                default:
                                    if ($value) {
                                        $value->update([
                                            'value' => $attributes[$attribute->id]
                                        ]);
                                    } else {
                                        $attribute->values()->create([
                                            'item_id' => $item->id,
                                            'value'   => $attributes[$attribute->id]
                                        ]);
                                    }
                            }
                        } else if ($value) {
                            $value->delete();
                        }
                    }
                } else if ($item->values->count()) {
                    $item->values()->delete();
                }

                if ($request->has('active')) {
                    $item->update([
                        'active' => $request->get('active')
                    ]);
                }

                DB::commit();

                $item->load('category.attributes.type')->load(['values' => function ($query) {
                    $query->with(['attribute' => function ($query) {
                        $query->with('type', 'options');
                    }]);
                }]);

                $item->searchable();

                return new ItemResource($item);
            }

            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Удалить эталон
     *
     */
    public function delete($itemId)
    {
        try {
            if ($item = Item::find($itemId)) {
                $item->delete();
            }

            return response()->noContent();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
