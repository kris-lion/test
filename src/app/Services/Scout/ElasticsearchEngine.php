<?php

namespace App\Services\Scout;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use Elasticsearch\Client as Elastic;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchEngine extends Engine
{
    /**
     * Elastic where the instance of Elastic|\Elasticsearch\Client is stored.
     *
     * @var object
     */
    protected $elastic;

    /**
     * Create a new engine instance.
     *
     * @param  \Elasticsearch\Client  $elastic
     * @return void
     */
    public function __construct(Elastic $elastic)
    {
        $this->elastic = $elastic;
    }

    /**
     * Update the given model in the index.
     *
     * @param  Collection  $models
     * @return void
     */
    public function update($models)
    {
        $params['body'] = [];

        $models->each(function($model) use (&$params)
        {
            $params['body'][] = [
                'update' => [
                    '_id' => $model->getKey(),
                    '_index' => $model->category->id
                ]
            ];
            $params['body'][] = [
                'doc' => $model->toSearchableArray(),
                'doc_as_upsert' => true
            ];
        });

        $this->elastic->bulk($params);
    }

    /**
     * Remove the given model from the index.
     *
     * @param  Collection  $models
     * @return void
     */
    public function delete($models)
    {
        $params['body'] = [];

        $models->each(function($model) use (&$params)
        {
            $params['body'][] = [
                'delete' => [
                    '_id' => $model->getKey(),
                    '_index' => $model->category->id
                ]
            ];
        });

        $this->elastic->bulk($params);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder  $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        return $this->performSearch($builder, array_filter([
            'numericFilters' => $this->filters($builder),
            'size' => $builder->limit
        ]));
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder  $builder
     * @param  int  $perPage
     * @param  int  $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        $result = $this->performSearch($builder, [
            'numericFilters' => $this->filters($builder),
            'from' => (($page * $perPage) - $perPage),
            'size' => $perPage
        ]);

        $result['hits']['total'] = $result['hits']['total']['value'];
        $result['nbPages'] = $result['hits']['total']/$perPage;

        return $result;
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  Builder  $builder
     * @param  array  $options
     * @return mixed
     */
    protected function performSearch(Builder $builder, array $options = [])
    {
        $categories = $builder->query['categories'];

        $generic = null;
        if (array_key_exists('generic', $builder->query) and !empty($builder->query['generic'])) {
            $generic = [
                'search' => $builder->query['generic'],
                'field'  => null
            ];
        }

        $fields = [];

        foreach ($categories as $category) {
            foreach ($category->attributes as $attribute) {
                if ($generic and ($attribute->value === 'generics')) {
                    //$generic['field'] = "attribute_{$attribute->id}.ngram^2";
                    $generic['field'] = "attribute_{$attribute->id}^2";
                }
                if ($attribute->search) {
                    $fields[] = $attribute->priority ? "attribute_{$attribute->id}.ngram^2" : "attribute_{$attribute->id}.ngram";
                    $fields[] = $attribute->priority ? "attribute_{$attribute->id}^2" : "attribute_{$attribute->id}";
                }
            }
        }

        $except = (array_key_exists('except', $builder->query) and !empty($builder->query['except'])) ? $builder->query['except'] : [];

        if ($generic) {
            $params = [
                'index' => '_all',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                [
                                    [
                                        'multi_match' => [
                                            'query'       => $builder->query['search'],
                                            'type'        => 'cross_fields',
                                            'fields'      => $fields,
                                            'tie_breaker' => 0.5
                                        ],
                                    ],
                                    [
                                        'multi_match' => [
                                            'query'       => $generic['search'],
                                            'type'        => 'cross_fields',
                                            'fields'      => $generic['field'],
                                            'tie_breaker' => 0.5
                                        ],
                                    ]
                                ],
                            ],
                            'must_not' => [
                                'terms' => [
                                    'id' => $except
                                ]
                            ]
                        ],
                    ],
                    /*'highlight' => [
                        'fields' => [
                            '*' => [ 'number_of_fragments' => 0 ]
                        ]
                    ]*/
                ]
            ];
        } else {
            $params = [
                'index' => '_all',
                'body'  => [
                    'query' =>[
                        'bool' => [
                            'should' => [
                                [
                                    'multi_match' => [
                                        'query'       => $builder->query['search'],
                                        'type'        => 'cross_fields',
                                        'fields'      => $fields,
                                        'tie_breaker' => 0.5,
                                    ]
                                ],
                            ],
                            'must_not' => [
                                'terms' => [
                                    'id' => $except
                                ]
                            ]
                        ]
                    ],
                    'highlight' => [
                        'fields' => [
                            '*' => [ 'number_of_fragments' => 0 ]
                        ]
                    ]
                ]
            ];
        }

        if ($sort = $this->sort($builder)) {
            $params['body']['sort'] = $sort;
        }

        if (isset($options['from'])) {
            $params['body']['from'] = $options['from'];
        }

        if (isset($options['size'])) {
            $params['body']['size'] = $options['size'];
        }

        if (isset($options['numericFilters']) && count($options['numericFilters'])) {
            $params['body']['query']['bool']['must'] = array_merge($params['body']['query']['bool']['must'],
                $options['numericFilters']);
        }

        if ($builder->callback) {
            return call_user_func(
                $builder->callback,
                $this->elastic,
                $builder->query,
                $params
            );
        }

        return $this->elastic->search($params);
    }

    /**
     * Get the filter array for the query.
     *
     * @param  Builder  $builder
     * @return array
     */
    protected function filters(Builder $builder)
    {
        return collect($builder->wheres)->map(function ($value, $key) {
            if (is_array($value)) {
                return ['terms' => [$key => $value]];
            }

            return ['match_phrase' => [$key => $value]];
        })->values()->all();
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed  $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {
        return collect($results['hits']['hits'])->pluck('_id')->values();
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  mixed  $results
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return Collection
     */
    public function map(Builder $builder, $results, $model)
    {
        if ($results['hits']['total'] === 0) {
            return $model->newCollection();
        }

        $keys = collect($results['hits']['hits'])->pluck('_id')->values()->all();

        return $model->getScoutModelsByIds(
            $builder, $keys
        )->filter(function ($model) use ($keys) {
            return in_array($model->getScoutKey(), $keys);
        })->sortBy(function($item) use ($keys) {
            return array_search($item->getKey(), $keys);
        });
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed  $results
     * @return int
     */
    public function getTotalCount($results)
    {
        return $results['hits']['total'];
    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function flush($model)
    {
        $model->newQuery()
            ->orderBy($model->getKeyName())
            ->unsearchable();
    }

    /**
     * Generates the sort if theres any.
     *
     * @param  Builder $builder
     * @return array|null
     */
    protected function sort($builder)
    {
        if (count($builder->orders) == 0) {
            return null;
        }

        return collect($builder->orders)->map(function($order) {
            return [$order['column'] => $order['direction']];
        })->toArray();
    }
}
