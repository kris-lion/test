<?php

namespace App\Console\Commands\Unloading;

use App\Models\Dosage\Form;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Product\ProductClass;
use App\Models\Unit;
use Illuminate\Console\Command;
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
        $disk = Storage::disk('data');

        if (($handle = fopen($disk->path('medicaments.csv'), 'r')) !== false) {
            $i = 0;
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                echo "{$i}\n";
                $row = array_map('trim', $row);

                $product = Product::firstOrCreate([
                    'standard' => $row[0]
                ]);

                $unit = null;

                if (!empty($row[6])) {
                    $unit = Unit::firstOrCreate([
                        'name' => $row[6]
                    ]);
                }

                $productClass = ProductClass::firstOrCreate([
                    'name' => $row[10]
                ]);

                $generic = Generic::firstOrCreate([
                    'name' => $row[11]
                ]);

                $form = Form::firstOrCreate([
                    'name' => $row[13]
                ]);

                $product->update([
                    'name'             => $row[1],
                    'dosage_short'     => $row[2],
                    'packing'          => $row[3],
                    'addition'         => empty($row[4]) ? null : $row[4],
                    'volume'           => empty($row[5]) ? null : (double) $row[5],
                    'unit_id'          => $unit ? $unit->id : null,
                    'integer'          => $row[9],
                    'product_class_id' => $productClass->id,
                    'generic_name_id'  => $generic->id,
                    'dosage'           => $row[12],
                    'dosage_form_id'   => $form->id
                ]);

                $i++;
            }
            fclose($handle);
        }

        $this->info('File unloading completed successfully.');
    }
}
