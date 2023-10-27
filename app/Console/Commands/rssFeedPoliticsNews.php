<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\RssPoliticsNews;
use App\Http\Controllers\RSSFeedController;
use DB;

class rssFeedPoliticsNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:politicsnews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To get the politics news periodically usin CRON job.';

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
        DB::select("truncate table rss_politics_news;");        
        DB::select("delete from rss_politics_news where published_date ='0 hrs 0 mins ago';");        
        $politics_news = simplexml_load_file('https://www.cnbc.com/id/10000113/device/rss/rss.html');
        $thehill_politics_news = simplexml_load_file('https://thehill.com/rss/syndicator/19109');
        $bbc_politics_news = simplexml_load_file('http://feeds.bbci.co.uk/news/politics/rss.xml');        
        $daily_mailpolitics_news = simplexml_load_file('https://www.dailymail.co.uk/news/us-politics/index.rss');     
        $obj = $politics_news->channel;
        $politics_news = $obj->item;
        $obj = $thehill_politics_news->channel;
        $thehill_politics_news = $obj->item;
        $obj = $daily_mailpolitics_news->channel;
        $daily_mail_us_news = $obj->item;        
        $obj = $bbc_politics_news->channel;
        $bbc_us_news = $obj->item;
        $response1= RSSFeedController::prepareArticleCNBC($politics_news, $source="CNBC");
        $response2 = RSSFeedController::prepareArticleCNBC($thehill_politics_news, $source="The Hill");
        $response3 = RSSFeedController::prepareArticleCNBC($bbc_us_news, $source="BBC");
        $response4 = RSSFeedController::prepareArticleCNBC($daily_mail_us_news, $source="Daily mail");
        $response = array_merge( $response1, $response2, $response3, $response4);
        foreach($response as $article) {
            $data = new RssPoliticsNews();
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
        }
    }}
