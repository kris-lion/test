<?php

namespace App\Http\Controllers\Category\Attribute;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Category\Attribute\Type as TypeResource;
use App\Models\Category\Attribute\Type;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TypeController extends Controller
{
    /**
     * Типы
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function get(FilterRequest $request)
    {
        try {
            $types = Type::where(['active' => true]);

            $types = $types->paginate($request->has('limit') ? $request->get('limit') : $types->count());

            return TypeResource::collection($types);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
