<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArticleHashtags;
use App\Article;
use DB;
use Carbon\Carbon;

class HashtagController extends Controller
{

    public function getMiniHashtags(Request $request) {
        $article_categories = $request->article_categories;
        // dd($article_categories);
        $subCategoryFinalArray = [];
        foreach($article_categories as $data) {
            // dd($data);
            $subCategoryArray = ArticleHashtags::Select("sub_category")->distinct()->Where('category_ids', 'like', '%' . $data . '%')->get();
            // dd($obj);

            foreach($subCategoryArray as $subCategoryObj) {
                $subCategoryFinalArray[] = $subCategoryObj->sub_category;
            }
        }
        return json_encode($subCategoryFinalArray);
    }

    public function hashtagIndex(Request $request) {
        $data = ArticleHashtags::orderBy("updated_at", "DESC")->get();
        // dd($data);        
        $miniObj =[];
        $finalObj = [];
        foreach($data as $d) {
            $categoryArray = explode(",", $d->category_ids);
            foreach($categoryArray as $cat) {
                $finalObj[$cat][] = $d->sub_category;
            }
            $miniObj[$d->category_ids][] = $d->sub_category;
        }
        // dd($finalObj);
        return view('hashtags.index', compact("finalObj"));
    }

    public function deleteMiniHashtags(Request $request, $mini_hashtag) {
        $flag = ArticleHashtags::where('sub_category', $mini_hashtag)->delete();
        $articles = Article::where('article_subcategories', $mini_hashtag)->get(); 
        // dd($articles);  
        if ($articles) {
            DB::select("update articles set article_subcategories=null where article_subcategories="."'".$mini_hashtag."'"."");
         }     


        if($flag) {
            $response["status"] = "success";
        }
        else {
            $response["status"] = "failure";            
        }
        return $response;
    }

    public function searchHashtagArticle(Request $request, $hashtag) {
        // $miniHashTags = ArticleHashtags::orderBy("updated_at", "DESC")->limit(10)->get();

        $miniHashTags =ArticleHashtags::where('created_at','>=',Carbon::now()->subdays(4))->get();

        $articles = Article::where("article_subcategories", "like", "%".$hashtag."%")->orderBy("updated_at", "DESC")->get();
        // dd($miniHashTags);
        return view("hashtags.mini_hashtags_articles", compact("articles", "hashtag", "miniHashTags"));
    }

    public function removeArticleHashtags($article_id, $hashtag) {
        // dd($article_id);
        $article = Article::find($article_id);
        // dd($article);
        $article_subcategories = explode(",", $article->article_subcategories);
        // dd($article_subcategories);
        foreach($article_subcategories as $key => $article_subcategory) {
            if($article_subcategory == $hashtag) {
                unset($article_subcategories[$key]);
            }
        }
        // dd($article_subcategories);
        $article_subcategories = implode(",", $article_subcategories);
        // dd($article_subcategories);
        $article->article_subcategories = $article_subcategories;

        if($article->save()) {
            return redirect("/searchHashtagArticle/$hashtag")->with('success', 'Article removed successfully from this hashtag.'); ;
        }
        else {
            return redirect("/searchHashtagArticle/$hashtag")->with('failure', 'Article did not remove from hashtag.'); ;
        }
    }


}
