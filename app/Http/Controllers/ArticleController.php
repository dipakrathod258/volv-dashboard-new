<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Article;
use App\Author;
use App\Category;
use App\TrendingCategory;
use App\ArticleStatus;
use App\ArticleAuthorHistory;
use App\ArticleAuthorSummary;
use App\ArticleDeleteProof;
use App\ArticlePublishTime;
use App\WeekendArticle;
use App\ArticlePoll;
use App\ArticleBreakingNews;
use App\State;
use App\ArticleBias;
use App\Services\ExtractiveService;
use App\RepublishableArticle;
use App\ArticleHashtags;
use App\User;
use App\VolvAppUser;
use App\ArticleBiasedSentences;
use App\ArticleSentenceBias;

use validate;
use DB;
use PDF;
use Excel;
use Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;
use File;
use League\ColorExtractor\Palette;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use App\Publisher;
use Log;

class ArticleController extends Controller
{

    public static function timeCalculate() {
        $a= gmdate('Y-m-d H:i:s', time());
        $first_date = new DateTime("2019-10-04T12:52:00Z");
        $second_date = new DateTime($a);
        $difference = $first_date->diff($second_date)->format("%d days, %h hours and %i minuts");
    }

    public static function articlePublishTimeConverter($publish_date) {
        $a = date('Y-m-d H:i:s', time());
        $first_date = new DateTime($publish_date);
        $second_date = new DateTime($a);
        $difference = $first_date->diff($second_date)->format("%h hrs %i mins ago");
        $response = $difference;
        return $response;
    }

    public static function secondsConverter($timeSecond) {
        $timeFirst  = strtotime(date('Y-m-d H:i:s', time()));
        $timeSecond = strtotime($timeSecond);
        $differenceInSeconds =  $timeFirst - $timeSecond;    
        return $differenceInSeconds;
    }

    public static function timeConverter($articles) {
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
        return $articles;
    }

    public function index(Request $request) {
        // $articles = DB::table('articles')->orderBy('updated_at', 'desc')->paginate(15);
        $articles = DB::table('articles')
        ->leftJoin('publishers', 'articles.article_publisher', '=', 'publishers.id')
        ->select('articles.*', 'publishers.publisher_title')
        ->orderBy('updated_at', 'desc')
        ->paginate(15);

        // dd("articles");
        // dd($articles);

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
                ->leftJoin('publishers', 'articles.article_publisher', '=', 'publishers.id')
                ->select('articles.*', 'weekend_articles.publish_datetime', 'publishers.publisher_title')
                ->where('article_heading', 'like', "%".$keyword."%" )
                ->orWhere('article_summary', 'like', "%".$keyword."%" )
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
                $currentPage=$articles->currentPage();

                // $articles = Article::where('article_heading', '%' . $keyword . '%')->get();
                // $articles = DB::table('articles')
                // ->where('article_heading', 'like', "%".$keyword."%" )
                // ->orderBy('updated_at', 'desc')
                // ->paginate(15);        

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
                ->leftJoin('publishers', 'articles.article_publisher', '=', 'publishers.id')
                ->select('articles.*', 'publishers.publisher_title')
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
                ->leftJoin('publishers', 'articles.article_publisher', '=', 'publishers.id')
                ->select('articles.*', 'publishers.publisher_title')
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
                ->leftJoin('publishers', 'articles.article_publisher', '=', 'publishers.id')
                ->select('articles.*', 'publishers.publisher_title')
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
                ->leftJoin('publishers', 'articles.article_publisher', '=', 'publishers.id')
                ->select('articles.*', 'publishers.publisher_title')
                ->where('article_author','LIKE',$author)
                ->where('article_status','LIKE',$status)
                ->where('article_category','LIKE',"%".$category."%")
                ->where('article_priority','LIKE',$priority)
                ->whereBetween('articles.updated_at', [$start_dates.' 00:00:00',$end_dates.' 23:59:59'])
                ->orderBy('articles.updated_at', 'desc')
                ->paginate(15);
            }

            $currentPage=$articles->currentPage();

            $articles = self::timeConverter($articles);
            $articles = self::convertTimeFormat($articles);
            $view = view('articles.filer_table',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','currentPage'))->render();
            // dd($view);
            return response()->json(['html'=>$view]);
        }

    //    //dummy data for checking
    //     $articles=DB::table('articles')
    //     ->where('article_author','LIKE',"Dipak Rathod")
    //     ->where('article_status','LIKE',"%")
    //     ->where('article_category','LIKE',"%")
    //     ->where('article_priority','LIKE',"%")
    //     ->whereBetween('updated_at', ['2019-10-12'.' 00:00:00','2020-05-23'.' 23:59:59'])
    //     ->orderBy('updated_at', 'desc')
    //     ->paginate(5);
    //     dd($articles->currentPage());
        $articles = self::timeConverter($articles);
        $articles = self::convertTimeFormat($articles);
        //Extra Logic
        
        $article_end_date = DB::select("SELECT updated_at FROM  articles LIMIT 1;");
        $start_date=explode(" ",$article_end_date[0]->updated_at)[0];
        $end_date=explode(" ",$articles[0]->updated_at)[0];
        // dd($start_date,$end_date);
        $is_publisher_article = null;
        return view('index', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','start_date','end_date','currentPage', 'is_publisher_article'));
    }

    public static function convertTimeFormat($articles) {
        $weekend_articles = WeekendArticle::all();
        foreach($articles as $key=>$article) {
            $time_stamp = explode(' ', $article->updated_at);
            // dd($time_stamp[1]);
            $time_stamp = date("g:i a", strtotime($time_stamp[1]));
            $article->time_stamp = $time_stamp;        
        }
        return $articles;
    }

    public function myDashboard(Request $request) {
        
        $articles = DB::table('articles')->where('article_author', Auth()->user()->name)->orderBy('updated_at', 'desc')->paginate(15);
        $currentPage=$articles->currentPage();
        $articles = $articles->items();
        $articles = self::timeConverter($articles);
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();

        if ($request->ajax()) {
            $keyword = $request->keyword;
            if(isset($keyword)) {
                // $articles = Article::where('article_heading', '%' . $keyword . '%')->get();
                $articles = DB::table('articles')
                ->where('article_author', Auth()->user()->name)
                ->where('article_heading', 'like', "%".$keyword."%" )
                ->orWhere('article_summary', 'like', "%".$keyword."%" )
                ->orderBy('updated_at', 'desc')
                ->paginate(15);
                $currentPage=$articles->currentPage();
                $articles = $articles->items();

                $articles = self::timeConverter($articles);
                $authors = Author::all();
                $users = User::all();
                $categories = Category::all();
                $states = State::all();
                $priorities = array("Urgent", "Needs Coverage");
                $article_statuses = ArticleStatus::all();       
                $articles = self::convertTimeFormat($articles);         
                $view = view('articles.my_dashboard_filter_table',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','currentPage'))->render();
                return response()->json(['html'=>$view]);
            }

            ///////////////////////////////////Article Ajax Call Logic Starts///////////////////////////////////
            $author = Auth()->user()->name;
            $status = $request->status;
            $category = $request->category;
            $priority = $request->priority;
            $start_dates=$request->start_date;
            $end_dates=$request->end_date;

            $articles=DB::table('articles')
            ->where('article_author','LIKE',$author)
            ->where('article_status','LIKE',$status)
            ->where('article_category','LIKE',"%".$category."%")
            ->where('article_priority','LIKE',$priority)
            ->whereBetween('updated_at', [$start_dates.' 00:00:00',$end_dates.' 23:59:59'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);
            $currentPage=$articles->currentPage();
            $articles = self::timeConverter($articles);
            $articles = self::convertTimeFormat($articles);
            $view = view('articles.my_dashboard_filter_table',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users','currentPage'))->render();
            // dd($view);
            return response()->json(['html'=>$view]);
         }

            // $author = Auth()->user()->name;
            // $status = $request->status;
            // $category = $request->category_milestone;
            // $priority = $request->priority;
            // if($status == "Any"  && $category == "None" && $priority == "Any") {
            //     // dd($author);
            //     $articles = DB::table('articles')->where('article_author', $author)->orderBy('updated_at', 'desc')->paginate(15);
            // }
            // if($status != "Any"  && $category == "None" && $priority == "Any") {
            //     // dd($status);

            //     $articles = DB::table('articles')->where([
            //         ['article_author', '=', $author],
            //         ['article_status', '=', $status]])
            //  ->orderBy('updated_at', 'desc')->paginate(15);


            // }
            // if($status == "Any"  && $category != "None" && $priority == "Any") {

            //     $articles = DB::table('articles')->where([
            //         ['article_author', '=', $author],
            //         ['article_category', '=', $category]])
            //  ->orderBy('updated_at', 'desc')->paginate(15);

            // }


            // if($status == "Any"  && $category == "None" && $priority != "Any") {
            //     // dd($status);
            //     $author = Auth()->user()->name;
            //     $articles = DB::table('articles')->where([
            //                                             ['article_author', '=', $author],
            //                                             ['article_priority', '=', $priority]])
            //                                      ->orderBy('updated_at', 'desc')->paginate(15);

            // }

            // if($status != "Any"  && $category != "None" && $priority == "Any") {
            //     // dd($status);
            //     $articles = DB::table('articles')->where([
            //                                             ['article_author', '=', $author],
            //                                             ['article_status', '=', $status],
            //                                             ['article_category', '=', $category]])
            //                                      ->orderBy('updated_at', 'desc')->paginate(15);

            // }

            // if($status == "Any"  && $category != "None" && $priority != "Any") {
            //     // dd($status);
            //     $articles = DB::table('articles')->where([
            //                                             ['article_author', '=', $author],
            //                                             ['article_priority', '=', $priority],
            //                                             ['article_category', '=', $category]])
            //                                      ->orderBy('updated_at', 'desc')->paginate(15);

            // }

            // if($status != "Any"  && $category == "None" && $priority != "Any") {
            //     // dd($status);
            //     $articles = DB::table('articles')->where([
            //                                             ['article_author', '=', $author],
            //                                             ['article_status', '=', $status],
            //                                             ['article_priority', '=', $priority]])
            //                                      ->orderBy('updated_at', 'desc')->paginate(15);

            // }

            // if($status != "Any"  && $category != "None" && $priority != "Any") {
            //     // dd($status);
            //     $articles = DB::table('articles')->where([
            //                                             ['article_author', '=', $author],
            //                                             ['article_priority', '=', $priority],
            //                                             ['article_status', '=', $status],
            //                                             ['article_category', '=', $category]])
            //                                      ->orderBy('updated_at', 'desc')->paginate(15);

            // }


        $articles = self::convertTimeFormat($articles);
        // dd(Auth()->user()->name);
        $article_start_date = DB::select("SELECT updated_at FROM  articles where article_author=? LIMIT 1 ",[Auth()->user()->name]);        
        $start_date=explode(" ",$article_start_date[0]->updated_at)[0];
        $end_date=explode(" ",$articles[0]->updated_at)[0];
        
        // dd($end_date);

        return view('my_dashboard', compact('start_date','end_date','articles', 'priorities', 'authors','categories','article_statuses','states','users','currentPage'));
    }

    public function extractArticle() {
        $response = ExtractiveService::extractive();
        return view('articles.extractive_text_summarization');
    }

    public function publishArticle(Request $request, $article_id) {
        dd("welcom");
        DB::table('articles')
            ->where('id', $article_id)
            ->update(['publish_article' => 'Y']);

    	return redirect()->back();
    }

    public function checkBiasNews(Request $request) {
        return view("articles.check_bias_news");
    }

    public function submitNews(Request $request) {
        // dd($request->all());

        $corpus = ["Serious","serious","Refuse","refuse","Crucial","crucial","High-stakes","high-stakes","Tirade","tirade","Crucial","crucial","Latest in a string of","latest in a string of","Turn up the heat","turn up the heat","Critical","critical","Decrying","decrying","Offend","offend","Stern talks","stern talks","Offensive","offensive","Facing calls to","Monumental","monumental","Significant","significant","High-stakes","high-stakes","Finally","finally","Surfaced","surfaced","acknowledged","Acknowledged","Emerged","emerged","Refusing to say","Conceded","conceded","Dodged","dodged","Admission","admission","Came to light","came to light","Admit to","admit to","Mocked","mocked","Raged","raged","Bragged","bragged","Fumed","fumed","Lashed out","lashed out",
        "Incensed","incensed","Scoffed","scoffed","Frustration","frustration","Erupted","erupted","Rant","rant","Boasted","boasted",
        "Gloated","gloated","Good","good","better","Better","best","Best",
        "Is considered to be","is considered to be","Seemingly","seemingly","Extreme","extreme","May mean that","may mean that","Could","could","Apparently","apparently","Bad","bad","Worse","worse","Worst","worst",
        "It is likely that","it's likely that","Dangerous","dangerous","Suggests","suggests","Would seem","would seem","Decrying","decrying","Possibly","possibly","Shocking","shocking","Remarkable","remarkable","Rips","rips","Chaotic","chaotic","Lashed out","lashed out","Onslaught","onslaught","Scathing","scathing","Showdown","showdown","Explosive","explosive","Slams","slams","Forcing","forcing",
        "Warning","warning","Embroiled in","embroiled in","torrent of tweets","Torrent of tweets","Desperate","desperate","disappointing","row","limited","cost",
        "doesn't win","failed to win","failed to gain","wasn't to be","failed","vulnerable","fell short","reflection","lost control","big questions","big question","peak Corbyn","no faith","no overall control","some gains","Gloat","gloat"
        ,"stutter","hopes evaporated","stall","muted celebration","reverse","went down","had to travel to celebrate","didn't hold on",
        "not a win","not making progress","small steps rather than big strides","consolidating","puzzled","difficulty","standing still","major gains","snatched","pleased","more work to be done","substancial margin","substancial","victory","focused","celebrate","hold on","lose","good","hung on","took control","taken from them",
        "gains","disappoitment","rock solid","relief","unexpected gains","picked up","break open the hob nobs","much better",
        "bad","personally","illegal",
        "doubt","torture","lobbyists",
        "stop","bad","blame","doubt","wrong","saturate","prejudice","blatant","proliferation","seminal","threaten", "overwhelmingly", "overwhelmed", "overwhelm" ];

        // dd($corpus);
        $article = $request->article;
        // dd($article);
        $highligh_words = [];
        foreach($corpus as $word) {
            // $word = "/\"".$word."\b/";
            // $word =" /{$word}/i ";
            $word = " ".$word;
            if(strpos($article, $word)) {
            // if(preg_match($word, $article)) {                
                array_push($highligh_words, $word);
            }
        }
        // dd($article);
        return $highligh_words;
    }

    public function searchArticle($keyword) {
        // $keyword = $request->keyword;
        // dd($request->searchArticle);                

        $articles = Article::where('article_heading', 'LIKE', '%' . $keyword . '%')
        ->orWhere('article_summary', 'LIKE', '%' . $keyword . '%')
        ->orWhere('article_summary', 'LIKE', '%' . $keyword . '%')
        ->paginate(10);
        dd($articles);

        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();
        return view('index', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));
    }

    public function createArticle(Request $request) {
        $article = $request->result_article;
    	$authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        $sub_categories = ArticleHashtags::all();
        $trending_categories = TrendingCategory::all();
    	return view('articles.create', compact('article', 'authors','categories','trending_categories', 'sub_categories', 'publishers'));
    }

    public function submitTrendingArticle(Request $request) {
        $data = explode('|', $request->article_priority);
        $article_priority_value = $data[0];
        $article_title = $request->article_heading;
        $response = Article::where('article_heading', $article_title)->first();
        if ($response) {
            $status["status"]="This article already exists!";
            return $status;
        }

        $article = new Article();
        $article->article_heading = $article_title;
        $article->article_author = "--NA--";
        $article->article_summary = "--NA--";
        $article->main_source = $request->article_url;
        $article->article_image = "--NA--";
        $article->article_category = "--NA--";
        $article->left_color = '00ff00'; 
        $article->right_color = '0000ff';
        $article->article_status = "Pending";
        $article->button_class = "btn btn-default";
        $article->priority_button_class = $article_priority_value;
        $article->priority_class = $request->button_class;

        if ($article->save()) {
            $data = new ArticleAuthorHistory();
            $data->article_id = $article->id;
            $data->save();
            return response()->json(['status' => 'success']);
        }

        else {
            return redirect('/');
        }
    }

    public function ArticleAuthorHistory($article_id, $user_id, $article_heading, $article_summary,$article_status, $notification_text_history, $created_at, $updated_at) {
        $data = new ArticleAuthorHistory();
        $data->article_id = $article_id;
        $data->user_id = $user_id;
        $data->article_heading = $article_heading;
        $data->article_summary = $article_summary;
        $data->article_status = $article_status;
        $data->notification_text = $notification_text_history;
        $data->created_at = $created_at;
        $data->updated_at = $updated_at;
        $response["status"]="success";
        if($data->save()) {
            return $response;
        }
        else {
            return $response["status"]="faulre";
        }
    }

    public function articleAuthorHistoryDetails($article_id) {
        $article_details = DB::select("select users.name, article_author_histories.article_heading, article_author_histories.article_status, article_author_histories.article_summary, article_author_histories.notification_text,article_author_histories.created_at, article_author_histories.updated_at from article_author_histories
        left join users on article_author_histories.user_id = users.id where article_id=".$article_id.";");
        foreach ($article_details as $key => $value) {
            $created_at = $value->created_at;
            $updated_at = $value->updated_at;
            $convertedcreatedAt = self::articlePublishTimeConverter($created_at);
            $convertedupdatedAt = self::articlePublishTimeConverter($updated_at);
            $article_details[$key]->created_at = $convertedcreatedAt;
            $article_details[$key]->updated_at = $convertedupdatedAt;
        }
        return view('articles.article_author_history', compact('article_details'));
    }

    public static function copyImagePixelColor($image_url) {
        $image_name = basename($image_url);
        $save_url = $_SERVER['DOCUMENT_ROOT']."/assets/images/".$image_name;
        // dd($image_url);
        $fileContents = file_get_contents($image_url);
        File::put($save_url, $fileContents);

        $image_type = exif_imagetype($save_url);
        // dd($image_type);
        if($image_type == 2) {
            $im = imagecreatefromjpeg($save_url);
        }
        else if($image_type == 3){
            $im = imagecreatefrompng($save_url);
        }
        else if($image_type == 1){
            $im = imagecreatefromgif($save_url);
        }
        else if($image_type == 18){
            $im = imagecreatefromwebp($save_url);
        }
        else if($image_type == 4){
            $im = imagecreatefromswf($save_url);
        }
        else if($image_type == 5){
            $im = imagecreatefrompsd($save_url);
        }
        else if($image_type == 6){
            $im = imagecreatefrombmp($save_url);
        }

        list($width, $height, $type, $attr) = getimagesize($save_url);
        $left_px_height_margin = $height*0.011;
        
        $left_px_height = $height - $left_px_height_margin;
        $left_px_height1 = (int)$left_px_height;

        $right_px_width_margin = $width*0.095;
        $left_px_width = $width - $right_px_width_margin;
        $left_px_width1 = (int)$left_px_width;

        $rgb1 = imagecolorat($im, $left_px_width1, $left_px_height1); 
        $colors = imagecolorsforindex($im, $rgb1);
        $red = ($rgb1 >> 16) & 255; 
        $green = ($rgb1 >> 8) & 255; 
        $blue = $rgb1 & 255; 
        $left_px_color = sprintf("#%02x%02x%02x", $red, $green, $blue);


        $left_px_height_margin2 = $height*0.011;
        $left_px_height2 = $height - $left_px_height_margin2;
        $left_px_height2 = (int)$left_px_height2;

        $right_px_width_margin2 = $width*0.011;
        $left_px_width2 = $width - $right_px_width_margin2;
        $left_px_width2 = (int)$left_px_width2;

        $rgb2 = imagecolorat($im, $left_px_width2, $left_px_height2); 
        $colors = imagecolorsforindex($im, $rgb2); 

        $red = ($rgb2 >> 16) & 255; 
        $green = ($rgb2 >> 8) & 255;
        $blue = $rgb2 & 255;
        $right_px_color = sprintf("#%02x%02x%02x", $red, $green, $blue);

        $left_px_color = str_replace("#", "", $left_px_color);
        $right_px_color = str_replace("#", "", $right_px_color);

// ===========Take avg of pixel colors in article image begins         

// ===========Take avg of pixel colors in article image ends 
        $response["left_color_pixel"] = $left_px_color;
        $response["right_px_color"] = $right_px_color;
       return $response;
    }
    

    public function isSvg($url)
    {   
        $urlExploded = explode('.', $url);

        
        $extensions= array("svg");    
        $file_ext  = strtolower($urlExploded[count($urlExploded)-1]);

        if(in_array($file_ext,$extensions)=== true){
            return True;
        }
        else {
            return False;
        }
    }   
    

    public function submitArticle(Request $request) {

        $this->validate($request,[
            'article_heading'=> 'required',
            'article_summary'=> 'required',
            'main_source'=> 'required',
            'article_category'=> 'required',
        ]);
        $articles = Article::all();
        $counts = [];
        $article_heading = $request->article_heading;
        $aritlce_summary = $request->article_summary;
        $notification_text_history = $request->notification_text;
        $response = Article::where("article_heading", $article_heading)->first();
        if ($response) {
            $status["status"]="This article already exists!";
            return $status;
        }
    	$article = new Article();
        if (isset($request->publisher_title)) {
            $article->article_publisher = $request->publisher_title;
        }
        else{
            $article->article_publisher = 1;
        }

        Log::info("Articl Info", $request->all());
    	$article->article_heading = $request->article_heading;
    	$article->article_summary = $request->article_summary;
    	$article->notification_text = $request->notification_text;
        $article->article_author = $request->article_author;
        if (isset($request->article_video_link)) {
            $article_video_link = $request->article_video_link;
            // ====Check the video URL validation begins

            $headers = [
              'Content-Type' => 'application/json',
              'Content-Length' => 1
            ];

            $curl_get_url = "https://server.volvmedia.com/videoUrl?url=".$article_video_link;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curl_get_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close ($ch);
            $result = json_decode($response);
            // dd($result);  
            if ($result && $result->success) {
                $article->article_video_url = $result->value;
                $article->article_image = "https://firebasestorage.googleapis.com/v0/b/volvapp-afd6d.appspot.com/o/app_images%2Fvideo_update.gif?alt=media&token=1c66e851-a310-4d87-a2f2-660fb9064c05";
                $article_image_url = "https://firebasestorage.googleapis.com/v0/b/volvapp-afd6d.appspot.com/o/app_images%2Fvideo_update.gif?alt=media&token=1c66e851-a310-4d87-a2f2-660fb9064c05";
                $article->article_video_validity_checked = True;               
            } else {
                return response()->json(['status' => 'article video link invalid']);
            }

            // ====Check the video URL validation ends
        }
        else {
            $article->article_image = $request->article_image_url;
        }        

        $isSvgImage = self::isSvg($request->article_image_url);
        if($isSvgImage) {
            $response["status"] = "Article image URL is of SVG image";
            return $response;
        }
        $image_url_length = strlen($request->article_image_url);
        if ($image_url_length >200) {
            $response["status"] = "Encoded Article Image URL no allowed. Eg, 'data://image/jpeg......'";
            return $response;
        }


        if($request->notification_text==null){
            $article->notification_sent_status = null;
        }
        $article->notification_sent_status = 0;

        $article->button_class = "btn btn-default";
        $article->article_status = "In Progress";

        $left_color = $request->article_left_gradient;
        $right_color = $request->article_right_gradient;

        $article->left_color = ltrim($left_color, $left_color[0]); 
        $article->right_color = ltrim($right_color, $right_color[0]);


        //Browse article image starts
        if ($request->browse_article_image) {
            $uniqueFileName = uniqid() . $request->browse_article_image->getClientOriginalName();
            $img_dir = public_path('/assets/imgs/article_images/');
            $upload_success = $request->browse_article_image->move($img_dir, $request->browse_article_image->getClientOriginalName());
            $article_image_url = url('/').'/assets/imgs/article_images/'.$request->browse_article_image->getClientOriginalName();
            $article->article_image = $article_image_url; 
            $article_image_url = "https://volvmedia.com/assets/volv-logo-colorful-1.png"; 
        }
        //Browse article image ends

        if ($request->article_image_url) {
            $article_image_url = $request->article_image_url;
        }
        // dd($article_image_url);
        $response =self::cropImages($article_image_url);
        $left_px_color  = $response["left_px_color"];
        $right_px_color  = $response["right_px_color"];
        $article->left_color = $left_px_color;
        $article->right_color = $right_px_color;
        $article->read_more_text = $request->read_more_text;
        $article->read_more_text_color = "FFB37D";
        $subCategoryArray = $request->article_sub_category;
        if($subCategoryArray) {
            foreach($subCategoryArray as $subCategory) {
                $subCategory = str_replace("#", "", $subCategory);
                $subCategoryObj = new ArticleHashtags();
                $subCategoryObj->category_ids = implode(",", $request->article_category);
                $flag = ArticleHashtags::where("sub_category", $subCategory)->first();
                if(!$flag) {
                    $subCategoryObj->sub_category = $subCategory;
                    $subCategoryObj->save();    
                }
            }
        }
		$article_categories = $request->article_category;
		$article_category_string = implode(',', $article_categories);
        $article->article_category = $article_category_string;
        $article_sub_category = $request->article_sub_category;
        if($article_sub_category) {
            $article_sub_category_string = implode(',', $article_sub_category);
            $article_sub_category_string = str_replace("#", "", $article_sub_category_string);
            $article->article_subcategories = $article_sub_category_string;
        }
        $article_trending_categories = $request->trending_category;
        if ($article_trending_categories) {
		  $article_trending_category_string = implode(',', $article_trending_categories);
        }
        else {
          $article_trending_category_string = null;
        }
        $article->main_source = $request->main_source;
        $article->additional_sources = $request->additional_source;
    	$article->article_keywords = $request->article_keywords;
    	$article_targetting_states = $request->targetting_states;
        if ($article_targetting_states) {
    	   $article_targetting_states_list = implode(',', $article_targetting_states);
    	   $article->targetting_states = $article_targetting_states_list;
        }
        $news_type = $request->news;
        if($request->news == "breaking_news") {
            $article->breaking_news = true;
        }
        if($request->news == "trending_news") {
            $article->trending_news = true;
        }

            // =============Bias begins
            if($request->bias == "left") {
                $article->article_bias = "left";
            }
            if($request->bias == "right") {
                $article->article_bias = "right";
            }
            if($request->bias == "center") {
                $article->article_bias = "center";
            }
            // =============Additional Bias begins
            if($request->additional_bias == "left") {
                $article->additional_source_bias = "left";
            }
            if($request->additional_bias == "right") {
                $article->additional_source_bias = "right";
            }
            if($request->additional_bias == "center") {
                $article->additional_source_bias = "center";
            }
            // =============Additional Bias ends


    	if ($article->save()) {
            for ($i = 0; $i < count($request->biased_sentence); $i++) {
                $articleBiasSentence = new ArticleBiasedSentences();
                $articleBiasSentence->article_id = $article->id;
                $articleBiasSentence->biased_sentence = $request->biased_sentence[$i];
                $articleBiasSentence->biased_type = $request->biased_type[$i];
                $articleBiasSentence->save();
            }


            // ==== Calling SiteMap API starts
                    $data_to_post = [
                        "id" => $article->id,
                    ];

                    // dd($data_to_post);
                    $ch = curl_init();
                    // dd($ch);
                    curl_setopt($ch, CURLOPT_URL,"http://server.volvmedia.com/addToSitemap");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    // dd($response);
                    curl_close ($ch);
                    $data = json_decode($response , true);
            // ==== Calling SiteMap API ends            

            // ==== Calling Autolikes API starts
                    $data_to_post = [
                        "article_id" => $article->id,
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"https://server.volvmedia.com/v1/addAutoLikes");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close ($ch);
                    $data = json_decode($response , true);
            // ==== Calling Autolikes API ends


                // Calling Create And Save Audio starts
    
                $data_to_post = [
                    "articleId" => $article->id,
                    "articleHeading" => $article->article_heading,
                    "articleSummary" => $article->article_summary,
                    "deleteExisting" => false,
                ];
        
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://server.volvmedia.com/v1/createAndSaveAudio");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close ($ch);
    
                // Calling Create And Save Audio ENDS
            

            $auth_id = auth()->user()->id;
            $article_id = $article->id;
            $aritlce_status = "In Progress";
            $created_at = $article->created_at;
            $updated_at = $article->updated_at;
            if($request->republishable == "republishable") {
                $data = new RepublishableArticle();
                $data->article_id = $article->id;
                $data->save();
            }
            $response = self::ArticleAuthorHistory($article_id, $auth_id, $article_heading, $aritlce_summary, $aritlce_status, $notification_text_history,$created_at, $updated_at);
            if($response["status"]=="success") {
                return response()->json(['status' => 'success']);
            }
            else if($response["status"]=="failue") {
                return response()->json(['status' => 'failure']);
            }

        }

		else {
    		return redirect('/');
		}
    }

    public function addState(Request $request) {

        $states = "Alabama|Alaska|Arizona|Arkansas|California|Colorado|Connecticut|Delaware|District of Columbia|Florida|Georgia|Hawaii|Idaho|Illinois|Indiana|Iowa|Kansas|Kentucky|Louisiana|Maine|Maryland|Massachusetts|Michigan|Minnesota|Mississippi|Missouri|Montana|Nebraska|Nevada|New Hampshire|New Jersey|New Mexico|New York|North Carolina|North Dakota|Ohio|Oklahoma|Oregon|Pennsylvania|Rhode Island|South Carolina|South Dakota|Tennessee|Texas|Utah|Vermont|Virginia|Washington|West Virginia|Wisconsin|Wyoming";

        $state_array = explode("|", $states);
        foreach ($state_array as $key => $value) {
            $state = new State();
            $state->state_name = $value;
            $state->save();
        }
    }

    public function editArticle(Request $request, $id) {
    	$article = Article::find($id);
        // dd($id);
        $article_heading_word_count = str_word_count($article->article_heading);
        $article_heading_char_count = strlen($article->article_heading);
        $article_heading_max_word_error_flag=null;
        $article_heading_max_char_error_flag=null;
        // if ($article_heading_word_count>12) {
        //     $article_heading_max_word_error_flag = True;
        // }
        if ($article_heading_char_count>75) {
            $article_heading_max_char_error_flag = True;
        }

        $article_summary_word_count = str_word_count($article->article_summary);
        $article_summary_char_count = strlen($article->article_summary);

        $article_author = $article->article_author;

        $republishable_article = RepublishableArticle::where('article_id', $id)->first();
        // dd($republishable_article);

        if ($republishable_article) {
            $republishable_article_flag = True;
        }
        else{
            $republishable_article_flag =  null;
        } 



        $categories = Category::all();
        $minihashtags = ArticleHashtags::all();
        $states = State::all();
        $trending_categories = TrendingCategory::all();
        $article_categories = explode(',', $article->article_category);
        // dd($article_categories);
        $article_subcategories = explode(',', $article->article_subcategories);
        // dd($article_subcategories);
        $article_trending_categories = explode(',', $article->article_trending_category);
        $targetting_states = explode(',', $article->targetting_states);
        // dd($article_subcategories);
        $readMoreArray = [$article->read_more_text];

        $readMoreTextArray = ["Check it out", "Check out the post", "Check out the video", "Check out the insta","Make a donation", "Check out newsletter", "Check out the TikTok"];
// ======Edit Article Bias begins
        // $article_bias = ArticleBias::where('article_id', $id)->first();
// ======Edit Article Bias ends
        
        return view('articles.edit', compact('article','categories','trending_categories','article_categories','article_trending_categories','targetting_states','states', 'article_heading_word_count', 'article_heading_char_count', 'article_summary_word_count', 'article_summary_char_count','article_heading_max_word_error_flag','article_heading_max_char_error_flag', 'article_author', 'article_subcategories', 'minihashtags', "readMoreTextArray", "readMoreArray", "republishable_article_flag"));
    }


    public function updateArticle(Request $request, $id) {
        // dd($request->all());
        $this->validate($request,[
            'article_heading'=> 'required',
            'article_summary'=> 'required',
            'main_source'=> 'required',
            'article_category'=> 'required',
        ]);
        $article_heading = $request->article_heading;
        $notification_text_history = $request->notification_text;

        $article = Article::find($id);
        $article->article_heading = $request->article_heading;
        $article->article_summary = $request->article_summary;
        $article->article_author = $request->article_author;

        $isSvgImage = self::isSvg($request->article_image_url);
        if($isSvgImage) {
            $response["status"] = "Article image URL is of SVG image";
            return $response;
        }

        $image_url_length = strlen($request->article_image_url);
        // dd($image_url_length);

        if ($image_url_length >200) {
            $response["status"] = "Encoded Article Image URL no allowed. Eg, 'data://image/jpeg......'";
            return $response;
        }


        if($request->notification_text == null) {
            $article->notification_text = null;
            $article->notification_sent_status = null;
        }
        else {
            $article->notification_text = $request->notification_text;
            $article->notification_sent_status = 0;
        }


        if($request->news == "breaking_news") {
            $article->breaking_news = true;
            $article->trending_news = false;
            // dd("break");
        }
        if($request->news == "trending_news") {
            $article->trending_news = true;
            $article->breaking_news = false;
        }

// ========Update Article Bias begins


        if($request->bias == "left") {
            $article->article_bias = "left";
        }

        if($request->bias == "right") {
            $article->article_bias = "right";
            // dd("break");
        }
        if($request->bias == "center") {
            $article->article_bias = "center";
        }

// ========Update Article Bias ends



// ========Update embedded link begins

// if($request->embedded == "Yes") {
//     $article->is_embed_link = "Yes";
// }

// if($request->embedded == "No") {
//     $article->is_embed_link = "No";
//     // dd("break");
// }

// ========Update embedded link ends


// ========Update additional source article Bias begins


if($request->additional_bias == "left") {
    $article->additional_source_bias = "left";
}

if($request->additional_bias == "right") {
    $article->additional_source_bias = "right";
    // dd("break");
}
if($request->additional_bias == "center") {
    $article->additional_source_bias = "center";
}

// ========Update additional source article Bias ends
        $article->read_more_text = $request->read_more_text;


        if(isset($request->article_image_url)) {
            $article->article_image = $request->article_image_url;            
        }
        else {
            $article->article_image = null;            
        }


        $article_image_url = $request->article_image_url;
        $article_video_link = $request->article_video_link;
            // ====Check the video URL validation begins
            if($request->article_video_link && ($article->article_video_url != $request->article_video_link)) {
                $headers = [
                  'Content-Type' => 'application/json',
                  'Content-Length' => 1
                ];

                $curl_get_url = "https://server.volvmedia.com/videoUrl?url=".$article_video_link;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $curl_get_url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close ($ch);
                $result = json_decode($response);
                // dd($result);
                if ($result && $result->success) {
                    $article->article_video_url = $result->value;
                    $article->article_image = "https://firebasestorage.googleapis.com/v0/b/volvapp-afd6d.appspot.com/o/app_images%2Fvideo_update.gif?alt=media&token=1c66e851-a310-4d87-a2f2-660fb9064c05";
                    $article_image_url = "https://firebasestorage.googleapis.com/v0/b/volvapp-afd6d.appspot.com/o/app_images%2Fvideo_update.gif?alt=media&token=1c66e851-a310-4d87-a2f2-660fb9064c05";                
                } else {
                    return response()->json(['status' => 'article video link invalid']);
                }
            }

            // ====Check the video URL validation ends



        $image_name = basename($article_image_url);

        $data = RepublishableArticle::where("article_id", $id)->first();

        if(!$request->republishable) {
            $data = RepublishableArticle::where("article_id", $id)->first();
            if(isset($data)) {
                $data->delete();
            }
        }
        else {
            $data = new RepublishableArticle();
            $data->article_id = $id;
            $data->save();
        }

        // $response = self::copyImagePixelColor($article_image_url);
        // $left_px_color  = $response["left_color_pixel"];
        // $right_px_color  = $response["right_px_color"];
        if(isset($article_image_url)) {
            $response =self::cropImages($article_image_url);
            $left_px_color  = $response["left_px_color"];
            $right_px_color  = $response["right_px_color"];
            $article->left_color = $left_px_color; 
            $article->right_color = $right_px_color;
        } else {
            $article->left_color = null;
            $article->right_color = null;            
        }


        $article_categories = $request->article_category;
        $article_category_string = implode(',', $article_categories);
        $article->article_category = $article_category_string;
        
        

        $article_sub_category = $request->article_sub_category;
        if($article_sub_category) {
            $article_sub_category_string = implode(',', $article_sub_category);
            $article->article_subcategories = $article_sub_category_string;        
    
            $subCategoryArray = $request->article_sub_category;
    
            foreach($subCategoryArray as $subCategory) {
                $subCategory = str_replace("#", "", $subCategory);
    
                $subCategoryObj = new ArticleHashtags();
                $subCategoryObj->category_ids = implode(",", $request->article_category);
    
                $flag = ArticleHashtags::where("sub_category", $subCategory)->first();
                // dd(!$flag);
                if(!$flag) {
                    // $status["status"]="This sub category already exists!";
                    // $status["status"][]=$subCategory;
                    // return $status;
                    $subCategoryObj->sub_category = $subCategory;
                    $subCategoryObj->save();
    
                }
    
            }
        }
        else if($article_sub_category == null) {
            $article->article_subcategories = null;
        }
        


        $article->main_source = $request->main_source;
        $article->additional_sources = $request->additional_source;

        $article->article_keywords = $request->article_keywords;

        $article_targetting_states = $request->targetting_states;
        if ($article_targetting_states) {
           $article_targetting_states_list = implode(',', $article_targetting_states);
           $article->targetting_states = $article_targetting_states_list;
        }

        if ($article->save()) {
            $auth_id = auth()->user()->id;
            $article_id = $article->id;
            $created_at = $article->created_at;
            $updated_at = $article->updated_at;
            $article_heading = $request->article_heading;
            $article_summary = $request->article_summary;
            $aritlce_status = Article::select('article_status')->where('id', $article_id)->first();
            $article_status = $aritlce_status->article_status;

                // Calling Create And Save Audio starts
    
                $data_to_post = [
                    "articleId" => $article->id,
                    "articleHeading" => $article_heading,
                    "articleSummary" => $article_summary,
                    "deleteExisting" => true,
                ];
        
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://server.volvmedia.com/v1/createAndSaveAudio");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close ($ch);
    
                // Calling Create And Save Audio ENDS



            $response = self::ArticleAuthorHistory($article_id, $auth_id, $article_heading, $article_summary, $article_status, $notification_text_history,$created_at, $updated_at);
            if($response["status"]=="success") {

                // $image_path = $_SERVER['DOCUMENT_ROOT']."/assets/images/".$image_name;
                // if($image_path) {
                //     unlink($image_path);
                // }

                return response()->json(['status' => 'success']);
            }
    
            return response()->json(['status' => 'success']);
        }

        else {
            return redirect('/');
        }
    }

    public function viewArticle(Request $request, $id) {
        $article = Article::find($id);
        $states = State::all();
        $categories = Category::all();
        $sub_categories = ArticleHashtags::all();
        // dd($sub_categories);
        $article_categories = explode(',', $article->article_category);
        $article_subcategories = explode(',', $article->article_subcategories);
        $targetting_states = explode(",", $article->targetting_states);  

        $article_bias = ArticleBias::where('article_id', $id)->first();

        
        return view('articles.view', compact('article','article_bias','states', 'targetting_states', 'article_categories', 'categories','sub_categories', 'article_subcategories'));
    }

    public function destroyArticle(Request $request, $id) {
        $data = Article::find((int)$id);

        if($data->delete()) {

            $data = new ArticleDeleteProof();
            $data->article_id = $id;
            $data->article_heading = $data->article_heading;
            $data->uid = Auth()->user()->id;
            $data->save();

            $response["status"]="Article deleted successfully!";
            return $response;
  		}
    }

    public function filterArticleTable(Request $request) {
        $state = $request->state;
        // dd($state=="All");
        // dd($state);
        if ($state=="All") {
            $articles = Article::all();
            // dd($articles);
        }
        else {
            $articles = DB::table('articles')->where('article_author' ,'=', $state )->get(); 
        }
        // dd($articles); 
        $categories = Category::all();
        $authors = Author::all();
        $users = User::all();
        $article_statuses = ArticleStatus::all();
        $users = User::all();
        // dd($articles);
        $priorities = array("Urgent", "Needs Coverage");

        $flag='user';
        return view('index', compact('articles', 'users','authors','categories','state','flag', 'article_statuses','priorities'));
    }

    public function filterArticleTableByCategory(Request $request) {
        $state = $request->state;
        $category = $state[0];
        $author = $state[1];
        $author_name=null;
        $author_flag = null;
        if ($author) {
            $author_flag = True;
            $author_name = $author;
        }
        $articles = DB::select("select * from articles where article_category="."'".$category."'"."AND  article_author="."'".$author."'"."order by updated_at desc");
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

        $categories = Category::all();
        // dd($categories);
        $article_statuses = ArticleStatus::all();
        $authors = Author::all();
        $users = User::all();
        $flag='category';
        $priorities = array("Urgent", "Needs Coverage");
        // dd($articles);
        $state = $category;
        return view('index', compact('articles', 'author_name', 'users', 'authors','author_flag', 'categories','state','flag','article_statuses', 'priorities'));
    }
    
    public function filterArticleTableByStatus(Request $request) {
        $state = $request->state;
        $article_statuses = ArticleStatus::all();
        $articles = DB::select("select * from articles where article_status="."'".$state."'"." order by updated_at desc");
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

        // dd($state); 
        $categories = Category::all();
        // dd($categories);
        $authors = Author::all();
        $users = User::all();
        $priorities = array("Urgent", "Needs Coverage");

        $flag='status';
        return view('index', compact('articles', 'users', 'authors','categories','state','flag','article_statuses','priorities'));
    }

    public function filterArticleDate(Request $request) {
        // dd($request->all());
        $date = $request->date;
        $start_date = date_create($date[0]);
        $start_date = date_format($start_date,"Y-m-d H:i:s");

        $end_date = date_create($date[1]);
        $end_date = date_format($end_date,"Y-m-d H:i:s");

        $article_statuses = ArticleStatus::all();        
        $articles = Article::whereBetween('created_at', [$start_date, $end_date])->get();

         foreach ($articles as $key => $value) {
            $seconds = self::secondsConverter($value["updated_at"]);
            if(!($seconds > 86400)) {
                $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                $articles[$key]->time_ago = $converted_time;            
            }
            else {
                $articles[$key]->time_ago = $value["updated_at"];  
            }
        }
    
        $categories = Category::all();
        $users = User::all();
        $authors = Author::all();
        $priorities = array("Urgent", "Needs Coverage");

        $flag='status';
        return view('index', compact('articles','start_date', 'users', 'end_date', 'authors','categories','flag','article_statuses','priorities'));
    }

    public function filterArticleDateMyDashboard(Request $request) {
        // dd($request->all());
        $date = $request->date;
        $start_date = date_create($date[0]);
        $start_date = date_format($start_date,"Y-m-d H:i:s");

        $end_date = date_create($date[1]);
        $end_date = date_format($end_date,"Y-m-d H:i:s");

        $article_statuses = ArticleStatus::all();        

        $articles = Article::where('article_author', auth()->user()->name)->whereBetween('created_at', [$start_date, $end_date])->get();        

         foreach ($articles as $key => $value) {
            $seconds = self::secondsConverter($value["updated_at"]);
            if(!($seconds > 86400)) {
                $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                $articles[$key]->time_ago = $converted_time;            
            }
            else {
            $articles[$key]->time_ago = $value["updated_at"];  
            }
        }

        $categories = Category::all();
        $users = User::all();
        $authors = Author::all();
        $priorities = array("Urgent", "Needs Coverage");

        $flag='status';
        return view('my_dashboard', compact('articles','start_date', 'users', 'end_date', 'authors','categories','flag','article_statuses','priorities'));
    }

    public function filterArticleTableByPriority(Request $request) {
        $state = $request->state;
        // dd($state);
        $article_statuses = ArticleStatus::all();


        if ($state=="Urgent") {
            $articles = DB::table('articles')->where('priority_button_class' ,'=', 'Urgent' )->get(); 
        }
        else if ($state == "Needs Coverage") {
            $articles = DB::table('articles')->where('priority_button_class' ,'=', 'Urgent' )->get();

        // dd($articles); 
        $categories = Category::all();
        // dd($categories);
        $authors = Author::all();
        // $articles = Article::all();
        $users = User::all();
        $priorities = array("Urgent", "Needs Coverage");

        $flag='priority';
        return view('index', compact('articles', 'users', 'authors','categories','state','flag','article_statuses','priorities'));
    }

}
    public function exportArticlePdf(){
        $articles = Article::all();
        $pdf = PDF::loadView('articles.article_pdf', compact('articles'));
        return $pdf->download('articles.pdf');

    }

   public function downloadExcel() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $articles = Article::all();
        
        $sheet->setCellValue('A1', "Article Heading");
        $sheet->setCellValue('B1', "Article Summary");
        $sheet->setCellValue('C1', "Author");
        $sheet->setCellValue('D1', "Category");
        $sheet->setCellValue('E1', "Status");

        $count =2;
        

        $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setAutoSize(true);

        foreach($articles as $article) {
            // $spreadsheet->getActiveSheet()->getRowDimension($count)->setRowHeight(50);
            $sheet->setCellValue('A'.$count, $article->article_heading);
            $sheet->setCellValue('B'.$count, $article->article_summary);
            $sheet->setCellValue('C'.$count, $article->article_author);
            $sheet->setCellValue('D'.$count, $article->article_category);
            if ($article->publish_article=='Y') {
                $sheet->setCellValue('E'.$count, "Published");
            }
            else if($article->publish_article=='N') {
                $sheet->setCellValue('E'.$count, "In Review");                
            }
            $count+=1;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('articles.xlsx');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");
    }

    public function changeArticleStatus(Request $request, $article_status, $article_id, $button_class) {

        $article = Article::find($article_id);
        $author_id = auth()->user()->id;
        // dd($article_id);

        $user_id = $author_id;     
        $article_heading = $article->article_heading;
        $article_summary = $article->article_summary;
        $notification_text_history = $article->notification_text;
        // $article_status = $article->article_status;
        $created_at = $article->created_at;
        $updated_at = $article->updated_at;
        
        $response = self::ArticleAuthorHistory($article_id, $user_id, $article_heading, $article_summary,$article_status, $notification_text_history,$created_at, $updated_at);
    // $article_author_history = ArticleAuthorHistory::find($article_id);
        $author_name = auth()->user()->name;
        if($article->article_author == '--NA--') {
            $article->article_author = $author_name;
            $article->save();

            DB::table('article_author_histories')
                ->where('article_id', $article_id)
                ->update(['article_author_thread' => auth()->user()->id]);
        }
        // DB::table('articles')
        //     ->where('id', $article_id)
        //     ->update(['article_status' => $article_status, 'button_class'=>$button_class]);
        
        $article = Article::find($article_id);
        $article->article_status = $article_status;
        $article->button_class = $button_class;
        $article->save();

        // dd($article_status); 
        if($article_status == 'Published') {

            $flag = ArticlePublishTime::where('article_id', $article_id)->first();
            // dd($flag);
            if(!$flag) {
                $data = new ArticlePublishTime();
                $data->article_id = $article_id;
                $data->save();
            }
        }
        if($article_status == 'Republished') {
            $flag = DB::select("delete from article_publish_times where article_id=".$article_id.";");
            $data = new ArticlePublishTime();
            $data->article_id = $article_id;
            $data->save();            
        }

        $response["author_name"] = $author_name;

        return $response;
        // dd("Done");    
    }

    public function changeArticleByPriority(Request $request, $article_priority, $article_id, $button_class) {
        // dd($article_priority);

        DB::table('articles')
            ->where('id', $article_id)
            ->update(['priority_button_class' => $article_priority, 'priority_class'=>$button_class]);
        // dd("Done");    
    }

    public function trendingNewsStoreArticle(Request $request) {
        dd($request->all());
    }

    public function showGuidelines(Request $request) {
        return view("articles.user_guidelines");
    }

    public function downloadUserGuidelines(Request $request) {
        $pathToFile = url('/')."/assets/volv_dashboard_user_guidelines";
        // dd($pathToFile);        
        // $name = "duc_dataset_request_form.pdf";
        $file= public_path(). "/assets/volv_dashboard_user_guidelines/duc_dataset_request_form.pdf";
        $headers = array(
              'Content-Type: application/pdf',
            );
        return Response::download($file, 'volv-dashboard-guidelines.pdf', $headers);

    }    

    public function uploadUserGuidelines(Request $request)
    {
        // dd($request->all());
        $uniqueFileName = uniqid() . $request->user_guidelines_file->getClientOriginalName();
        $img_dir = public_path('/assets/volv_dashboard_user_guidelines/');
        $upload_success = $request->user_guidelines_file->move($img_dir, $request->user_guidelines_file->getClientOriginalName());
        $success = 'File uploaded successfully.';
        return view('articles.user_guidelines', compact('success'));
    
    }

    public function changeArticleStatusInProgress(Request $request, $article_id) {
        DB::table('articles')
            ->where('id', $article_id)
            ->update(['article_status' => 'In Progress', 'button_class' => 'btn btn-info']);
     
        $status["status"]="success";
        return $status;
    }

    public function extractiveSummarizer() {
        return view('articles.extractive_text_summarization');
    }
    // public function publishedArticles(Request $request) {
    //     // dd($articles);
    //     $articles = DB::table('articles')->where('article_status','published')->orderBy('updated_at', 'desc')->paginate(25);
    //     $authors = Author::all();
    //     $users = User::all();
    //     $categories = Category::all();
    //     $states = State::all();
    //     $priorities = array("Urgent", "Needs Coverage");
    //     $article_statuses = ArticleStatus::all();


    //     if ($request->ajax()) {
    //         $articles = DB::table('articles')->where('article_status','published')->orderBy('updated_at', 'desc')->paginate(25);
    //         $articles = $articles->items();
    //         $articles = self::timeConverter($articles);
    //         $view = view('articles.data',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'))->render();
    //         return response()->json(['html'=>$view]);
    //     }

    //     // dd($a['items']);

    //     $articles = self::timeConverter($articles);
    //     // $authors = Author::all();
    //     // $users = User::all();
    //     // $categories = Category::all();
    //     // $states = State::all();
    //     // $priorities = array("Urgent", "Needs Coverage");
    //     // $article_statuses = ArticleStatus::all();
    //     return view('articles.published_articles', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));    
    // } 



    public function publishedArticles(Request $request) {
        // dd("w");
        // dd($articles);
        // $articles = DB::select("select * from articles order by FIELD(article_status, 'Pending', 'Needs Review', 'In Progress', 'Rollback','Rejected', 'Published');$
        // $articles = Article::where('article_status', 'Published')->get();

        // $articles = DB::select("select * from articles where article_status='Published' order by updated_at desc;");
        $articles = DB::table('articles')->where('article_status','published')->orWhere('article_status','Republished')->orderBy('updated_at', 'desc')->paginate(25);

        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();


        if ($request->ajax()) {
            $articles = DB::table('articles')->where('article_status','published')->orderBy('updated_at', 'desc')->paginate(25);

            $articles = $articles->items();
            // dd($articles);
            foreach ($articles as $key => $value) {
                $value=(array)$value;
                $seconds = self::secondsConverter($value["updated_at"]);
                if(!($seconds > 86400)) {
                    $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                    $articles[$key]->time_ago = $converted_time;            
                }
                else {
                    // dd($value);
                $articles[$key]->time_ago = $value["updated_at"];  
                }
            }
            $articles = self::convertTimeFormat($articles);
            $view = view('articles.data',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'))->render();
            return response()->json(['html'=>$view]);
        }
        foreach ($articles as $key => $value) {
            $value=(array)$value;
            $seconds = self::secondsConverter($value["updated_at"]);
            if(!($seconds > 86400)) {
                $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                $articles[$key]->time_ago = $converted_time;            
            }
            else {
                // dd($value);
            $articles[$key]->time_ago = $value["updated_at"];  
            }
        }
        // dd($articles);

        $articles = self::convertTimeFormat($articles);
        foreach($articles as $article) {
            $articleCategory = explode(",", $article->article_category);
            $article->article_category = $articleCategory;
        }
        // dd($articles);
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();
        return view('articles.published_articles', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));    
    } 



    public function inProgressArticles() {
    
        $articles = DB::select("select * from articles where article_status='In Progress' order by updated_at desc;");
        $articles = self::timeConverter($articles);
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();
        $articles = self::convertTimeFormat($articles);

        return view('articles.in_progress_articles', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));    
    }    
    public function needsReviewArticles() {
        $articles = DB::select("select * from articles where article_status='Needs Review' order by updated_at desc;");

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

        $articles = self::convertTimeFormat($articles);

        return view('articles.needs_review', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));    
    }

    public function rssFeedTech() {
        dd("welcome");
    }

    public function test(){
        return view('test');
    }
    public function test2(){
        return view('test2');
    }

    public static function noOfAppUsers() {
        $no_of_users = DB::select("SELECT count(*) as count FROM volv_app_users;");
        $app_user_count = $no_of_users[0]->count;
        return $app_user_count;
    }
    
    public function volvAppUsers() {
        $users = DB::select("SELECT count(*) as count from volv_users.volv_users;");
        $app_user_count = $users[0]->count;
        $users = DB::select("SELECT * FROM volv_users.volv_users order by created_at;");

        return view("articles.volv_app_users", compact('users', 'app_user_count'));
    }

    public function addPoll($id) {
        return view("articles.add_poll", compact('id'));
    }

    public function viewPoll() {
        
        $polls = ArticlePoll::all();

        $data = DB::select("
            SELECT ap.*, pr.option_selected, count(*) as count FROM volv.article_polls as ap
                left join poll_results as pr
                on ap.id = pr.poll_id
                where pr.option_selected = 'option1'
                group by pr.poll_id

                UNION ALL

                SELECT ap.*, pr.option_selected,count(*) as count FROM volv.article_polls as ap
                left join poll_results as pr
                on ap.id = pr.poll_id
                where pr.option_selected = 'option2'
                group by pr.poll_id
        ");
        // dd($data);
        $poll_bucket=[];
        foreach($data as $key => $poll) {

            if($poll->option_selected == "option1") {
                $poll_bucket[$poll->id]["poll_question"] = $poll->poll_question;
                $poll_bucket[$poll->id]["option1"] = $poll->option1;
                $poll_bucket[$poll->id]["option2"] = $poll->option2;
                $poll_bucket[$poll->id]["poll_image"] = $poll->poll_image;
                $poll_bucket[$poll->id]["option1_count"] = $poll->count;
                $poll_bucket[$poll->id]["left_color"] = $poll->left_color;
                $poll_bucket[$poll->id]["right_color"] = $poll->right_color;
                $poll_bucket[$poll->id]["created_at"] = $poll->created_at;
            }
            else if($poll->option_selected == "option2") {
                $poll_bucket[$poll->id]["poll_question"] = $poll->poll_question;
                $poll_bucket[$poll->id]["option1"] = $poll->option1;
                $poll_bucket[$poll->id]["option2"] = $poll->option2;
                $poll_bucket[$poll->id]["poll_image"] = $poll->poll_image;
                $poll_bucket[$poll->id]["option2_count"] = $poll->count;
                $poll_bucket[$poll->id]["left_color"] = $poll->left_color;
                $poll_bucket[$poll->id]["right_color"] = $poll->right_color;
                $poll_bucket[$poll->id]["created_at"] = $poll->created_at;
            }
        }
        $poll_obj = [];
        $i=0;
        // dd($poll_bucket);
        foreach ($poll_bucket as $key => $pb) {
            // dd($pb);
            $poll_obj[$i]["poll_id"] = $key;
            $poll_obj[$i]["poll_question"] = $pb["poll_question"];
            $poll_obj[$i]["option1"] = $pb["option1"];
            $poll_obj[$i]["option2"] = $pb["option2"];
            $poll_obj[$i]["poll_image"] = $pb["poll_image"];
            if(array_key_exists("option1_count", $pb)) {
                $poll_obj[$i]["option1_count"] = $pb["option1_count"];
            }
            else {
                $poll_obj[$i]["option1_count"] = 0;
            }
            if(array_key_exists("option2_count", $pb)){
                $poll_obj[$i]["option2_count"] = $pb["option2_count"];
            }
            else {
                $poll_obj[$i]["option2_count"] = 0;
            }
            
            $total = $poll_obj[$i]["option1_count"] + $poll_obj[$i]["option2_count"];
            $option1_percent = ($poll_obj[$i]["option1_count"]/$total)*100;
            $option2_percent = ($poll_obj[$i]["option2_count"]/$total)*100;

            $poll_obj[$i]["option1_percent"] = (int)ceil($option1_percent);
            $poll_obj[$i]["option2_percent"] = (int)floor($option2_percent);

            $poll_obj[$i]["left_color"] = $pb["left_color"];
            $poll_obj[$i]["right_color"] = $pb["right_color"];

            $poll_obj[$i]["created_at"] = $pb["created_at"];


            $i=$i+1;
        }

        $polls = $poll_obj;
        // dd($polls);

        // dd($articlePolls);

        return view("articles.view_polls", compact('polls'));
    }

    public function articlePolls() {
        $articlePolls = DB::select("select * from article_polls;");
        return view('articles.poll_index', compact('articlePolls'));
    }

    public function updatePolls($poll_id, $poll_status) {
        dd($poll_id);
    }

    public function storePoll(Request $request) {
        $poll_question  = $request->poll_question;
        
        $flag = ArticlePoll::where('poll_question', $poll_question)->first();

        if($flag) {
            $response["status"] = "Poll already exists!";
            return $response;
        }
        else {

            $poll = new ArticlePoll();
            $poll->article_id = $request->article_id; 
            $poll->poll_question = $request->poll_question; 
            $poll->option1 = $request->answer1;
            $poll->option2 = $request->answer2;
            $article_poll = ArticlePoll::where("poll_question", $request->poll_question)->first();
            $poll->poll_image = $request->poll_image;
            $poll->poll_published = "Published";

            // $filename = $_FILES['poll_image']['name'];
            // $poll_image_path = "/assets/imgs/poll_images/".$filename;
            // $poll_img_url = $_SERVER['DOCUMENT_ROOT']."/assets/imgs/poll_images/".$filename;
            // $location = $poll_img_url;
            // $uploadOk = 1;
            // $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            // move_uploaded_file($_FILES['poll_image']['tmp_name'],$location);
            // $poll->poll_image = $poll_image_path;
            if(isset($request->poll_image)) {
                $article_image_url = $request->poll_image;

                // $response =self::cropImages($article_image_url);
                // $left_px_color  = $response["left_px_color"];
                // $right_px_color  = $response["right_px_color"];        

                $obj = self::copyImagePixelColor($request->poll_image);
                $left_color_pixel = $obj['left_color_pixel'];
                $right_color_pixel = $obj['right_px_color'];

                $poll->left_color = $left_color_pixel; 
                $poll->right_color = $right_color_pixel;                
            }

            if($poll->save()) {
                // Calling Create And Save Audio starts for Poll

                $data_to_post = [
                    "pollId" => $poll->id,
                    "pollQuestion" => $poll_question->poll_question,
                    "deleteExisting" => false
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://server.volvmedia.com/v1/createAndSaveAudio");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close ($ch);

                // Calling Create And Save Audio ENDS for Polls

                $response["status"] = "success";
            }
            else {
                $response["status"] = "failure";
            }
            return $response;
        }
    }
    // public function articlesOnApp() {
    //     // $data = ArticlePublishTime
    //     $articles = DB::select('select * from articles 
    //     left join article_publish_times
    //     on articles.id =  article_publish_times.article_id
    //     order by article_publish_times.created_at desc;');

    //     // $articles = $articles->items();
    //     $authors = Author::all();
    //     $users = User::all();
    //     $categories = Category::all();
    //     $states = State::all();
    //     $priorities = array("Urgent", "Needs Coverage");
    //     $article_statuses = ArticleStatus::all();

    //     return view('articles.articles_on_app', compact('articles','authors','categories','states','priorities','article_statuses'));
    // }


    public static function getMajorityPixels($image_url) {
        // $url = $_SERVER['DOCUMENT_ROOT']."/".'2.png';
        $url = $image_url;
        // dd($url);
        $palette = Palette::fromFilename($url);
        // $img = imagecrop("");
        // it offers some helpers too
        $topFive = $palette->getMostUsedColors(5);
        
        $colorCount = count($palette);

        $palette_count = count($palette);
        $topEightColors = $palette->getMostUsedColors(8);
        $i=0;
        foreach($palette as $color => $count) {
            $color = Color::fromIntToHex($color);
            // dd($color);
            // colors are represented by integers
            $i++;
                if($i==1) break;
            // echo Color::fromIntToHex($color), ': ', $count, "\n";
        }
        return $color;

        // dd($topEightColors);
    }



    public static function cropImages($article_image_url) {
        // dd($article_image_url);
//  ====================Left image gradient begins

        // $url = 'https://media.istockphoto.com/photos/design-elements-random-black-letters-scattered-on-white-picture-id1031313700';
        $url = $article_image_url;
        // $src = imagecreatefromjpeg($url);
        // dd($url);
        $image_type = exif_imagetype($article_image_url);
        // dd($image_type);
        if($image_type == 2) {
            // dd($image_type);
            $src = imagecreatefromjpeg($url);
        }
        else if($image_type == 3){
            $src = imagecreatefrompng($url);
        }
        else if($image_type == 1){
            $src = imagecreatefromgif($url);
        }
        else if($image_type == 18){
            $src = imagecreatefromwebp($url);
        }
        else if($image_type == 4){
            $src = imagecreatefromswf($url);
        }
        else if($image_type == 5){
            $src = imagecreatefrompsd($url);
        }
        else if($image_type == 6){
            $src = imagecreatefrombmp($url);
        }


        list($width, $height, $type, $attr) = getimagesize($url);


        $left_px_height_margin = $height*0.10;        
        $left_px_height = $height - $left_px_height_margin;
        $left_height_px = (int)$left_px_height;
        // dd($height);
        // dd($left_px_height1);
        $right_px_width_margin = $width*0.90;
        $left_width_px = $width - $right_px_width_margin;

        $left_width_px = (int)$left_width_px;
        // dd($width);
        // dd($left_width_px);
        
        $im2 = imagecrop($src, ['x' => 0, 'y' => $left_height_px, 'width' => $left_width_px, 'height' => $left_px_height_margin]);
        // create an image resource of your expected size 30x20
        $dest = imagecreatetruecolor(30, 20);

        imagecopy(
            $im2, 
            $src, 
            0,    // 0x of your destination
            0,    // 0y of your destination
            500,   // middle x of your source 
            500,   // middle y of your source
            30,  // 30px of width
            20   // 20px of height
        );
        // The second parameter should be the path of your destination
        // $image_name = $article_id.
        imagepng($im2, 'left'); 
        imagedestroy($im2);
        // imagedestroy($src);
        $img_url = $_SERVER['DOCUMENT_ROOT']."/".'left';
        $left_gradient_px_color = self::getMajorityPixels($img_url);
        // dd($left_gradient_px_color);
        if($img_url) {
            unlink($img_url);
        }
//  ====================Left image gradient ends

//  ====================Right image gradient begins

        $right_px_height_margin = $height*0.10;
                
        $right_px_height = $height - $right_px_height_margin;
        $right_px_height = (int)$right_px_height;
        // dd($height);
        $h = (int)$right_px_height_margin;

        // dd($right_px_height);
        $right_px_width_margin = $width*0.10;
        $right_width_px = $width - $right_px_width_margin;

        $right_width_px = (int)$right_width_px;
        // dd($width);

        $w = (int)$right_px_width_margin;
        // dd($right_width_px);
        // dd($height);
        // dd($right_px_height_margin);

        $im3 = imagecrop($src, ['x' => $right_width_px, 'y' => $right_px_height, 'width' => $w, 'height' => $h]);
        // $im3 = imagecrop($src, ['x' => $right_width_px, 'y' => $right_px_height, 'width' => 10, 'height' => 10]);

        // $im3 = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => 450, 'height' => 250]);
        // dd($im2);
        // create an image resource of your expected size 30x20
        $dest = imagecreatetruecolor(30, 20);
        imagecopy(
            $im3, 
            $src, 
            0,    // 0x of your destination
            0,    // 0y of your destination
            500,   // middle x of your source 
            500,   // middle y of your source
            30,  // 30px of width
            20   // 20px of height
        );

        // The second parameter should be the path of your destination
        imagepng($im3, 'right');        
        imagedestroy($im3);
        imagedestroy($src);        
        $img_url = $_SERVER['DOCUMENT_ROOT']."/".'right';
        $right_gradient_px_color = self::getMajorityPixels($img_url);
        if($img_url) {
            unlink($img_url);
        }
        


//  ====================Right image gradient ends
        $left_gradient_px_color = str_replace("#", "", $left_gradient_px_color);
        $right_gradient_px_color = str_replace("#", "", $right_gradient_px_color);

        $response["left_px_color"] = $left_gradient_px_color;
        $response["right_px_color"] = $right_gradient_px_color;
        // dd($response);
        return $response;
    }

    public function articleScheduler(Request $request) {
        $datetime = $request->datetime;
        $article_id = $request->article_id;
        
        $input = $datetime; 
        $date = strtotime($input); 
        
        // $data = new ArticlePublishTime();
        // $data->article_id = $article_id;
        // $data->created_at = $datetime;
        // $data->save();

        $datetime =  date('Y-m-d H:i:s', $date);
        $flag = WeekendArticle::where('article_id', $article_id)->first();
        if($flag) {
            $exists_flag =
             DB::table('weekend_articles')
            ->where('article_id', $article_id)
            ->update(['publish_datetime' => $datetime ]);
            // dd($exists_flag);
            if($exists_flag) {
                $response["status"] = "Article rescheduled";
            }
            else {
                $response["status"] = "failure";
            }
        }
        else {
            $data =  new WeekendArticle();
            $data->article_id = $article_id;
            $data->publish_datetime = $datetime;
            if($data->save()) {
                $response["status"] = "success";
            }
            else {
                $response["status"] = "failure";
            }
        }
        return $response;
    }

    public function getWeekendSlots($date) {
        $data_db = DB::select("SELECT publish_datetime FROM weekend_articles WHERE DATE(publish_datetime) = '" . $date . "';");

        $data = [];

        $end_time = strtotime ("2018-05-13 00:00:00");
        $start_time = strtotime ("2018-05-12 00:00:00");
        
        while ($start_time < $end_time) {
            $data[date("H:i:s", $start_time)] = "#449D44";
            $start_time += 1800;
        }

        foreach ($data_db as $dtime){
            if (!isset($data[date('H:i', strtotime($dtime->publish_datetime))]))
                $data[date('H:i:s', strtotime($dtime->publish_datetime))] = "#337AB7";
        }
        ksort($data);
        $response["times"] = $data;
        return $response;
    }


    function test_route(){
        // $articles=Article::all();
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();

        //dummy data for checking
        $articles=DB::table('articles')
        ->where('article_author','LIKE',"Dipak Rathod")
        ->where('article_status','LIKE',"%")
        ->where('article_category','LIKE',"%")
        ->where('article_priority','LIKE',"%")
        ->whereBetween('updated_at', ['2019-10-12'.' 00:00:00','2020-05-23'.' 23:59:59'])
        ->orderBy('updated_at', 'desc')
        ->paginate(35);
        return view('table_filters',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));

    }

    public function createBreakingNews(Request $request, $article_id) {
        $article = Article::find($article_id);
        $article_heading = $article->article_heading;
        $article_summary = $article->article_summary;
        $article_image = $article->article_image;
        return view('breaking_news.create', compact('article_id','article_summary','article_image','article_heading'));        
    }

    public function storeBreakingNews(Request $request) {
        $data = new ArticleBreakingNews();
        $data->article_id = (int)$request->article_id;
        $data->breaking_news_period = $request->breaking_news_period;
        $data->article_visited = 1;
        if($data->save()) {
            return redirect('show_breaking_news');
        }
    }

    public function breakingNewsIndex(Request $request) {
        $data = DB::select('SELECT a.article_heading, a.article_image,abn.created_at,abn.article_id, abn.breaking_news_period, abn.article_visited FROM articles as a
        right join article_breaking_news as abn
        on a.id = abn.article_id
        order by abn.article_id desc
        ;');


        return view('breaking_news.index', compact('data'));
    }

    public function editbreakingNewsIndex(Request $request, $article_id) {
        $data = ArticleBreakingNews::where('article_id', $article_id)->first();
        // dd($article_id);
        $data = DB::select('SELECT a.article_heading,a.article_summary, a.article_image,abn.created_at,abn.article_id, abn.breaking_news_period, abn.article_visited FROM articles as a
        right join article_breaking_news as abn
        on a.id = abn.article_id
        where abn.article_id='.$article_id.'

        order by abn.article_id desc
        ;');
        $data = $data[0];
        $article_id = $data->article_id;
        $article_heading = $data->article_heading;
        $article_image = $data->article_image;
        $article_summary = $data->article_summary;
        $article_visited = $data->article_visited;
        $breaking_news_period = $data->breaking_news_period;
        // dd($breaking_news_period);
        $durations = ['12','24','48','72'];
        return view('breaking_news.edit', compact('article_id','article_visited','article_summary','article_image','article_heading','breaking_news_period','durations'));        

    }
    public function updateBreakingNews(Request $request, $article_id) {
        $data = ArticleBreakingNews::where('article_id', $article_id)->first();
        // dd($data);
        $data->article_id = (int)$request->article_id;
        $data->breaking_news_period = $request->breaking_news_period;
        $data->article_visited = $request->article_visited;
        if($data->save()) {
            return redirect('show_breaking_news');
        }
    }

    public function republishableArticles(Request $request) {
        $articles = DB::table('republishable_articles')->leftJoin('articles', 'articles.id', '=', 'republishable_articles.article_id')->orderBy('republishable_articles.updated_at', 'desc')->paginate(25);

        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();


        if ($request->ajax()) {
            // $articles = DB::table('articles')->where('article_status','published')->orderBy('updated_at', 'desc')->paginate(25);

            $articles = DB::table('republishable_articles')->leftJoin('articles', 'articles.id', '=', 'republishable_articles.article_id')->orderBy('republishable_articles.updated_at', 'desc')->paginate(25);

            $articles = $articles->items();
            // dd($articles);
            foreach ($articles as $key => $value) {
                $value=(array)$value;
                $seconds = self::secondsConverter($value["updated_at"]);
                if(!($seconds > 86400)) {
                    $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                    $articles[$key]->time_ago = $converted_time;            
                }
                else {
                    // dd($value);
                $articles[$key]->time_ago = $value["updated_at"];  
                }
            }
            $articles = self::convertTimeFormat($articles);
            $view = view('articles.data',compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'))->render();
            return response()->json(['html'=>$view]);
        }
        foreach ($articles as $key => $value) {
            $value=(array)$value;
            $seconds = self::secondsConverter($value["updated_at"]);
            if(!($seconds > 86400)) {
                $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                $articles[$key]->time_ago = $converted_time;            
            }
            else {
                // dd($value);
            $articles[$key]->time_ago = $value["updated_at"];  
            }
        }
        // dd($articles);

        // $articles = self::convertTimeFormat($articles);
        foreach($articles as $article) {
            $articleCategory = explode(",", $article->article_category);
            $article->article_category = $articleCategory;
        }
        // dd($articles);
        $authors = Author::all();
        $users = User::all();
        $categories = Category::all();
        $states = State::all();
        $priorities = array("Urgent", "Needs Coverage");
        $article_statuses = ArticleStatus::all();
        return view('articles.republishable_articles', compact('articles', 'priorities', 'authors','categories','article_statuses','states','users'));    
    }

    public function readMediaBias(Request $request) {

        $data_to_post = [
			"article" => $request->article,
		];

        $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,"https://media-bias-prediction.el.r.appspot.com/result");
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
        curl_close ($ch);
        // $biasData = json_encode($response);
        return $response;
    }

    public function changeArticleBias(Request $request) {
    //  dd($request->all());
        $flag = ArticleSentenceBias::where('article_sentence', $request->article_sentence)->first();
        if($flag) {
            $response["status"] = "already exists!";
        }
        $request->bias;
        $data = new ArticleSentenceBias();
        $data->article_heading = $request->article_heading;
        $data->article_sentence = $request->article_sentence;
        $data->bias_type = $request->bias_type;
        if($data->save()) {
            $response["status"] = "success";
        }
        else{
            $response["status"] = "failure";
        }
        return $response;
    }
    

}
