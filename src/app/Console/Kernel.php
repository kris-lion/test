<?php

namespace App\Console;

use App\Models\Category\Category;
use App\Models\Item;
use App\Models\Matching\Task;
use App\Http\Resources\Item\Item as ItemResource;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(
            function () {
                $disk = Storage::disk('matching');

                $threshold = 75;

                $categories = Category::with('attributes')->get();

                foreach(Task::where(['active' => true, 'run' => false])->get() as $task) {
                    try {
                        $task->update(['run' => true]);
                        DB::beginTransaction();

                        if (($handle = fopen($disk->path($task->id), 'r')) !== false) {

                            while (($row = fgetcsv($handle, 1000, ";")) !== false) {
                                $cache = false;
                                $id = null;
                                $highlight = [];

                                $search = trim($row[1]);

                                $key = hash('sha512', $search);

                                try {
                                    if (Cache::has($key)) {
                                        $id = Cache::get($key);
                                        $cache = true;
                                    }
                                } catch (\Exception $e) {
                                    Log::warning($e);
                                }

                                if (!$cache) {
                                    $hits = Item::search(['search' => $search, 'categories' => $categories])->raw()['hits']['hits'];
                                    if (count($hits)) {
                                        $id = $hits[0]['_source']['id'];
                                        $highlight = $hits[0]['highlight'];
                                    }
                                }

                                $item = Item::where(['id' => $id])->with(['values' => function ($query) {
                                    $query->whereHas('attribute',  function ($query) {
                                        $query->where(['search' => true]);
                                    });

                                    $query->with(['attribute' => function ($query) {
                                        $query->where(['search' => true]);
                                        $query->with('type', 'options');
                                    }]);
                                }])->first();

                                $coincidence = false;

                                if ($item) {
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

                                            if (!empty($fullStringResult)) {
                                                $result .= " ";
                                            }

                                            $result .= (string)$value->value;
                                        }

                                        if (!$check or ($check and $priority)) {
                                            $concurrencyAllAttribute = 0;

                                            $match = [];

                                            foreach ($highlight as $attr => $hit) {
                                                $m = [];

                                                preg_match_all('/<em[^>]*?>(.*?)<\/em>/si', array_shift($hit), $m);

                                                $match = array_merge($match, $m[1]);
                                            }

                                            $match = array_unique($match);

                                            foreach ($match as $term) {
                                                $concurrencyAllAttribute += mb_strlen($term, "utf-8");
                                            }

                                            $coincidence = ((round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $result), "utf-8")) * 100), 1) >= $threshold)
                                                and (round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $search), "utf-8")) * 100), 1) >= $threshold));
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

                                file_put_contents($disk->path("result/{$task->id}.json"), json_encode([
                                    "id"          => $row[0],
                                    "standard"    => $coincidence ? new ItemResource($item) : null,
                                    "standards"   => array_values($items->toArray())
                                ]), FILE_APPEND | LOCK_EX);
                            }

                            $task->update(['active' => false, 'run' => false]);
                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        dd($e);
                        Log::error($e);
                        $task->update(['run' => false]);
                    }
                }
            }
        )->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
