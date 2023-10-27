<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrendingCategory;
use App\Category;
use App\Article;
use App\TrendingArticle;
use App\TrendingSaveArticle;
use DateTime;
use App\Http\Controllers\ArticleController;

class TrendingCategoryController extends Controller
{
    public function index(Request $request) {
    	$trending_categories = TrendingCategory::all();
    	return view("trending_category.index", compact('trending_categories'));
    }

    public function articlePublishTimeConverter($publish_date) {
        $a = gmdate('Y-m-d H:i:s', time());
        // dd(gettype($a));
        $first_date = new DateTime($publish_date);
        // dd($a);
        // $b = $date1;
        // $first_date = new DateTime($date1);
        $second_date = new DateTime($a);
        $difference = $first_date->diff($second_date)->format("%h hrs %i mins ago");
        return $difference;
    }

    public function index_new(Request $request) {

    	$trending_categories = TrendingCategory::all();
        $trending_save_articles= TrendingSaveArticle::all();


        $articles = [];

        foreach ($trending_save_articles as $key => $value) {
            $source["id"] = null;
            $source["name"] = $value['source'];
            $data["source"] = $source;
            $data["author"] = $value['id'];
            $data["title"] = $value['title'];
            $data["description"] = $value['description'];
            $data["url"] = $value['main_source'];
            $data["urlToImage"] = $value['url_to_image'];
            $data["publishedAt"] = $value['publishedAt'];
            $data["content"] = null;
            $articles[$key] = $data;
        }

        foreach ($articles as $key => $value) {
            
            $article_heading = $value['title'];
            $main_source = $value['url'];
            $article_image = $value['urlToImage'];

            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }

        $news_type = "US News";
        $trending_category_flag='USNews';
    	return view("trending_category.new_index", compact('trending_categories' ,'articles','news_type', 'trending_category_flag'));
    }

    public function worldNews() {
		$response = file_get_contents('https://newsapi.org/v2/everything?sources=al-jazeera-english,bbc-news,cnn&language=en&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];

        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }
        $trending_category_flag='world';
        $news_type = "World News";
    	return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }



    public function sportNews() {
		$response = file_get_contents('https://newsapi.org/v2/top-headlines?country=us&category=sports&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];

        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }

        $trending_category_flag='sports';
        $news_type = "Sports News";
    	return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }

    public function entertainmentNews() {
		$response = file_get_contents('https://newsapi.org/v2/top-headlines?country=us&category=entertainment&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];

        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }

        $news_type = "Entertainment News";
        $trending_category_flag='entertainment';
    	return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }

    public function financeNews() {
		$response = file_get_contents('https://newsapi.org/v2/top-headlines?sources=cnbc,the-wall-street-journal&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];

        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }

        $news_type = "Finance News";
        $trending_category_flag='finance';
    	return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }



    public function businessNews() {
		$response = file_get_contents('https://newsapi.org/v2/top-headlines?country=us&category=business&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];
        // dd($articles);


        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }

        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }

        $news_type = "Business News";
        $trending_category_flag='business';
    	return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }
    public function technologyNews() {
		$response = file_get_contents('https://newsapi.org/v2/top-headlines?country=us&category=technology&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];


        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }

        $news_type = "Technology News";
        $trending_category_flag='technology';
    	return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }

    public function fashion() {
        // dd("Before");
        $articles = file_get_contents('http://localhost:8001/fashion');

      // $ch = curl_init();
      //curl_setopt($ch, CURLOPT_URL,"http://charity.benefactory.dev/api/v1/causes/verify?q=$cause_id");
      // curl_setopt($ch, CURLOPT_URL, "http://192.168.0.113:8001/fashion");
      // curl_setopt($ch, CURLOPT_POST, 0);
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // $response = curl_exec($ch);
      // curl_close ($ch);
      // // dd();

      //   // dd(json_decode($response));
        $response_new = json_decode($articles, True);
        // $articles = $response_new->articles;
        // $articles = $response_new;
        // $articles = $response_new['articles'];
        $articles = $response_new;
        // dd($articles);
        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['date']=$publishDate;
        }
        // dd($articles);
        $news_type = "Fashion News";
        $trending_category_flag= "fashion";
        return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));

    }

    public function selfDev() {
        $articles = file_get_contents('http://localhost:8001/self_dev/');
        $response_new = json_decode($articles, True);
        $articles = $response_new;
        foreach ($articles as $key => $value) {
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['date']=$publishDate;
            $articles[$key]["source"]['name']="NA";
        }
        $news_type = "Self Development";
        $trending_category_flag= "self development";
        return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));
    }

    public function entrepreneurship() {
        $articles = file_get_contents('http://localhost:8001/entrepreneurship/');
        $response_new = json_decode($articles, True);
        // dd($response_new);
        $articles = $response_new;
        foreach ($articles as $key => $value) {
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['date']=$publishDate;
            $articles[$key]["source"]['name']="NA";
        }
        // dd($articles);
        $news_type = "Entrepreneurship";
        $trending_category_flag= "entrepreneurship";
        return view("trending_category.new_index", compact('articles', 'news_type', 'trending_category_flag'));
    }



    public function trendingNews() {
		$response = file_get_contents('https://newsapi.org/v2/everything?domains=dailymail.co.uk&apiKey=1c128e3aadde471f842601390b1f598c');
		$response_new = json_decode($response, True);
		// $articles = $response_new->articles;
		$articles = $response_new['articles'];


        foreach ($articles as $key => $value) {
            // dd($value['title']);
            $url = $value['url'];
            $response = Article::where('main_source', $url)->first();
            if ($response) {
                unset($articles[$key]);
            }
        }
        foreach ($articles as $key => $value) {

            $publishDate = $value['publishedAt'];
            $convertedPublishDate = self::articlePublishTimeConverter($publishDate);
            $articles[$key]['publishedAt']=$convertedPublishDate;
        }


        $news_type = "Trending News";
    	return view("trending_category.new_index", compact('articles', 'news_type'));
    }

    public function view(Request $request, $id) {
    	$category = Category::find($id);
    	return view("categories.views", compact('category'));

    }

    public function create(Request $request) {
    	return view("trending_category.create");
    }
    public function store(Request $request) {
    	try {

	    	// dd($request->all());
	    	$trending_category = new TrendingCategory();
	    	$trending_category->trending_title = $request->trending_category_title;
			$target_dir = "assets/imgs/article_imgs/";
			$trending_category->trending_category_image = $target_dir.''.$_FILES["trending_category_image"]["name"];
			$target_file = $target_dir . basename($_FILES["trending_category_image"]["name"]);

			move_uploaded_file($_FILES["trending_category_image"]["tmp_name"], $target_file);

	    	$trending_category->save();
	    	return redirect('/show_trending_category');
	    		
    	} catch (Exception $e) {
			return view("error");    		
    	}

    }
    public function destroy(Request $request, $id) {
    	// dd(1);
    	$category = Category::find($id);
    	$category->delete();

    	return redirect('/show_category');
    }

    // public function notifyVolvAppUser() {
    //     fcm()
    //         ->to($recipients) // $recipients must an array
    //         ->priority('high')
    //         ->data([
    //             'title' => 'Test FCM',
    //             'body' => 'This is a test of FCM',
    //         ])
    //         ->send();
    // }
}
