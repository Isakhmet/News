<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    use ElasticquentTrait;

    protected $fillable = [

        'title',
        'alias',
        'anons',
        'image',
        'image_copyright',
        'description',
        'status',
        'active_at',
        'active_end',
        'settings',
        'created_at',
        'updated_at'
    ];

    protected $mappingPropertie = [
        'active_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd'
        ],
        'active_end' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd'
        ],
        'title' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'alias' => [
            'type' => 'keyword'
        ],
        'anons' => [
            'type' => 'text'
        ],
        'image' => [
            'type' => 'keyword'
        ],
        'image_copyright' => [
            'type' => 'keyword'
        ],
        'description' => [
            'type' => 'text'
        ],
        'status' => [
            'type' => 'boolean'
        ],
        'tags' => [
            'type' => 'keyword'
          ],
        'settings' => [
            'type' => 'text'
        ],
        'created_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],
        'updated_at' => [
            'type' => 'date',
            'format' => 'yyyy-MM-dd HH:mm:ss'
        ],

    ];

    protected $indexSettings = [
        "analysis" => [
            "analyzer" => [
                "analyzer_for_shot_text" => [
                    "type" => "custom",
                    "char_filter" => [
                        "html_strip"
                    ],
                    "tokenizer" => "standard",
                    "filter" => [
                        "ru_stop",
                        "ru_stemmer",
                        "lowercase",
                        "stop",
                        "snowball"
                    ]
                ],
                "analyzer_for_full_text" => [
                    "type" => "custom",
                    "char_filter" => [
                        "html_strip"
                    ],
                    "tokenizer" => "standard",
                    "filter" => [
                        "ru_stop",
                        "ru_stemmer",
                        "lowercase",
                        "en_stop"
                    ]
                ]
            ],
            "filter" => [
                "ru_stop" => [
                    "type" => "stop",
                    "stopwords" => "_russian_"
                ],
                "ru_stemmer" => [
                    "type" => "stemmer",
                    "language" => "russian"
                ],
                "en_stop" => [
                    "type" => "stop",
                    "stopwords" => "_english_"
                ]
            ]
        ]
    ];

    public function tags(){
        return $this->hasManyThrough(
            'App\Models\Tags',
            'App\Models\NewsTags',
            'news_id',
            'id',
            'id',
            'tags_id'
        );
    }
}
