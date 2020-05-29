<?php

namespace App\Console\Commands\Script;

use App\Models\Category\Attribute;
use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Download extends Command
{
    protected $signature = 'script:download';

    protected $description = "Run download standards.";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $disk = Storage::disk('data');

        $category = 'Категория';
        $file = "result/name.csv";

        $items = Item::whereHas('category', function ($query) use ($category) {
            $query->where(['name' => $category]);
        })->with(['values' => function ($query) {
            $query->with('attribute')->orderBy('attribute_id');
        }])->orderBy('id')->limit(100)->get();

        $attributes = Attribute::whereHas('category', function ($query) use ($category) {
            $query->where(['name' => $category]);
        })->get();

        $i = 0;

        $result = "Идентификатор;";
        foreach ($attributes as $attribute) {
            $result .= "{$attribute->name};";
        }
        $result .= "Эталонное наименование";
        file_put_contents($disk->path($file), $result . "\n", FILE_APPEND | LOCK_EX);
        $last = null;

        while($items->count()) {

            foreach ($items as $item) {
                $result = "{$item->id};";
                $standard = null;

                foreach ($attributes as $attribute) {
                    if ($value = $item->values->where('attribute_id', $attribute->id)->first()) {
                        if ($attribute->search) {
                            $standard .= !$standard ? "{$value->value}" : " {$value->value}";
                        }
                        $result .= "{$value->value}";
                    }
                    $result.= ";";
                }

                $result .= $standard;

                file_put_contents($disk->path($file), $result . "\n", FILE_APPEND | LOCK_EX);

                $last = $item;
                $i++;
                echo "{$i} \n";
            }

            if ($last) {
                $items = Item::whereHas('category', function ($query) use ($category) {
                    $query->where(['name' => $category]);
                })->with(['values' => function ($query) {
                    $query->with('attribute')->orderBy('attribute_id');
                }])->where('id', '>', $last->id)->orderBy('id')->limit(100)->get();
            }
        }

        $this->info('Download standards successfully.');
    }
}
