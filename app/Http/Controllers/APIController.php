<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationOpen;
use DB;
use App\Article;
use DateTime;

class APIController extends Controller
{
    public function saveNotificationOpen(Request $request) {
        $article_id = $request->article_id;
        $app_user_id = $request->app_user_id;

        $data = new NotificationOpen();
        $data->article_id = $article_id;
        $data->app_user_id = $app_user_id;
        if($data->save()) {
            $response["status"] = "success";
        }
        else {
            $response["status"] = "failure";
        }
        return $response;
    }
    public function getlastWeeksUserData(Request $request) {
        $users = DB::connection('mysql2')->select("select * from volv_users;");

        return view('volv_app_data.users', compact('users'));
    }
    
    public function lastWeeksUserData(Request $request, $uid) {
        // dd($request->all());
        // dd($uid);
        $data_to_post = [
            "uid"=>$uid,
        ];
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,"https://userdata.volvmedia.com/lastWeeksUserData");
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $result = json_decode($response);  
        $articleObj = $result->articles;
        // dd($articleObj);
        // $users = DB::select('select * from volv_app_users where id='.$uid.';');

        $users = DB::connection('mysql2')->select("select * from volv_users where id=".$uid.";");

        // $users = $users[0];

        foreach($articleObj as $article) {
            $articleHeadingObj = Article::select('article_heading')->where('id', $article->article_id)->first();
            if($articleHeadingObj) {
                $article_heading= $articleHeadingObj->article_heading;
                $article->article_heading = $article_heading;
                // dd($time);
            }
            else {
                $article->article_heading = "INVITE YOUR FRIEND(QR CODE Screen)";
            }
            $ts1 = strtotime($article->starttime);
            $ts2 = strtotime($article->endtime);     
            $seconds_diff = $ts2 - $ts1;                            
            $time = ($seconds_diff);
            $article->time_spent = $time;
        }

       dd($articleObj);
       arsort($articleObj);

        return view('volv_app_data.last_week', compact('articleObj','users'));
    }

    public function avgTimeSpentPerUserPerWeek() {
 
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',

        );
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/average_time_spent_per_user/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $results = json_decode($response);  
        // dd($results);

        foreach($results as $key=> $result) {
            $user = DB::connection('mysql2')->select("select name, email from volv_users where id=".$result->uid.";");
            if ($user) {
                $results[$key]->user_name = $user[0]->name;
                $results[$key]->email = $user[0]->email;
                # code...
            }
        }
        return view('volv_app_data.avg_time_spent_per_user_per_week', compact('results'));
    }

    public function topArticlesLastWeek() {
 
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',

        );
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/top_performing_article_with_total_no_of_article_read_count/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $results = json_decode($response);
        dd($results);
        $article = DB::select("select article_heading from articles where id=".$results->article_id.";");
        

        $article_heading = $article[0]->article_heading;
        return view('volv_app_data.top_article_last_week', compact('article_heading','results'));
    }

    public function topTenArticlesLastWeek() {
 
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',

        );
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/top_ten_articles/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $results = json_decode($response);
        // dd($results);
        foreach ($results as $key => $value) {
            $article_id = $value->_id;
            $article = DB::select("select article_heading, article_image from articles where id=".$article_id.";");
            if ($article) {
                $article_heading = $article[0]->article_heading;
                $results[$key]->article_heading = $article_heading; 
                $results[$key]->article_image = $article[0]->article_image; 
                # code...
            }
        }
        return view('volv_app_data.top_10_article_last_week', compact('results'));
    }

    public function avgSessionsPerWeekPerUser() {
 
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',

        );
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/average_num_of_session_per_user/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $results = json_decode($response);
        // dd($results);

        // foreach ($results as $key => $value) {
        //     $user = DB::connection('mysql2')->select("select name, email from volv_users where id=".$value->uid.";");
        //     if ($user) {
        //         # code...
        //         $results[$key]->name = $user[0]->name; 
        //         $results[$key]->email = $user[0]->email; 
        //     }
        // }
        // dd($results);
        return view('volv_app_data.average_sessions_per_user_per_week', compact('results'));
    }

    // public function timeSpentLastWeek(Request $request, $uid) {

    //     $data_to_post = [
    //         "uid"=>$uid,
    //     ];
	// 	$ch = curl_init();
	//     curl_setopt($ch, CURLOPT_URL,"https://userdata.volvmedia.com/timeSpentLastWeek");
	//     curl_setopt($ch, CURLOPT_POST, 1);
	//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//     $response = curl_exec($ch);
	//     curl_close ($ch);
    //     $result = json_decode($response);  
    //     $articleObj=$result->articles;
    //     dd($articleObj);
    //     $users = DB::select('select * from volv_app_users where id='.$uid.';');
    //     $users = $users[0];

    // }
}
