<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AIController extends Controller
{
    public function googleTrends(Request $request) {
        $data = DB::select('select * from google_trends_articles order by article_pubilsh_time;'); 
        $category = "All";
        return view('ai.google_trends', compact('data', 'category'));
    }

    public function googleTrendsBusiness(Request $request) {
        $data = DB::select('select * from google_trends_articles_business;'); 
        $category = "Business";
        return view('ai.google_trends', compact('data', 'category'));
    }
    public function googleTrendsEntertainment(Request $request) {
        $data = DB::select('select * from google_trends_articles_entertainment;'); 
        $category = "Entertainment";
        return view('ai.google_trends', compact('data', 'category'));
    }
    public function googleTrendsHealth(Request $request) {
        $data = DB::select('select * from google_trends_articles_health;'); 
        $category = "Health";
        return view('ai.google_trends', compact('data', 'category'));
    }

    public function googleTrendsScienceNTech(Request $request) {
        $data = DB::select('select * from google_trends_articles_sci_n_tech;'); 
        $category = "Science & Tech";
        return view('ai.google_trends', compact('data', 'category'));
    }

    public function googleTrendsSports(Request $request) {
        $data = DB::select('select * from google_trends_articles_sports;'); 
        $category = "Sports";
        return view('ai.google_trends', compact('data', 'category'));
    }

    public function googleTrendsTopStories(Request $request) {
        $data = DB::select('select * from google_trends_articles_top_stories;'); 
        $category = "Top Stories";
        return view('ai.google_trends', compact('data', 'category'));
    }

    public function index(Request $request) {
        dd("google trends collab on github");
    }

    public function getGPTSummarization() {
        return view('ai.gpt_summrization');
    }

    public function fetchGPTSummarization(Request $request) {
        $article = $request->article_text;
        $data_to_post = [
            "text"=>$article,
        ];
        $data_to_post = json_encode($data_to_post);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://ec2-3-110-215-226.ap-south-1.compute.amazonaws.com/api/summarization");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);
        if ($result->status == 200) {
            $final_response["status"] = "success";
            $final_response["description"] = $result->message;
        }
        else {
            $final_response["status"] = "failed";
            $final_response["description"] = "Server Error";            
        }
        return $final_response;   
    }

    public function getGPTContent() {
        return view('ai.get_content_safety');
    }

    public function fetchGPTContent(Request $request) {
        $article = $request->article_text;
        $data_to_post = [
            "text"=>$article,
        ];
        $data_to_post = json_encode($data_to_post);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://ec2-3-110-215-226.ap-south-1.compute.amazonaws.com/api/content");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);
        dd($result);
        if ($result->status == 200) {
            $final_response["status"] = "success";
            $final_response["description"] = $result->message;
        }
        else {
            $final_response["status"] = "failed";
            $final_response["description"] = "Server Error";            
        }
        return $final_response;   
    }
}

