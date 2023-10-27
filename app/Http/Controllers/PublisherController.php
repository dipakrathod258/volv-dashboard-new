<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publisher;
use App\Article;
use App\Http\Controllers\ArticleController;
use DB;
use App\Author;
use App\User;
use App\Category;
use App\State;
use App\ArticleStatus;
// use App\State;


class PublisherController extends Controller
{
    public function index(Request $request) {
    	$publishers = Publisher::orderBy('id', 'DESC')->get();
    	return view('publishers.index', compact('publishers'));
    }

    public function create(Request $request) {
    	return view('publishers.create');
    }

    public function store(Request $request) {
    	$base_url = "https://dashboard.volvmedia.com/";
        $destinationPath = public_path()."/"."/assets/imgs/publishers"; 
        $publisher = new Publisher();
    	$publisher->publisher_title = $request->publisher_title;

        
        $publisher_image_path = (int)microtime(true).$request->publisher_image->getClientOriginalName();

        $request->publisher_image->move($destinationPath, $publisher_image_path);


        $publisher->publisher_image_path = $base_url.'assets/imgs/publishers/'.$publisher_image_path;

    	$publisher->publisher_content = $request->publisher_content;
        $publisher->is_available = true;
    	if ($publisher->save()) {
	    	return redirect('/publisher/index');
    	}
    }

    public function destroy($id) {
        $publisher = Publisher::find($id);
        if ($publisher->delete()) {
            return redirect("/publisher/index");
        }
    }

    public function edit(Request $request, $id) {
        $publisher = Publisher::where('id', $id)->first();
        // dd($publisher);
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, $id) {
        $destinationPath = public_path()."/"."/assets/imgs/publishers"; 
        $publisher = Publisher::find($id);
        $publisher->publisher_title = $request->publisher_title;
        // dd(isset($request->publisher_image));
        if (isset($request->publisher_image)) {        
            $publisher_image_path = (int)microtime(true).$request->publisher_image->getClientOriginalName();

            $request->publisher_image->move($destinationPath, $publisher_image_path);


            $publisher->publisher_image_path = 'assets/imgs/publishers/'.$publisher_image_path;
            # code...
        }

        $publisher->publisher_content = $request->publisher_content;
        $publisher->is_available = true;
        if ($publisher->save()) {
            return redirect('/publisher/index')->with('success', 'Publisher updated successfully.');
        }

    }


    public function publisherArticles(Request $request, $publisher_id) {
        $articles = DB::table('articles')
        ->where('articles.article_publisher', $publisher_id)        
        ->select('articles.*')
        ->orderBy('updated_at', 'desc')
        ->paginate(15);

        $currentPage=$articles->currentPage();
        $articles = $articles->items();
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();

        if ($request->ajax()) {
            $keyword = $request->keyword;
            if(isset($keyword)) {

                $articles = Article::where('article_heading', '%' . $keyword . '%')->get();

                $articles = DB::table('articles')
                ->leftJoin('weekend_articles', 'articles.id', '=', 'weekend_articles.article_id')
                ->where('articles.article_publisher', $publisher_id)        
                ->select('articles.*', 'weekend_articles.publish_datetime')
                ->where('article_heading', 'like', "%".$keyword."%" )
                ->orWhere('article_summary', 'like', "%".$keyword."%" )
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
                $currentPage=$articles->currentPage();

                $articles = $articles->items();

                $authors = Author::all();
                $users = User::all();
                $categories = Category::all();
                $states = State::all();
                $priorities = array("Urgent", "Needs Coverage");
                $article_statuses = ArticleStatus::all();
                $articles = self::timeConverter($articles);       
                // return view('index', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));        
                $view = view('articles.filer_table',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','currentPage'))->render();
                // dd($view);
                return response()->json(['html'=>$view]);
            }

            ///////////////////////////////////Article Ajax Call Logic Starts///////////////////////////////////
            $author = $request->author;
            $status = $request->status;
            $category = $request->category;
            $priority = $request->priority;
            $start_dates=$request->start_date;
            $end_dates=$request->end_date;
            if($category == "Biz") {
                
                $articles=DB::table('articles')
                ->select('articles.*')
                ->where('articles.article_publisher', $publisher_id)
                ->where('article_author','LIKE',$author)
                ->where('article_status','LIKE',$status)
                ->where('article_category','LIKE', "Business")
                ->orWhere('article_category','LIKE', "Finance")
                ->where('article_priority','LIKE',$priority)
                ->whereBetween('articles.updated_at', [$start_dates.' 00:00:00',$end_dates.' 23:59:59'])
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
            }
            elseif ($category == "Pop Culture") {
                $articles=DB::table('articles')
                ->select('articles.*')
                ->where('articles.article_publisher', $publisher_id)
                ->where('article_author','LIKE',$author)
                ->where('article_status','LIKE',$status)
                ->where('article_category','LIKE', "Pop Culture")
                ->orWhere('article_category','LIKE', "Fashion")
                ->where('article_priority','LIKE',$priority)
                ->whereBetween('articles.updated_at', [$start_dates.' 00:00:00',$end_dates.' 23:59:59'])
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
            }
            elseif ($category == "Important Updates") {
                $articles=DB::table('articles')
                ->select('articles.*')
                ->where('articles.article_publisher', $publisher_id)
                ->where('article_author','LIKE',$author)
                ->where('article_status','LIKE',$status)
                ->where('article_category','LIKE', "Important Updates")
                ->orWhere('article_category','LIKE', "Sports")
                ->where('article_priority','LIKE',$priority)
                ->whereBetween('articles.updated_at', [$start_dates.' 00:00:00',$end_dates.' 23:59:59'])
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
            }
            else {
                $articles=DB::table('articles')
                ->select('articles.*')
                ->where('articles.article_publisher', $publisher_id)
                ->where('article_author','LIKE',$author)
                ->where('article_status','LIKE',$status)
                ->where('article_category','LIKE',"%".$category."%")
                ->where('article_priority','LIKE',$priority)
                ->whereBetween('articles.updated_at', [$start_dates.' 00:00:00',$end_dates.' 23:59:59'])
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
            }

            $currentPage=$articles->currentPage();

            $articles = ArticleController::timeConverter($articles);
            $articles = ArticleController::convertTimeFormat($articles);
            $view = view('articles.filer_table',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','currentPage'))->render();
            // dd($view);
            return response()->json(['html'=>$view]);
        }

        $articles = ArticleController::timeConverter($articles);
        $articles = ArticleController::convertTimeFormat($articles);
        //Extra Logic
        
        $article_end_date = DB::select("SELECT updated_at FROM  articles LIMIT 1;");
        $start_date=explode(" ",$article_end_date[0]->updated_at)[0];
        if($articles) {
            $end_date=explode(" ",$articles[0]->updated_at)[0];
        } else {
            $end_date=null;
        }

        // dd($start_date,$end_date);
        $is_publisher_article = True;
        $publisher = Publisher::find($publisher_id);
        return view('index', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','start_date','end_date','currentPage', 'is_publisher_article', 'publisher'));
    }
}
