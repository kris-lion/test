<?php

namespace App\Console\Commands\Scout;

use App\Models\Category\Category;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Settings extends Command
{
    protected $signature = 'scout:settings';

    protected $description = "Installing the server settings elasticsearch.";

    protected $elastic;

    public function __construct()
    {
        parent::__construct();
        $this->elastic = ClientBuilder::fromConfig(config('scout.elastic.config'));
    }

    public function handle()
    {
        try {
            $categories = Category::with('attributes.type')->get();

            foreach ($categories as $category) {
                if ($this->elastic->indices()->exists(['index' => "{$category->id}"])) {
                    if (!$this->elastic->indices()->getSettings(['index' => "{$category->id}"])) {
                        $settings = [
                            'index' => $category->id,
                            'body' => config('scout.elastic.settings')
                        ];

                        $this->elastic->indices()->putSettings($settings);
                    }
                } else {
                    $this->elastic->indices()->create(['index' => "{$category->id}", 'body' => config('scout.elastic.settings')]);
                }

                $params = [
                    'index' => "{$category->id}",
                    'body' => [
                        'type' => 'long'
                    ],
                    'type' => 'id'
                ];

                $this->elastic->indices()->putMapping($params);

                foreach ($category->attributes as $attribute) {
                    $mapping = [];

                    switch ($attribute->type->key) {
                        case 'integer':
                            $mapping = [
                                'type' => 'integer'
                            ];
                            break;
                        case 'double':
                            $mapping = [
                                'type' => 'double'
                            ];
                            break;
                        case 'multiselect':
                            $mapping = [
                                'type' => 'array'
                            ];
                            break;
                        default:
                            $mapping = [
                                'type' => 'text',
                                'fields' => [
                                    'ngram' => [
                                        'type' => 'text',
                                        'analyzer' => 'ngram_index_analyzer',
                                        'search_analyzer' => 'ngram_search_analyzer'
                                    ]
                                ]
                            ];
                    }

                    $params = [
                        'index' => "{$category->id}",
                        'body' => $mapping,
                        'type' => $attribute->name
                    ];

                    $this->elastic->indices()->putMapping($params);
                }
            }

            $this->info('Elasticsearch settings successfully applied.');
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
