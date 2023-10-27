<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaveBreakingNewsToken;
use App\NotificationStatus;

class BreakingNewsController extends Controller
{
    public function getBreakingNews() {

        $data_to_post = [
            "uid"=>1,
        ];
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,"http://ai.volvmedia.com/userData");
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $result = json_decode($response);
        $result = array_reverse($result);
        $data_to_post = [
            "uid"=>1,
        ];
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,"http://hashtags.volvmedia.com/api/tweets");
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $ob =json_decode($response);
        $ob= json_decode($ob);
        // foreach ($ob as $key => $value) {
        //     dd($value);
        // }
        // $ob = [["JISOO", 497141], ["Michelle Obama", 330015], ["The DNC", 207901], ["Cuomo", 113321], ["John Kasich", 93062], ["Clippers", 82958], ["First Lady", 80631], ["Kawhi", 54608], ["Mavs", 53097], ["#WWERaw", 49450], ["Nero", 40751], ["Porzingis", 40067], ["Tatum", 36810], ["#TheRising", 33204], ["Doncic", 22254], ["#TrumpCanceledAmerica", 19703], ["#BelowDeckMed", 17397], ["Mavericks", 15966], ["Bruins", 15190], ["#WeThePeople", 13966], ["Scott Baio", 11644], ["#MFFL", 11270], ["Kristaps", 11062], ["Paul George", 10913], ["Pat Bev", 10443], ["Billy Porter", 0], ["#ItIsWhatItIs", 0], ["Steve Javie", 0], ["Dansby", 0], ["Seth Curry", 0], ["Reggie Jackson", 0], ["Stephen Stills", 0], ["McAvoy", 0], ["Doug Jones", 0], ["#DALvsLAC", 0]];

        // dd($ob);




        return view("breaking_news_alert.index", compact('result', 'ob'));
    }

    public function saveBreakingNewsToken(Request $request) {
        
        $flag = SaveBreakingNewsToken::where("user_id", $request->user_id)->first();
        if(!$flag) {
            $data = new SaveBreakingNewsToken();
            $data->user_id = $request->user_id;
            $data->fcm_token = $request->token;
            if($data->save()) {
                $response["status"] = "success";
            }
            else {
                $response["status"] = "failure";
            }
        }
        else {
            $data = SaveBreakingNewsToken::where("user_id", $request->user_id)->first();
            $data->fcm_token = $request->token;
            if($data->save()) {
                $response["status"]="success";
            }   
        }

        $notification_status = NotificationStatus::where('user_id', '=', $request->user_id)->first();
        if (!$notification_status)
            $notification_status = new NotificationStatus();

        $notification_status->user_id = $request->user_id;
        $notification_status->status = 1;
        $notification_status->save();

        return $response;
    }

    public function getTwitterTrendingHashtags() {
        $data_to_post = [
            "uid"=>1,
        ];
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,"http://localhost:5002/api/tweets");
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $result = json_decode($response);
        // $hashtags = $result->hashtags;
        // $tweet_volume = $result->tweet_volume;
        // dd();
        return view("twitter.hashtags", compact('hashtags', 'tweet_volume'));
    }

}
