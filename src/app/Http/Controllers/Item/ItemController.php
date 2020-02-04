<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\Item\ItemRequest;
use App\Http\Resources\Item\Item as ItemResource;
use App\Models\Category\Category;
use App\Models\Dictionary\Generic;
use App\Models\Item;
use Carbon\Carbon;
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
            $items = Item::query();

            if ($request->has('category')) {
                $items->where(['category_id' => $request->get('category')]);
            }

            $items = $items->with('category.attributes.type')->with(['values' => function ($query) {
                $query->with(['attribute' => function ($query) {
                    $query->with('type', 'options');
                }]);
            }])->paginate($request->has('limit') ? $request->get('limit') : $items->count());

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
     * Добавить атрибут
     *
     */
    public function post(ItemRequest $request)
    {
        try {
            $category = Category::with('attributes.type')->find($request->get('category'));

            DB::beginTransaction();

            $item = $category->items()->create();

            if ($request->has('attributes')) {
                $attributes = $request->get('attributes');

                foreach ($category->attributes as $attribute) {
                   if (array_key_exists($attribute->id, $request->get('attributes')) and !empty($attributes[$attribute->id])) {
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

                               if (!Generic::whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower($attributes[$attribute->id]))])->first()) {
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
            return new ItemResource($item->load('category.attributes.type')->load(['values' => function ($query) {
                $query->with(['attribute' => function ($query) {
                    $query->with('type', 'options');
                }]);
            }]));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Редактировать атрибут
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

                        if (array_key_exists($attribute->id, $request->get('attributes')) and !empty($attributes[$attribute->id])) {
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

                                    if (!Generic::whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower($attributes[$attribute->id]))])->first()) {
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

                $item->save();

                DB::commit();
                return new ItemResource($item->load('category.attributes.type')->load(['values' => function ($query) {
                    $query->with(['attribute' => function ($query) {
                        $query->with('type', 'options');
                    }]);
                }]));
            }

            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Удалить атрибут
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
