<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Category\Category as CategoryResource;
use App\Models\Category\Attribute;
use App\Models\Category\Category;
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
            }])->paginate($request->has('limit') ? $request->get('limit') : $categories->count());

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
        //Реализовать как дерево категорий

        try {
            DB::beginTransaction();

            $category = Category::create([
                'name' => $request->get('name')
            ]);

            $types = Attribute\Type::where(['active' => true])->get();

            if ($request->has('attributes')) {
                foreach ($request->get('attributes') as $item) {
                    if ($type = $types->where('id', $item['type'])->first()) {
                        $attribute = $category->attributes()->create([
                            'name'     => $item['name'],
                            'type_id'  => $type->id,
                            'required' => $item['required']
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
            return new CategoryResource($category->load('attributes.type', 'attributes.options'));
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
                    'name' => $request->get('name')
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
                                       'required' => $item['required']
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
                                    'required' => $item['required']
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
                return new CategoryResource($category->load('attributes.type', 'attributes.options'));
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
    public function delete($categoryId)
    {
        try {
            /*
             * Перед удалением категории нужно проверить на наличие активных эталонов в ней,
             * если эталоны есть, то перед удалением предупредить о наличии эталонов и дать на выбор
             *
             * 1. Категорию для их автоматического переноса. Категорию предложить обычным списком с подкатегориями.
             * 2. Оставить связь с удаленной категорией
             * 3. Отвязать эталоны от категории (оставить nuLL в поле category_id)
             */

            if ($category = Category::find($categoryId)) {
                $category->delete();
            }

            return response()->noContent();
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
