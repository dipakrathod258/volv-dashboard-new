<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Article;
use App\WeekendArticle;
use App\Traits\ArticleReportTrait;

class ArticleReportsController extends Controller
{
    // public function goToArticleReports() {
    //     return view('Reports.index');
    // }
    use ArticleReportTrait;

    public function goToArticleReports() {
        
        $total_published_news_count = DB::select("select count(*) as count from articles where article_status='Published'");
        
        $total_published_news_count = $total_published_news_count[0]->count;

        $us_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%US News%'");
        $world_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%World%'");
        $finance_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%Finance%'");
        $entertainment_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%entertainment%'");
        $business_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%business%'");
        $fashion_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%fashion%'");
        $sports_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%sports%'");        
        $entrep_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%Entrepreneur%'");        
        $self_dev_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%Self-Development%'");
        $scie_n_tech_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%Science & Tech%'");        
        $twenty_news_count = DB::select("select count(*) as count from articles where article_status='Published' AND article_category like '%2020 US Elections%'");

        $article_count  =[];

        $article_count[0]["news_type"] = "US News";
        $article_count[0]["count"] = $us_news_count[0]->count;

        $article_count[1]["news_type"] = "World";
        $article_count[1]["count"] = $world_news_count[0]->count;
        
        $article_countarticle_count[2]["news_type"] = "Finance";
        $article_countarticle_count[2]["count"] = $finance_news_count[0]->count;
        
        $article_count[3]["news_type"] = "Entertainment";
        $article_count[3]["count"] = $entertainment_news_count[0]->count;
        
        $article_count[4]["news_type"] = "Business";
        $article_count[4]["count"] = $business_news_count[0]->count;

        $article_count[5]["news_type"] = "Fashion";
        $article_count[5]["count"] = $fashion_news_count[0]->count;

        $article_count[6]["news_type"] = "Sports";
        $article_count[6]["count"] = $sports_news_count[0]->count;
        
        $article_count[7]["news_type"] = "Entrepreneur";
        $article_count[7]["count"] = $entrep_news_count[0]->count;
        
        $article_count[8]["news_type"] = "Self-Development";
        $article_count[8]["count"] = $self_dev_news_count[0]->count;

        $article_count[9]["news_type"] = "Science & Tech";
        $article_count[9]["count"] = $scie_n_tech_news_count[0]->count;
        
        $article_count[10]["news_type"] = "2020 US Elections";
        $article_count[10]["count"] = $twenty_news_count[0]->count;
        // dd($article_count);



        $today_date = date("Y-m-d");
        
        $response = $this->todayReport($today_date);
        // dd($response);
        return view('Reports.index', compact('article_count','response'));
    }

    public function goToDailyReports() {
        $article_daily_report = DB::select("SELECT CAST(created_at AS DATE) as date, article_category , count(CAST(created_at AS DATE)) as count
        FROM articles
        where article_status='Published'
        GROUP BY CAST(created_at AS DATE), article_category
        order by date desc
        ");
        $bucket=[];
        foreach($article_daily_report as $data) {
            // dd($bucket);
            $bucket[$data->date][$data->article_category] = $data->count; 
        }

        foreach($bucket as $key=> $b) {
            // dd($b);
            $world_news_count=0;
            $us_news_count=0;
            $business_news_count=0;
            $sci_n_tech_news_count=0;
            $sport_news_count=0;
            $ent_news_count=0;
            $fashion_news_count=0;
            $entrep_news_count=0;
            $tw_tw_us_news_count=0;
            $finance_news_count=0;
            // dd($world_news_count);
            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'World') !== false) {                    
                    $world_news_count = $world_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'US News') !== false) {                    
                    $us_news_count = $us_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Business') !== false) {                    
                    $business_news_count = $business_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Science & Tech') !== false) {                    
                    $sci_n_tech_news_count = $sci_n_tech_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Sports') !== false) {                    
                    $sport_news_count = $sport_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Entertainment') !== false) {                    
                    $ent_news_count = $ent_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Fashion') !== false) {                    
                    $fashion_news_count = $fashion_news_count + $value;
                }
            }

            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Entrepreneur') !== false) {                    
                    $entrep_news_count = $entrep_news_count + $value;
                }
            }
            
            
            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, 'Finance') !== false) {                    
                    $finance_news_count = $finance_news_count + $value;
                }
            }



            foreach($b as $key1 => $value) {
                // dd($b);
                if(strpos($key1, '2020 US Elections') !== false) {                    
                    $tw_tw_us_news_count = $tw_tw_us_news_count + $value;
                }
            }

            $final[$key]["World"] = $world_news_count;
            $final[$key]["US News"] = $us_news_count;
            $final[$key]["Business"] = $business_news_count;
            $final[$key]["Science & Tech"] = $sci_n_tech_news_count;
            $final[$key]["Sports"] = $sport_news_count;
            $final[$key]["Entertainment"] = $ent_news_count;
            $final[$key]["Fashion"] = $fashion_news_count;
            $final[$key]["Entrepreneur"] = $entrep_news_count;
            $final[$key]["Finance"] = $finance_news_count;
            $final[$key]["2020 US Elections"] = $tw_tw_us_news_count;
            // dd($world_news_count);
        }

        return view('Reports.daily_reports', compact('article_daily_report','final'));
    }

    public function goToWeeklyReports() {
        return view('Reports.weekly_report');
    }

    public function goToMonthlyReports() {

        return view('Reports.monthly_reports');
    }

    public function fetchTodayReport($today_date) {

        $response = $this->todayReport($today_date);
        return $response;
    }

    public function excelReport() {
        
        
        // $scheduled_times = DB::select("SELECT articles.id, articles.article_heading, weekend_articles.publish_datetime, articles.article_status FROM weekend_articles join articles on weekend_articles.article_id = articles.id WHERE WEEK(weekend_articles.publish_datetime) >= WEEK(NOW()) and WEEK(weekend_articles.publish_datetime) <= WEEK(NOW() + INTERVAL 1 WEEK) order by weekend_articles.publish_datetime desc");

$scheduled_times = DB::select("SELECT articles.id, articles.article_heading, weekend_articles.publish_datetime, articles.article_status FROM weekend_articles join articles on weekend_articles.article_id = articles.id WHERE WEEK(weekend_articles.publish_datetime) >= WEEK(NOW()) and WEEK(weekend_articles.publish_datetime) <= WEEK(NOW() + INTERVAL 1 WEEK) and weekend_articles.publish_datetime >= NOW() order by weekend_articles.publish_datetime");

        // dd($scheduled_times);

        $data = [];
        $end_time = strtotime("2018-05-13 00:00:00");
        // dd($scheduled_times);
        foreach ($scheduled_times as $value) {
            $day = date(" l (j-M)", strtotime($value->publish_datetime));

            $start_time = strtotime ("2018-05-12 00:00:00");
            if (!isset($data[$day])) {
                while ($start_time < $end_time) {
                    $data[$day][date("H:i", $start_time)] = ["id" => 0, "heading" => "", "publish_time" => "", "status" => ""];
                    $start_time += 1800;
                }
            }
        }

        $times = [];
        if (!empty($data))
            $times = array_keys($data[array_keys($data)[0]]);

        foreach ($scheduled_times as $value) {
            $day = date(" l (j-M)", strtotime($value->publish_datetime));
            $time = date("H:i", strtotime($value->publish_datetime));

            if (isset($data[$day][$time]))
                $data[$day][$time] = ["id" => $value->id, "heading" => $value->article_heading, "publish_time" => $value->publish_datetime, "status" => $value->article_status];
            else {
                $data[$day][$time] = ["id" => $value->id, "heading" => $value->article_heading, "publish_time" => $value->publish_datetime, "status" => $value->article_status];
                foreach (array_keys($data) as $weekDay) {
                    if (!isset($data[$weekDay][$time])) {
                        $data[$weekDay][$time] = ["id" => 0, "heading" => "", "publish_time" => "", "status" => ""];
                        ksort($data[$weekDay]);
                    
                        if (!in_array($time, $times)) {
                            $times[] = $time;
                            sort($times);
                        }
                    }
                }
            }
        }

        $days = array_keys($data);
        $saturday = preg_grep('/^ Saturday\s.*/', $days);
        $sunday = preg_grep('/^ Sunday\s.*/', $days);
        $monday = preg_grep('/^ Monday\s.*/', $days);

        foreach ($saturday as $day) {
            foreach ($data[$day] as $time => $time_data) {
                if (($time >= "00:00" && $time <= "10:00") || ($time >= "12:30" && $time <= "14:30") || $time >= "22:30" && $time <= "23:30")
                    $time_data["color"] = "grey";
                else
                    $time_data["color"] = "#B6D7A8";
                $data[$day][$time] = $time_data;
            }
        }

        foreach ($sunday as $day) {
            foreach ($data[$day] as $time => $time_data) {
                if (($time >= "00:00" && $time <= "02:00") || ($time >= "06:00" && $time <= "10:00") || ($time >= "12:30" && $time <= "14:30") || ($time >= "19:00" && $time <= "22:00"))
                    $time_data["color"] = "grey";
                else
                    $time_data["color"] = "#B6D7A8";
                $data[$day][$time] = $time_data;
            }
        }

        foreach ($data as $day => $weekDay) {
            if (strpos($day, 'Saturday') === false && strpos($day, 'Sunday') === false) {
                foreach ($weekDay as $time => $time_data) {
                    $time_data["color"] = "#B6D7A8";
                    $weekDay[$time] = $time_data;
                }
                $data[$day] = $weekDay;
            }
        }


        $weekDays = [
            "Saturday",
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
        ];

        $newData = [];
        foreach ($weekDays as $weekDay) {
            foreach ($data as $day => $value) {
                if (strpos($day, $weekDay) !== false) {
                    if (!isset($newData[$day])) {
                        $newData[$day] = $data[$day];
                        break;
                    }
                }
            }
        }


        // dd($newData);

        return view('Reports.excel_report', ["DateTimes" => $newData, "times" => $times]);
    }

    public function changeExcelReport(Request $request) {
        $article = Article::find((int)$request->id);
        $article->article_status = $request->status;
        $article->save();
        $weekend_article = WeekendArticle::where('article_id', (int)$request->id)->first();
        $weekend_article->publish_datetime = $request->datetime;
        $weekend_article->save();
        return redirect('/excel-report/');
    }

}