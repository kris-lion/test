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
                                } 
                                catch (\Exception $e) {
                                    Log::warning($e);
                                }

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

                                if ($item) {
                                    if ($cache) {
                                        $coincidence = true;
                                    } 
                                    else {

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

                                            // Kris
                                            
                                            $highlight_2 = $highlight;
                                            $highlight_clear = [];
                                            $k = 0;
                                            $pos = null;
                                            $pos2 = null;

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
                                                                        $hit = preg_replace('~'.$findme.'~', '', $hit);
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
                                            
                                            // Kris end
                                            $match = [];

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
                                            

                                            $count = [];
                                            
                                            // Kris code
                                            
                                            $count = [
                                                'result' => round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $result), "utf-8")) * 100), 1) . " %",
                                                'search' => round((($concurrencyAllAttribute / mb_strlen(str_replace(" ", "", $search), "utf-8")) * 100), 1) . " %"
                                            ];
                                            $item->count = $count;
                                            
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
                                    "search"      => $search,
                                    "id"          => $row[0],
                                    "standard"    => $coincidence ? new ItemResource($item) : null,
                                    "standards"   => ItemResource::collection($items)
                                ]) . "\n", FILE_APPEND | LOCK_EX);
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
