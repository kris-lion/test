<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\Dictionary\Generic as GenericResource;
use App\Models\Dictionary\Generic;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DictionaryController extends Controller
{
    /**
     * Международные непатентованные названия
     *
     * @param FilterRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function generics(FilterRequest $request)
    {
        try {
            $generics = Generic::query();

            $generics = $generics->paginate($request->has('limit') ? $request->get('limit') : $generics->count());

            return GenericResource::collection($generics);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }
}
