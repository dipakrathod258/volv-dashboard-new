<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class WriterController extends Controller
{
    public function index(){
        $authors = User::all();
        $writerSummary = [];
        foreach($authors as $author) {
            $author_data = DB::select("select count(*) as publishedArticleCount from volv.articles where article_author= "."'".$author->name."'"." and article_status='published' and created_at between '2019/11/01' and '2019/11/29';");
            // dd();
            $writerSummary[$author->name] = $author_data[0]->publishedArticleCount;
        }

        return view("writers.index", compact('writerSummary'));

        // dd($writerSummary);
    }
}
