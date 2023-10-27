<?php
 
namespace App\Traits;
 
use Illuminate\Http\Request;
use DB;

trait ArticleReportTrait {

    public function todayReport($today_date) {

        $resoult = DB::select("select count(*) as today_article_count from volv.articles where created_at like '%".$today_date."%';");
        $today_article_count = $resoult[0]->today_article_count;

        $result1 = DB::select("select count(*) as today_published_article_count from volv.articles where  article_status= 'Published' AND created_at like '%".$today_date."%';");
        $today_published_article_count = $result1[0]->today_published_article_count;

        $result1 = DB::select("select count(*) as today_needs_review_article_count from volv.articles where  article_status= 'Needs Review' AND created_at like '%".$today_date."%';");
        $today_needs_review_article_count = $result1[0]->today_needs_review_article_count;

        $result1 = DB::select("select count(*) as today_in_progress_article_count from volv.articles where  article_status= 'In Progress' AND created_at like '%".$today_date."%';");
        $today_in_progress_article_count = $result1[0]->today_in_progress_article_count;

        $result1 = DB::select("select count(*) as today_rejected_article_count from volv.articles where  article_status= 'Rejected' AND created_at like '%".$today_date."%';");
        $today_rejected_article_count = $result1[0]->today_rejected_article_count;

        $result1 = DB::select("select count(*) as today_rollback_article_count from volv.articles where  article_status= 'Rollback' AND created_at like '%".$today_date."%';");
        $today_rollback_article_count = $result1[0]->today_rollback_article_count;

        $result1 = DB::select("select count(*) as today_edited_article_count from volv.articles where  article_status= 'Edited' AND created_at like '%".$today_date."%';");
        $today_edited_article_count = $result1[0]->today_edited_article_count;

        $result1 = DB::select("select count(*) as today_pending_article_count from volv.articles where  article_status= 'Weekend' AND created_at like '%".$today_date."%';");
        $today_pending_article_count = $result1[0]->today_pending_article_count;

        $response["published"] = $today_published_article_count;
        $response["in_progress"] = $today_in_progress_article_count;
        $response["needs_review"] = $today_needs_review_article_count;
        $response["edited"] = $today_edited_article_count;
        $response["rejected"] = $today_rejected_article_count;
        $response["rollback"] = $today_rollback_article_count;
        $response["pending"] = $today_pending_article_count;
        $response["total_count"] = $today_article_count;
        return $response;
    }

}