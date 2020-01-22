<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Category\Category as CategoryResource;
use App\Models\Category\Attribute;
use App\Models\Category\Category;
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

            $categories = $categories->with('attributes.type')->paginate($request->has('limit') ? $request->get('limit') : $categories->count());

            return CategoryResource::collection($categories);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    protected function createAttribute(Category $category, Attribute\Type $type, $value)
    {
        switch ($type->key) {
            case 'generic':

                break;
            default:
                $category->attributes()->create([
                    'name'     => $value['name'],
                    'type_id'  => $type->id,
                    'required' => $value['required']
                ]);
        }
    }

    /**
     * Добавить категорию
     *
     */
    public function post(CategoryRequest $request)
    {
        try {
            $category = Category::create([
                'name' => $request->get('name')
            ]);

            $types = Attribute\Type::where(['active' => true])->get();

            if ($request->has('attributes')) {
                foreach ($request->get('attributes') as $item) {
                    if ($type = $types->where('id', $item['type'])->first()) {
                        $this->createAttribute($category, $type, $item);
                    }
                }
            }

            return new CategoryResource($category->load('attributes.type'));
        } catch (\Exception $e) {
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
                                $this->createAttribute($category, $type, $item);
                            }
                        }
                    }

                } else if ($category->attributes->count()) {
                    $category->attributes()->delete();
                }

                return new CategoryResource($category->load('attributes.type'));
            }

            return response()->noContent();
        } catch (\Exception $e) {
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
