<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElasticSearchRepository;

class SearchController extends Controller
{
    protected $elasticSearchRepository;
    
    public function __construct(ElasticSearchRepository $elasticSearchRepository) 
    {
        $this->elasticSearchRepository = $elasticSearchRepository;
    }
    
    public function search(Request $request)
    {
        $articles = $this->elasticSearchRepository->search($request->q);

        return $articles;
    }
}
