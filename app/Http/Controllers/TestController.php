<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrendingSaveArticle;


class TestController extends Controller
{
    public function test() {
        $response = file_get_contents('https://newsapi.org/v2/top-headlines?sources=google-news&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');

         $response_new = json_decode($response , true);

            $articles = $response_new['articles'];
            $api_article_count = count($articles);


            $data = TrendingSaveArticle::all();
            $count = $data->count();
            // dd($count);
            if ($count>30) {
                DB::table('trending_articles')
                ->orderBy('id')
                ->limit($api_article_count)
                ->delete();
                // dd("deleted");
            }

         foreach ($articles as $key => $article) {

            $data = new TrendingSaveArticle();
            // dd($data);
            // dd($article);
            $data['title'] = $article['title'];
            $data['description'] = $article['description'];
            $data['main_source'] = $article['url'];
            $data['source'] = $article['source']['name'];
            $data['url_to_image'] = $article['urlToImage'];
            $data['publishedAt'] = $article['publishedAt'];
            $data->save();
            // dd("saved");
        }
    }


    public function upload_image(Request $request) {
    	// dd($request->image);
        
		if(isset($request->image))
		{
		 $data = $_POST["image"];

		 $image_array_1 = explode(";", $data);

		 $image_array_2 = explode(",", $image_array_1[1]);

		 $data = base64_decode($image_array_2[1]);

		 $imageName = time() . '.png';

		 file_put_contents($imageName, $data);

		 // echo '<img src="'.$imageName.'" class="img-thumbnail" />';
		 return $imageName;
		}
    }

    public function disabelRegister() {

        return view("auth.disable_registration");
    }

    public function sessionTrack() {
        session_start();
// Set session variables
        $_SESSION["favcolor"] = "green";
        $_SESSION["favanimal"] = "cat";
        dd($_SESSION);
    }

    public function index() {
        dd("Send iOS Notifications");
    }

    public function configDetails() {
        dd(phpinfo());
        return phpinfo();
    }
}
