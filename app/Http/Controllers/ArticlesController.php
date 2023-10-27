<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = DB::select('select * from articles order by updated_at desc');
        foreach ($articles as $key => $value) {
            $value=(array)$value;
            $seconds = self::secondsConverter($value["updated_at"]);
            if(!($seconds > 86400)) {
                $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                $articles[$key]->time_ago = $converted_time;    
            }
            else {
                $articles[$key]->time_ago = $value["updated_at"];  
            }
        }
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();

        // foreach($articles as $key => $value) {
            
        //     $author_name_array = [];
        //     $article_id= $value->id;
        //     $article_thread_obj = ArticleAuthorHistory::where('article_id', $article_id)->first();
        //     if ($article_thread_obj) {
        //         $article_thread_ids = $article_thread_obj->article_author_thread;
        //         if ($article_thread_ids) {
        //             $author_ids = explode(',', $article_thread_ids);
        //             foreach ($author_ids as $key => $value) {                    
        //                 $author_details = User::where('id', (int)$value)->first();
        //                 array_push($author_name_array, $author_details->name);
        //             }
        //         }
        //     }
        //     DB::table('articles')
        //         ->where('id', $article_id)
        //         ->update(['article_author' => implode(',', $author_name_array)]);
        //     // $articles[$key]->article_author = $author_name_array;
        // }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
