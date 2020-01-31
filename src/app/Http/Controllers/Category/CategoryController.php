<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Category\Category as CategoryResource;
use App\Models\Category\Attribute;
use App\Models\Category\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Категории
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function get(FilterRequest $request)
    {
        try {
            $categories = Category::query();

            $categories = $categories->with(['attributes' => function ($query) {
                $query->with('type', 'options')->orderBy('id');
            }])->with('category')->orderBy('category_id')->orderBy('id')->paginate($request->has('limit') ? $request->get('limit') : $categories->count());

            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Добавить категорию
     *
     */
    public function post(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $category = Category::create([
                'name'        => $request->get('name'),
                'category_id' => $request->has('category') ? $request->get('category') : null
            ]);

            $types = Attribute\Type::where(['active' => true])->get();

            if ($request->has('attributes')) {
                foreach ($request->get('attributes') as $item) {
                    if ($type = $types->where('id', $item['type'])->first()) {
                        $attribute = $category->attributes()->create([
                            'name'     => $item['name'],
                            'type_id'  => $type->id,
                            'required' => $item['required'],
                            'value'    => $item['value']
                        ]);

                        if (($type->key === 'select') or ($type->key === 'multiselect')) {
                            foreach ($item['options'] as $option) {
                                $attribute->options()->create([
                                    'option' => $option['option']
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return new CategoryResource($category->load('attributes.type', 'attributes.options', 'category'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Редактировать категорию
     *
     */
    public function put(CategoryRequest $request, $categoryId)
    {
        try {
            if ($category = Category::find($categoryId)) {
                DB::beginTransaction();

                $category->update([
                    'name'        => $request->get('name'),
                    'category_id' => $request->has('category') ? $request->get('category') : null
                ]);

                if ($request->has('attributes') and count($request->get('attributes'))) {

                    $types = Attribute\Type::where(['active' => true])->get();

                    $attributes = $request->get('attributes');

                    if ($category->attributes->count()) {
                        $attributesId = $category->attributes->pluck('id')->toArray();

                        foreach ($attributes as $key => $item) {
                            if (array_key_exists('id', $item)) {
                                if ($attribute = $category->attributes->where('id', '=', $item['id'])->first()) {

                                    $attributesIdKey = array_search($attribute->id, $attributesId);
                                    if ($attributesIdKey !== false) {
                                        unset($attributesId[$attributesIdKey]);
                                    }

                                    $attribute->update([
                                        'name'     => $item['name'],
                                        'required' => $item['required'],
                                        'value'    => $item['value']
                                    ]);

                                    if (($attribute->type->key === 'select') or ($attribute->type->key === 'multiselect')) {
                                        $options = $item['options'];

                                        $optionsId = $attribute->options->pluck('id')->toArray();

                                        foreach ($options as $index => $option) {
                                            if (array_key_exists('id', $option)) {
                                                if ($current = $attribute->options->where('id', '=', $option['id'])->first()) {

                                                    $optionsIdKey = array_search($current->id, $optionsId);
                                                    if ($optionsIdKey !== false) {
                                                        unset($optionsId[$optionsIdKey]);
                                                    }

                                                    $current->update([
                                                        'option' => $option['option']
                                                    ]);

                                                    unset($options[$index]);
                                                }
                                            }
                                        }

                                        if ($optionsId) {
                                            $attribute->options()->whereIn('id', $optionsId)->delete();
                                        }

                                        if ($options) {
                                            foreach ($options as $option) {
                                                $attribute->options()->create([
                                                    'option' => $option['option']
                                                ]);
                                            }
                                        }
                                    }

                                    unset($attributes[$key]);
                                }
                            }
                        }

                        if ($attributesId) {
                            $category->attributes()->whereIn('id', $attributesId)->delete();
                        }
                    }

                    if ($attributes) {
                        foreach ($attributes as $item) {
                            if ($type = $types->where('id', $item['type'])->first()) {
                                $attribute = $category->attributes()->create([
                                    'name'     => $item['name'],
                                    'type_id'  => $type->id,
                                    'required' => $item['required'],
                                    'value'    => $item['value']
                                ]);

                                if (($type->key === 'select') or ($type->key === 'multiselect')) {
                                    foreach ($item['options'] as $option) {
                                        $attribute->options()->create([
                                            'option' => $option['option']
                                        ]);
                                    }
                                }
                            }
                        }
                    }

                } else if ($category->attributes->count()) {
                    $category->attributes()->delete();
                }

                DB::commit();
                return new CategoryResource($category->load('attributes.type', 'attributes.options', 'category'));
            }

            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Удалить категорию
     *
     */
    public function delete(Request $request, $categoryId)
    {
        try {
            if ($category = Category::find($categoryId)) {
                DB::beginTransaction();

                if ($request->has('type')) {
                    switch ($request->get('type')) {
                        case 'empty':
                            $descendants = DB::select("SELECT id FROM categories WHERE category_id = {$category->id} UNION SELECT id FROM categories WHERE category_id IN (SELECT id FROM categories WHERE category_id = {$category->id})");
                            $descendants = collect($descendants)->pluck('id')->toArray();

                            Item::whereIn('category_id', array_merge([$category->id], $descendants))->update([
                                'category_id' => null
                            ]);

                            Category::whereIn('id', $descendants)->delete();
                            break;
                        case 'category':
                            $current = Category::find($request->get('category'));

                            Item::where(['category_id' => $category->id])->update([
                                'category_id' => $current->id
                            ]);

                            Category::where(['category_id' => $category->id])->update(['category_id' => $current->id]);
                            break;
                        default:
                            $descendants = DB::select("SELECT id FROM categories WHERE category_id = {$category->id} UNION SELECT id FROM categories WHERE category_id IN (SELECT id FROM categories WHERE category_id = {$category->id})");
                            Category::whereIn('id', collect($descendants)->pluck('id')->toArray())->delete();
                    }
                }

                $category->delete();
            }

            DB::commit();
            return response()->noContent();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
