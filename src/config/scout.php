<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'elastic'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => env('SCOUT_QUEUE', false),

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => false,

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'elastic' => [
        'config' => [
            'hosts' => [
                env('SCOUT_HOST', 'localhost:9200'),
            ]
        ],
        'settings' => [
            'number_of_replicas' => 0,
            'number_of_shards' => 1,
            'analysis' => [
                'tokenizer' => [
                    'index_ngram' => [
                        'type' => 'edgeNGram',
                        'min_gram' => 3,
                        'max_gram' => 20,
                        'custom_token_chars' => [
                            '-,'
                        ],
                        'token_chars' => [
                            'letter',
                            'digit',
                            'custom'
                        ]
                    ]
                ],
                'char_filter' => [
                    //16мг -> 16 мг
                    'number_and_string' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '(\\d+)([\\D+&&[^.,]])',
                        'replacement' => '$1 $2'
                    ],
                    //мг16 -> мг 16
                    'string_and_number' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '([\\D+&&[^.,]])(\\d+)',
                        'replacement' => '$1 $2'
                    ],
                    //1.6 -> 1,6
                    'double_format' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '(\\d+)([.])(\\d+)',
                        'replacement' => '$1,$3'
                    ],
                    //1,0 -> 1
                    'integer_format' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '(\\d+)([,])([0]+)',
                        'replacement' => '$1'
                    ],
                    //0,1 -> 0,1 1
                    'number_denominator' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '(\\D)([0]+)([,])(\\d+)',
                        'replacement' => '$2,$4 $4'
                    ],
                    //N10 -> N 10 | №10 -> № 10 | #10 -> # 10
                    'number_format' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '( [№N#х]{1})(\\d)',
                        'replacement' => '$1 $2'
                    ],
                    //Текст.Текст -> Текст. Текст
                    'string_format' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '([a-zA-Z[а-яА-Я]])([.])([a-zA-Z[а-яА-Я]])',
                        'replacement' => '$1. $3'
                    ],
                    //Текст Текст -> ТекстТекст
                    'trade_name' => [
                        'type'        => 'pattern_replace',
                        'pattern'     => '([a-zA-Z[а-яА-Я]])([\s])([a-zA-Z[а-яА-Я]])',
                        'replacement' => '$1$3'
                    ]
                ],
                'analyzer' => [
                    'ngram_index_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'index_ngram',
                        'char_filter' => [
                            'number_and_string',
                            'string_and_number',
                            'double_format',
                            'integer_format',
                            'number_denominator',
                            'number_format',
                            'string_format'
                        ],
                        'filter' => [
                            'lowercase'
                        ]
                    ],
                    'ngram_search_analyzer' => [
                        'tokenizer' => 'index_ngram',
                        'char_filter' => [
                            'number_and_string',
                            'string_and_number',
                            'double_format',
                            'integer_format',
                            'number_denominator',
                            'number_format',
                            'string_format'
                        ],
                        'filter' => [
                            'lowercase'
                        ]
                    ]
                ]
            ]
        ]
    ],
];
