<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\TrendingSaveArticle;
use DB;

class AutosaveArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autosave:us';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $response = file_get_contents('https://newsapi.org/v2/top-headlines?sources=google-news&sortBy=popularity&apiKey=1c128e3aadde471f842601390b1f598c');

         $response_new = json_decode($response , true);

            $articles = $response_new['articles'];
            $api_article_count = count($articles);


            $data = TrendingSaveArticle::all();
            $count = $data->count();
            // dd($count);
            if ($count>=30) {
                DB::table('trending_save_articles')
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
}
