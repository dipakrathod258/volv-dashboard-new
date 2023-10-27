<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ArticleController;
use App\RssUsNews;
use DB;

class RSSFeedController extends Controller
{
    public function index(Request $request) {
        dd($world_news);        
        return view("test", compact('data'));
    }

    public static function  prepareArticleCNBC($articles, $source) {
        // dd($articles);
        $index=0;
        $articles1 = [];
        $cnbc_tech_news_final = [];
        foreach($articles as $article) {
            $articles1[$index]['title'] = (string)$article->title;
            $articles1[$index]['description'] = (string)$article->description;
            $articles1[$index]['links'] = (string)$article->link;
            $articles1[$index]['source'] = $source;
        
            $publish_date = ArticleController::articlePublishTimeConverter((string)$article->pubDate);
            // dd($publish_date);

            $articles1[$index]['dates'] = $publish_date;
            // array_push($cnbc_tech_news_final, $articles1);
            $index +=1;
        }
        return $articles1;    
    }

    public function worldNews(Request $request) {
        // CNBC begins
        $cnbc_world_news = simplexml_load_file('https://www.cnbc.com/id/100727362/device/rss/rss.html');
        $cnn_world_news = simplexml_load_file('http://rss.cnn.com/rss/edition_world.rss');
        $daily_mail_world_news = simplexml_load_file('https://www.dailymail.co.uk/news/worldnews/index.rss');   
        $bbc_world_news = simplexml_load_file('http://feeds.bbci.co.uk/news/world/rss.xml');   
        dd($cnn_world_news);
        // CNBC ends
    }

    public function usNews(){
        $us_news = simplexml_load_file('https://www.cnbc.com/id/15837362/device/rss/rss.html');
        $cnn_us_news = simplexml_load_file('http://rss.cnn.com/rss/edition_us.rss');
        $daily_mail_us_news = simplexml_load_file('https://www.dailymail.co.uk/ushome/index.rss');
        $bbc_us_news = simplexml_load_file('http://feeds.bbci.co.uk/news/world/us_and_canada/rss.xml');
        
        // dd($daily_mail_us_news);
        $obj = $daily_mail_us_news->channel;
        $daily_mail_us_news = $obj->item;
        $response = self::prepareArticleCNBC($daily_mail_us_news);

        // dd($response);
    }



    public function politicsNews() {
        
        $politics_news = simplexml_load_file('https://www.cnbc.com/id/10000113/device/rss/rss.html');
        $thehill_politics_news = simplexml_load_file('https://thehill.com/rss/syndicator/19109');
        $bbc_politics_news = simplexml_load_file('http://feeds.bbci.co.uk/news/politics/rss.xml');
        dd($thehill_politics_news);        
        $daily_mailpolitics_news = simplexml_load_file('https://www.dailymail.co.uk/news/us-politics/index.rss');
    }


    public function recentNews(){
        $cnn_news = simplexml_load_file('http://rss.cnn.com/rss/cnn_latest.rss');
        $bbc_news = simplexml_load_file('http://feeds.bbci.co.uk/news/rss.xml');
        
        $obj = $cnn_news->channel;
        $cnn_news = $obj->item;
        $response = self::prepareArticleCNBC($cnn_news);
        dd($response);
    }

    public function technologyNews() {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
        $technology_news = simplexml_load_file('https://www.cnbc.com/id/19854910/device/rss/rss.html');
        $cnn_technology_news = simplexml_load_file('http://rss.cnn.com/rss/edition_technology.rss');
        $daily_mail_technology_news = simplexml_load_file('https://www.indiatoday.in/rss/1206550');
        $bbc_technology_news = simplexml_load_file('http://feeds.bbci.co.uk/news/technology/rss.xml');
        
        dd($bbc_technology_news);
        
        $obj = $technology_news->channel;
        $articles = $obj->item;

        $obj = $daily_mail_technology_news->channel;
        $daily_mail_articles = $obj->item;


        // dd($daily_mail_articles);
        $response = self::prepareArticleCNBC($articles); // CNBC
        $response = self::prepareArticleCNBC($daily_mail_articles); // CNBC


        $business_insider_technology_news = simplexml_load_file('https://www.businessinsider.in/rss_section_feeds/21807543.cms');
        $obj = $daily_mail_technology_news->channel;
        $business_insider_articles = $obj->item;
        // dd($business_insider_articles);
        $bi_response = self::prepareArticleCNBC($business_insider_articles); // Business Insider
        dd($bi_response);

    }

    public function entertainmentNews() {
        $cnn_entertainment_news = simplexml_load_file('http://rss.cnn.com/rss/edition_entertainment.rss');
        $business_insider_entertainment_news = simplexml_load_file('https://www.businessinsider.in/rss_section_feeds/21806366.cms');
        $bbc_entertainment_news = simplexml_load_file('http://feeds.bbci.co.uk/news/entertainment_and_arts/rss.xml');
        $obj = $business_insider_entertainment_news->channel;
        $business_insider_articles = $obj->item;        
        $ent_response = self::prepareArticleCNBC($business_insider_articles); // Business Insider
        dd($bbc_entertainment_news);
    }

    public function sportNews(){
        $cnn_sports_news = simplexml_load_file('http://rss.cnn.com/rss/edition_sport.rss');
        $daily_mail_sports_news = simplexml_load_file('https://www.dailymail.co.uk/sport/index.rss');
        dd($daily_mail_sports_news);
    }

    public function businessNews(){
        $business_news = simplexml_load_file('https://www.cnbc.com/id/10001147/device/rss/rss.html');
        // $cnn_sports_news = simplexml_load_file('http://rss.cnn.com/rss/edition_sport.rss');
        $bbc_business_news = simplexml_load_file('http://feeds.bbci.co.uk/news/business/rss.xml');
    }


    public function financeNews(){
        $finance_news = simplexml_load_file('https://www.cnbc.com/id/10000664/device/rss/rss.html');
    }

    public function economyNews(){ 
        $economy_news = simplexml_load_file('https://www.cnbc.com/id/20910258/device/rss/rss.html');
    }

    public function getRSSFeed(Request $request) {
        // dd("welcome to volv!");
        $data = DB::select('select * from rss_us_news order by published_date asc limit 30;');
        DB::select('delete from rss_us_news where published_date ="0 hrs 0 mins ago";');
        $us_tab = True;
        return view('RssFeed.index', compact('data', 'us_tab'));
    }

    public function getRSSWorldFeed(Request $request) {
        // dd("hel");
        $data = DB::select('select * from rss_world_news order by published_date asc limit 30;');
        DB::select('delete from rss_world_news where published_date ="0 hrs 0 mins ago";');
        $world_tab = True;
        return view('RssFeed.index', compact('data', 'world_tab'));
    }

    public function getRssPoliticsFeed(Request $request) {
        $data = DB::select('select * from rss_politics_news order by published_date asc;');
        DB::select('delete from rss_politics_news where published_date ="0 hrs 0 mins ago";');
        $politics_tab = True;
        return view('RssFeed.index', compact('data', 'politics_tab'));
    }

    public function getRssTrendingFeed(Request $request) {
        $data = DB::select('select * from rss_politics_news order by published_date asc;');
        DB::select('delete from rss_politics_news where published_date ="0 hrs 0 mins ago";');
        $politics_tab = True;
        return view('RssFeed.index', compact('data', 'politics_tab'));
    }

    public function getRssEntertainmentFeed(Request $request) {
        $data = DB::select('select * from rss_politics_news order by published_date asc;');
        DB::select('delete from rss_politics_news where published_date ="0 hrs 0 mins ago";');
        $politics_tab = True;
        return view('RssFeed.index', compact('data', 'politics_tab'));
    }



}
