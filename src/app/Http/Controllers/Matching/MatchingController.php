<?php

namespace App\Http\Controllers\Matching;

use App\Http\Controllers\Controller;
use App\Http\Requests\Matching\ItemsRequest;
use App\Http\Requests\Matching\MatchingRequest;
use App\Models\Matching\Task;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class MatchingController extends Controller
{
    /**
     * Получить результат сопоставления
     *
     * @return AnonymousResourceCollection
     */
    public function get($taskId)
    {
        if ($task = Task::find($taskId)) {
            if ($task->active) {
                return response()->noContent();
            }

            $disk = Storage::disk('matching');

            return response()->download($disk->getDriver()->getAdapter()->getPathPrefix() . "result/{$task->id}.json");
        }

        return response()->make(['message' => trans('http.status.404')], 404);
    }

    /**
     * Сопоставить эталоны
     *
     * @param MatchingRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function post(MatchingRequest $request)
    {
        try {
            $disk = Storage::disk('matching');

            DB::beginTransaction();

            $task = Task::create();

            $disk->put(
                $task->id,
                file_get_contents($request->file('items')->getRealPath())
            );

            DB::commit();
            return response()->json(['id' => $task->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->make(['message' => trans('http.status.500')], 500);
        }
    }

    /**
     * Кэширование сопоставленных эталонов
     *
     * @param ItemsRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function cache(ItemsRequest $request)
    {
        foreach($request->get('items') as $item) {
            try {
                Cache::put(hash('sha512', $item['search']), $item['standard_id'], 20160);
            } catch (\Exception $e) {
                Log::warning($e);
            }
        }

        return response()->noContent();
    }
}
