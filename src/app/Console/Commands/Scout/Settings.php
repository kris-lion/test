<?php

namespace App\Console\Commands\Scout;

use App\Models\Category\Category;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class Settings extends Command
{
    protected $signature = 'scout:settings';

    protected $description = "Installing the server settings elasticsearch.";

    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = ClientBuilder::fromConfig(config('scout.elastic.config'));
    }

    public function handle()
    {
        $categories = Category::with(['attributes' => function ($query) {
            $query->with('type');
        }])->get();

        foreach ($categories as $category) {
            if ($this->client->indices()->exists(['index' => "{$category->id}"])) {
                $this->client->indices()->delete(['index' => "{$category->id}"]);
            }

            $this->client->indices()->create(['index' => "{$category->id}", 'body' => ['settings' => config('scout.elastic.settings')]]);

            $params = [
                'index' => "{$category->id}",
                'body' => [
                    'properties' => [
                        'id' => [
                            'type' => 'long'
                        ]
                    ]
                ]
            ];

            $this->client->indices()->putMapping($params);

            foreach ($category->attributes as $attribute) {
                switch ($attribute->type->key) {
                    case 'integer':
                        $mapping = [
                            'type' => 'integer',
                        ];
                        break;
                    case 'double':
                        $mapping = [
                            'type' => 'double',
                        ];
                        break;
                    default:
                        $mapping = [
                            'type'   => 'text',
                            'fields' => [
                                'ngram' => [
                                    'type' => 'text',
                                    'analyzer'        => 'ngram_index_analyzer',
                                    'search_analyzer' => 'ngram_search_analyzer'
                                ]
                            ]
                        ];
                }

                $params = [
                    'index' => "{$category->id}",
                    'body' => [
                        'properties' => [
                            "attribute_{$attribute->id}" => $mapping
                        ]
                    ]
                ];

                $this->client->indices()->putMapping($params);
            }
        }

        $this->info('Elasticsearch settings successfully applied.');
    }
}
