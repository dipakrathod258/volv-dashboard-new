<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class WeekendArticlesController extends Controller
{
  public function index() {
        $data =DB::table('weekend_articles')
        ->join('articles', 'articles.id', '=', 'weekend_articles.article_id')
        ->select('articles.article_image', 'articles.article_author','articles.id', 'articles.article_heading', 'articles.article_status','weekend_articles.publish_datetime')
        ->orderBy('weekend_articles.publish_datetime', 'desc')
        ->get();

      return view('weekend.index', compact('data'));
  }
}
