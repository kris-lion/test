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

                    $item = $category->items()->create(['active' => true]);

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
                                    if (!Generic::whereRaw('LOWER(name) LIKE ? ', [trim(mb_strtolower($value))])->first()) {
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

                                    if ($unit = Unit::whereRaw('LOWER(short) LIKE ? ', [trim(mb_strtolower($row[6]))])->first()) {
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
                    DB::commit();
                    $item->load('category', 'values')->searchable();

                    $i++;
                }
                fclose($handle);
            }

            if (($handle = fopen($disk->path('preparations.csv'), 'r')) !== false) {
                $i = 0;

                $category = Category::where(['name' => 'Дезинфицирующие средства и Моющие средства'])->with('attributes.type')->first();

                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    DB::beginTransaction();

                    echo "{$i}\n";
                    $row = array_map('trim', $row);

                    $item = $category->items()->create(['active' => true]);

                    foreach ($category->attributes as $attribute) {
                        $value = null;

                        switch ($attribute->name) {
                            case 'Торговое Наименование':
                                $value = $row[1];
                                break;
                            case 'Торговая Марка':
                                $value = $row[2];
                                break;
                            case 'Дополнение к "Торговое Наименование"':
                                $value = $row[3];
                                break;
                            case 'Дозировка краткая':
                                $value = $row[4];
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

                                    if ($unit = Unit::whereRaw('LOWER(short) LIKE ? ', [trim(mb_strtolower($row[6]))])->first()) {
                                        $value = $unit->short;
                                    }
                                }
                                break;
                            case 'Количество':
                                $value = $row[7];
                                break;
                            case 'Концентрация':
                                $value = $row[8];
                                break;
                            case 'ЕИ концентрации':
                                $value = $row[9];
                                break;
                            case 'Лекарственная форма':
                                $value = $row[10];
                                break;
                            case 'Активное вещество (МНН)':
                                $value = $row[11];

                                if (!empty($value)) {
                                    if (!Generic::whereRaw('LOWER(`name`) LIKE ? ', [trim(mb_strtolower($value))])->first()) {
                                        Generic::create([
                                            'name' => $value
                                        ]);
                                    }
                                }
                                break;
                            case 'Класс товара':
                                $value = $row[12];
                                break;
                        }

                        if (!empty($value)) {
                            $attribute->values()->create([
                                'item_id' => $item->id,
                                'value' => $value
                            ]);
                        }
                    }
                    DB::commit();
                    $item->load('category', 'values')->searchable();

                    $i++;
                }
                fclose($handle);
            }

            if (($handle = fopen($disk->path('products.csv'), 'r')) !== false) {
                $i = 0;

                $category = Category::where(['name' => 'Продукты питания'])->with('attributes.type')->first();

                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    DB::beginTransaction();

                    echo "{$i}\n";
                    $row = array_map('trim', $row);

                    $item = $category->items()->create(['active' => true]);

                    foreach ($category->attributes as $attribute) {
                        $value = null;

                        switch ($attribute->name) {
                            case 'Имя ТН':
                                $value = $row[4];
                                break;
                            case 'ТМ':
                                $value = $row[5];
                                break;
                            case 'Сорт':
                                $value = $row[6];
                                break;
                            case 'Кулинарный разруб':
                                $value = $row[7];
                                break;
                            case 'Концентрация':
                                $value = $row[8];
                                break;
                            case 'Категория/Группа':
                                $value = $row[9];
                                break;
                            case 'Дополнение':
                                $value = $row[10];
                                break;
                            case 'Фасовка/Вес':
                                $value = $row[11];
                                break;
                            case 'Вес, объем':
                                $value = $row[12];
                                break;
                            case 'Единица измерения':
                                if (!empty($row[13])) {
                                    switch ($row[13]) {
                                        case 'л':
                                            $row[13] = 'л; дм3';
                                    }

                                    if ($unit = Unit::whereRaw('LOWER(short) LIKE ? ', [trim(mb_strtolower($row[6]))])->first()) {
                                        $value = $unit->short;
                                    }
                                }
                                break;
                            case 'Вес':
                                $value = $row[14];
                                break;
                            case 'Объем':
                                $value = $row[15];
                                break;
                            case 'Количество':
                                $value = $row[16];
                                break;
                        }

                        if (!empty($value)) {
                            $attribute->values()->create([
                                'item_id' => $item->id,
                                'value' => $value
                            ]);
                        }
                    }
                    DB::commit();
                    $item->load('category', 'values')->searchable();

                    $i++;
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
