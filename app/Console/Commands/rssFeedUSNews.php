<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RSSFeedController;
use App\RssUsNews;
use DB;

class rssFeedUSNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:usnews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saving RSS News feed in whatever numbers it comes in';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::select("truncate table rss_us_news;");
        $us_news = simplexml_load_file('https://www.cnbc.com/id/15837362/device/rss/rss.html');
        $cnn_us_news = simplexml_load_file('http://rss.cnn.com/rss/edition_us.rss');
        $daily_mail_us_news = simplexml_load_file('https://www.dailymail.co.uk/ushome/index.rss');
        $bbc_us_news = simplexml_load_file('http://feeds.bbci.co.uk/news/world/us_and_canada/rss.xml');
        $wall_street_us_news = simplexml_load_file('https://feeds.a.dj.com/rss/WSJcomUSBusiness.xml');
        
        $obj = $us_news->channel;
        $us_news = $obj->item;
        $obj = $cnn_us_news->channel;
        $cnn_us_news = $obj->item;
        $obj = $daily_mail_us_news->channel;
        $daily_mail_us_news = $obj->item;
        
        $obj = $bbc_us_news->channel;
        $bbc_us_news = $obj->item;
        // dd($bbc_us_news);
        $response = RSSFeedController::prepareArticleCNBC($us_news, $source="CNBC");
        $response1= RSSFeedController::prepareArticleCNBC($cnn_us_news, $source="CNN");
        $response2 = RSSFeedController::prepareArticleCNBC($bbc_us_news, $source="BBC");
        $response3 = RSSFeedController::prepareArticleCNBC($daily_mail_us_news, $source="Daily mail");
        $response4 = RSSFeedController::prepareArticleCNBC($wall_street_us_news, $source="Wall Street Journal");

        $response = array_merge($response, $response1, $response2, $response3, $response4);
        foreach($response as $article){
            $data = new RssUsNews();
            $data->article_title = $article['title'];
            $data->article_description = $article['description'];
            $data->published_date = $article['dates'];
            $data->main_source = $article['links'];
            if(isset($article['image_url'])) {
                $data->image_url = $article['image_url'];
            }
            $data->image_url = 'N.A.';
            $data->source_name = $article['source'];
            $data->save();
            // }        
        }

    }
}
