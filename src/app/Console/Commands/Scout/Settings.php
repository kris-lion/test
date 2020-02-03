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

    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = ClientBuilder::fromConfig(config('scout.elastic.config'));
    }

    public function handle()
    {
        $categories = Category::with('attributes.type')->get();

        foreach ($categories as $category) {
            if ($this->client->indices()->exists(['index' => "{$category->id}"])) {
                if (!$this->client->indices()->getSettings(['index' => "{$category->id}"])) {
                    $settings = [
                        'index' => $category->id,
                        'body' => config('scout.elastic.settings')
                    ];

                    $this->client->indices()->putSettings($settings);
                }
            } else {
                $this->client->indices()->create(['index' => "{$category->id}", 'body' => config('scout.elastic.settings')]);
            }

            $params = [
                'index' => "{$category->id}",
                'body' => [
                    'type' => 'long'
                ],
                'type' => 'id'
            ];

            $this->client->indices()->putMapping($params);

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

                $this->client->indices()->putMapping($params);
            }
        }

        $this->info('Elasticsearch settings successfully applied.');
    }
}
