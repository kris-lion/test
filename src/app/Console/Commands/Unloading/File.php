<?php

namespace App\Console\Commands\Unloading;

use App\Models\Category\Unit;
use App\Models\Dictionary\Generic;
use App\Models\Category\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class File extends Command
{
    protected $signature = 'unloading:file';

    protected $description = "File unloading.";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $disk = Storage::disk('data');

            if (($handle = fopen($disk->path('medicaments.csv'), 'r')) !== false) {
                $i = 0;

                $category = Category::where(['name' => 'Лекарственные средства'])->with('attributes.type')->first();

                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    DB::beginTransaction();

                    echo "{$i}\n";
                    $row = array_map('trim', $row);

                    $item = $category->items()->create();

                    foreach ($category->attributes as $attribute) {
                        $value = null;

                        switch ($attribute->name) {
                            case 'Торговое Наименование':
                                $value = $row[1];
                                break;
                            case 'Дозировка краткая':
                                $value = $row[2];
                                break;
                            case 'Фасовка':
                                $value = $row[3];
                                break;
                            case 'Дополнение после Фасовки':
                                $value = $row[4];
                                break;
                            case 'МНН':
                                $value = $row[11];

                                if (!empty($value)) {
                                    if (!Generic::whereRaw('LOWER(`name`) LIKE ? ', [$value])->first()) {
                                        Generic::create([
                                            'name' => $value
                                        ]);
                                    }
                                }
                                break;
                            case 'Объем, вес и дозы':
                                $value = $row[5];
                                break;
                            case 'ЕИ объема, веса и дозы':
                                if (!empty($row[6])) {
                                    switch ($row[6]) {
                                        case 'л':
                                            $row[6] = 'л; дм3';
                                    }

                                    if ($unit = Unit::whereRaw('LOWER(`short`) LIKE ? ', [$row[6]])->first()) {
                                        $value = $unit->short;
                                    }
                                }
                                break;
                            case 'Класс товара':
                                $value = $row[10];
                                break;
                            case 'Лекарственная форма':


                                $value = $row[13];
                                break;
                        }

                        if (!empty($value)) {
                            $attribute->values()->create([
                                'item_id' => $item->id,
                                'value' => $value
                            ]);
                        }
                    }

                    $item->save();

                    $i++;
                    DB::commit();
                }
                fclose($handle);
            }

            $this->info('File unloading completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
        }
    }
}
