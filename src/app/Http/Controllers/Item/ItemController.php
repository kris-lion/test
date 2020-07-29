<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\Item\ItemRequest;
use App\Http\Resources\Item\Item as ItemResource;
use App\Models\Category\Category;
use App\Models\Dictionary\Generic;
use App\Models\Item;
use App\Models\Matching\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use function foo\func;

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

                $sequence = Item::search(['search' => $search, 'categories' => $categories, 'generic' => $request->get('generic')])->get()->pluck('id')->toArray();

                $items = Item::where(function ($query) use ($request) {
                    if ($request->has('except') and !empty($request->get('except'))) {
                        $query->whereNotIn('id', explode(',', $request->get('except')));
                    }
                    if ($request->has('generic') and !empty($request->get('generic'))) {
                        $query->whereHas('values', function ($query) use ($request) {
                            $query->whereRaw('LOWER(value) LIKE ? ', [trim(mb_strtolower($request->get('generic')))]);
                            $query->whereHas('attribute', function ($query) {
                                $query->where(['value' => 'generics']);
                            });
                        });
                    }
                })->whereIn('id', $sequence)->with('category')->with(['values' => function ($query) {
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
     * Анализ
     *
     * @param FilterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function analysis(FilterRequest $request)
    {
        $threshold = 75;

        $categories = Category::with('attributes')->get();

        $cache = false;
        $id = null;
        $highlight = [];
        $name = null;
        $id = null;
        $category = null;

        $search = $request->get('search');

        $key = hash('sha512', $search);

        if (!$cache) {
            $hits = Item::search(['search' => $search, 'categories' => $categories])->raw()['hits']['hits'];

            if (count($hits)) {
                $id = $hits[0]['_source']['id'];
                $highlight = $hits[0]['highlight'];
            }
        }

        $item = Item::where(['id' => $id])->with('category')->with(['values' => function ($query) {
            $query->whereHas('attribute',  function ($query) {
                $query->where(['search' => true]);
            });

            $query->with(['attribute' => function ($query) {
                $query->where(['search' => true]);
                $query->with('type', 'options');
            }]);
        }])->first();

        $coincidence = false;

        $count = [
            'result',
            'search'
        ];

        $result = null;

        if ($item) {
            $id = $item->id;
            $category = $item->category;

            if ($cache) {
                $coincidence = true;
            } else {

                $result = "";

                $priority = false;
                $check = false;

                foreach ($item->values as $value) {
                    if ($value->attribute->priority) {
                        $check = true;
                        $priority = array_key_exists("attribute_{$value->attribute->id}.ngram", $highlight);
                    }

                    if ($value->attribute->search) {
                        $name .= $name ? " {$value->value}" : (string)$value->value;
                    }

                    if (!empty($fullStringResult)) {
                        $result .= " ";
                    }

                    $result .= (string)$value->value;
                }

                if (!$check or ($check and $priority)) {
                    $concurrencyAllAttribute = 0;

                    $match = [];
                    
                    // Kris code
                    $highlight_2 = $highlight;
                    $highlight_clear = [];
                    $k = 0;

                    foreach($highlight as $attr => $hit){

                        array_shift($highlight_2);
                        preg_match_all('/<em[^>]*?>(.*?)<\/em>/si', $hit[0], $m);
                        $number_attr = preg_replace('/[^0-9]/', '', $attr);
                        $flag = true;

                        foreach($highlight_2 as $attr2 => $value){

                            preg_match_all('/<em[^>]*?>(.*?)<\/em>/si', $value[0], $m2);
                            $number_attr2 = preg_replace('/[^0-9]/', '', $attr2);

                            if ($number_attr == $number_attr2){
                                foreach($m[1] as $term){
                                    foreach($m2[1] as $findme){
                                        if (!empty($term) and !empty($findme)){

                                            $pos = strpos($term, $findme);
                                            $pos2 = strpos($findme, $term);

                                            if (is_numeric($pos) and $pos2 === false){
                                                $hit = preg_replace('~'.$findme.'~', '', $hit); // доработать (удалять максимальной длины вхождения)
                                                break;
                                            }
                                            if ($pos === false and is_numeric($pos2)){
                                                $hit = preg_replace('~<em>'.$term.'</em>~', '', $hit);
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if ($flag){
                            $highlight_clear[$attr] = $hit;
                            $k++;
                        }
                        
                    }
                    // Kris code end
                    

                    foreach ($highlight_clear as $attr => $hit) {
                        $m = [];

                        preg_match_all('/<em[^>]*?>(.*?)<\/em>/si', array_shift($hit), $m);

                        $match = array_merge($match, $m[1]);
                    }
                    

                    $match = array_unique($match);

                    foreach ($match as $term) {
                        $concurrencyAllAttribute += mb_strlen($term, "utf-8");
                    }

                    $coincidence = ((round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $result), "utf-8")) * 100), 1) >= $threshold)
                        || (round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $search), "utf-8")) * 100), 1) >= $threshold));
                    //$coincidence = round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $search), "utf-8")) * 100), 1) >= $threshold;

                    $count = [
                        'result' => round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $result), "utf-8")) * 100), 1) . " %",
                        'search' => round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $search), "utf-8")) * 100), 1) . " %"
                    ];
                }
            }
        }

        $items = collect();

        if (!$coincidence) {
            $sequence = [];

            foreach($hits as $el) {
                $sequence[] = $el['_source']['id'];
            }

            $items = Item::whereIn('id', $sequence)->with('category')->with(['values' => function ($query) {
                $query->with(['attribute' => function ($query) {
                    $query->with('type', 'options');
                }]);
            }])->get();

            $items = $items->sortBy(function($item) use ($sequence) {
                return array_search($item->getKey(), $sequence);
            });
        } else {
            try {
                Cache::put($key, $item->id, 20160);
            } catch (\Exception $e) {
                Log::warning($e);
            }
        }

        $analyze = [
            'search' => null,
            'result' => null
        ];

        if ($category) {
            $response = Http::post(current(config('scout.elastic.config.hosts')) . "/{$category->id}/_analyze?pretty", [
                "analyzer" => "ngram_search_analyzer",
                "text" => $result
            ]);

            if ($response->ok()) {
                $analyze['result'] = collect(json_decode($response->body())->tokens)->pluck('token')->toArray();
            }

            $response = Http::post(current(config('scout.elastic.config.hosts')) . "/{$category->id}/_analyze?pretty", [
                "analyzer" => "ngram_search_analyzer",
                "text" => $search
            ]);

            if ($response->ok()) {
                $analyze['search'] = collect(json_decode($response->body())->tokens)->pluck('token')->toArray();
            }
        }

        return response()->json([
            'search'      => $search,
            'result'      => [
                'id'   => $id,
                'name' => $name
            ],
            'standard'    => $coincidence ? new ItemResource($item) : null,
            'coincidence' => $count,
            'highlight'   => $highlight,
            'tokens'      => $analyze,
            'match'       => $match,
            'highlight_clear'      => $highlight_clear
        ]);
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
