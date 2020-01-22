<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Item\Item as ItemResource;
use App\Models\Item;
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

            $items = $items->with('values.attribute.type', 'category.attributes.type')->paginate($request->has('limit') ? $request->get('limit') : $items->count());

            return ItemResource::collection($items);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
