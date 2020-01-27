<?php

namespace App\Http\Controllers\Category\Unit;

use App\Http\Resources\Category\Unit as UnitResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\Category\Unit;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UnitController extends Controller
{
    /**
     * Единицы измерения
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function get(FilterRequest $request)
    {
        try {
            $units = Unit::query();

            $units = $units->paginate($request->has('limit') ? $request->get('limit') : $units->count());

            return UnitResource::collection($units);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
