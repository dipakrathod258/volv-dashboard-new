<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Article;
use App\WeekendArticle;
use App\ArticlePublishTime;
use DB;
use DateTime;


class publishWeekendArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:weekendArticle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish sccheduled articles on the weekends at the time set by Author.';

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

     public function dateTimeConverter($datetime) {
        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('H:i');

        $datetime = $date." ".$time;
        return $datetime;

     }

    public function handle()
    {

        $datetime1 = new DateTime('NOW');
        
        // $datetime1 = self::dateTimeConverter($datetime1);

        $today_datetime = date("Y-m-d");
        // $articles = WeekendArticle::select('id')->where('publish_datetime', 'like' ,'%'.$today_datetime.'%')->get();
        $article_ids = DB::table('weekend_articles')->where('publish_datetime', 'like' ,'%'.$today_datetime.'%')->pluck('article_id');

        $id_array=[];
        foreach($article_ids as $id) {
            array_push($id_array, $id);
        }

        foreach($id_array as $id) {
            // $datetime_articles = self::dateTimeConverter($article->publish_time);
            // dd($article->publish_datetime);
            $weekend_article = WeekendArticle::where('article_id', $id)->first();
            
            $d = $weekend_article->publish_datetime;

            $datetime2 = new DateTime($d);
            $difference = $datetime1->diff($datetime2);
            if($difference->y == 0 && $difference->m ==0 && $difference->d ==0 &&
               $difference->h == 0 && $difference->i ==0 && $difference->s) {

                $article_status = DB::select('select article_status from articles where id='.$id.';');
                $article_status = $article_status[0]->article_status;
                if(!($article_status == "Rollback")) {
                    DB::table('articles')
                    ->where('id', $id)
                    ->update(['article_status' => 'Published', 'button_class' => 'btn btn-success']);
                    
                    $flag = ArticlePublishTime::where('article_id', $id)->first();
                    if(!$flag) {
                        $article_publish_time = new ArticlePublishTime();
                        $article_publish_time->article_id = $id;
                        $article_publish_time->save();
                    }
            
                } 
            }
        }

        // $ids = implode(",", $id_array);


        // if($difference->days == 0) {
        //     // dd($ids);
        //     DB::select("UPDATE articles SET article_status = 'Published' WHERE id in "."(".$ids.");");
        // }
    }
}