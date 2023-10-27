<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Author;
use App\User;
use App\Category;
use App\State;
use App\ArticleStatus;
use DB;
use App\Http\Controller\ArticleController;
use App\Traits\ArticleActivityTrait;

class ArticleActivityController extends Controller
{
    use ArticleActivityTrait;

    public function articleScheduler(Request $request) {
        $articles = DB::table('articles')->orderBy('updated_at', 'desc')->paginate(15);
        $articles = $articles->items();

        $article_statuses = ArticleStatus::all();

        return view('articles.activities.scheduler.index', compact('articles','article_statuses'));        
    }
}
