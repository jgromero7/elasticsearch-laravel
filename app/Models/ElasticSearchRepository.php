<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Elasticsearch\Client;

use App\Models\Article;

class ElasticSearchRepository extends Model
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search($query = '')
    {
        $article = new Article;
        
        $items = $this->client->search([
            'index' => $article->getTable(),
            'type' => $article->getTable(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title', 'tags'],
                        'query' => $query
                    ]
                ]
            ]
        ]);

        return $this->mapToModel($items['hits']['hits']);
    }

    public function mapToModel($articles)
    {
        $items = array_map(function($item) {
            $article = new Article;
            $article->id = $item['_id'];
            $article->title = $item['_source']['title'];
            $article->tags = $item['_source']['tags'];
            return $article;
        }, $articles);

        return $items;
    }
}
