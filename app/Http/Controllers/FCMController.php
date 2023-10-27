<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\NotificationAuthorSummary;
use App\NotificationStatusEachUser;
use App\VolvAppUser;
use DB;

class FCMController extends Controller
{
	
	// public function getAppUsernameFromFcmToken($token) {
	// 	$appUserName = VolvAppUser::select('name')->where('fcm_token', $token)->first();
	// 	// dd($appUserName);		
	// 	return $appUserName->name;
	// }

	public function setNotificationStatusCount($id,$notification_text, $successCount,$failureCount, $invalidRegisteredCount, $notRegisteredCount){

		$data = new NotificationAuthorSummary();
		$data->article_id = $id;
		$data->author_id = auth()->user()->id;
		$data->notification_text = $notification_text;
		$data->notffication_status = 1;
		$data->notification_sent_count = $successCount;
		$data->notification_failure_count = $failureCount;
		$data->invalid_count = $invalidRegisteredCount;
		$data->not_registered_count = $notRegisteredCount;
		if($data->save()) {
			$response["status"] = "success";
		}
		else {
			$response["status"] = "success";
		}
		return $response;
	}

	public function getNotificationStatusEachUser($notificationResponse, $id, $article_heading, $article_image) {

		foreach($notificationResponse as $key => $result) {
			$data = new NotificationStatusEachUser();

			$data->article_id = $id;
			$data->fcm_token = $key;
			// $appUserName = self::getAppUsernameFromFcmToken($key);

			// $appUserName = VolvAppUser::select('name')->where('fcm_token', $key)->first();
			// if($appUserName) {
			// 	$data->app_username = $appUserName->name;				
			// }
			// else {
			// 	$data->app_username = "N.A.";				
			// }
			$data->sent_status = $result["status"];
			$data->save();
		}
		$response["status"] = "success";
		return $response;
	}

	public function sendNotification($id, $article_image, $notification_text, $fcms, $articleStack) {
		// dd($articleStack);
		$registrationIds = $fcms;
		dd($fcms);
		$serverKey = 'AAAALpOh8nA:APA91bErQAVgKN3WTuFY9EKBchyvSWI-f2CsK6Bv4zqxsnJWoyuCbSoOMOEpGEhn-fFTQFYW3gWm96fg3RK3suCwzulNTAMQc4EP8xe_Q9UZmA80-Ace9iXR8xBlQFjzUNkjG4ZTJzxo';

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;

		$data['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
		// dd($id);
		// $data['article_id'] = $id;$articleStack
		$data['article_id'] = $articleStack;
		$data['android_channel_id'] = 'volvmedia_volvapp';
		// dd($data);
		$url = "https://fcm.googleapis.com/fcm/send";
		$title = "";
		$body = $notification_text;


		$notificationStatus=[];
		$notificationResponse=[];
		$successCount = 0;
		$failureCount = 0;
		$invalidRegisteredCount = 0;
		$notRegisteredCount = 0;
		// dd($registrationIds);
		$registrationIds = array_unique($registrationIds);
		// dd($registrationIds);
		foreach($registrationIds as $key => $token) {
			$obj[0] = $token;
			// dd($obj);
			$notification = array('title' =>$title, 'body' => $body, 'image' => $article_image, 'sound' => 'default', 'badge' => '1', 'alert'=>'1', "content_available"=>"1");
			$arrayToSend =  array('notification' => $notification, 'data'=> $data, 'priority'=>'high','content_available' => True, 'registration_ids' => $obj, "apns" => array("headers" => ["apns-priority"=>10], "payload"=> array("aps"=>["sound"=>"default"])));
			$json = json_encode($arrayToSend);
			// dd($json);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			
			$result1 = curl_exec($ch);
			$result1 = json_decode($result1);	
			$obj = $result1->results; 
			$response = $obj[0];

			if(isset($response->error)) {
				if($response->error == "InvalidRegistration") {
					$invalidRegisteredCount+=1;
					$notificationResponse[$token]["status"] =  "InvalidRegistration";
				}
				if($response->error == "NotRegistered") {
					$notRegisteredCount+=1;
					$notificationResponse[$token]["status"] =  "NotRegistered";
				}
			}

			if(isset($response->message_id)) {
				$notificationResponse[$token]["status"] =  "message";
			}

			$success = $result1->success;
			$failure = $result1->failure;

			if($success == 1) {
				$notificationResponse[$token]["status"] = "success";
				$successCount+=1;
				
			}
			if($failure == 1) {
				$notificationResponse[$token]["status"] = "failure"; 
				$failureCount+=1;				
			}
		}

		// dd($notificationResponse);
		// dd($successCount);
		// dd($failureCount);

		// dd($notRegisteredCount);
		// dd($invalidRegisteredCount);

		$flag = self::getNotificationStatusEachUser($notificationResponse, $id, $article_image);
		// dd($flag);
		if($flag["status"] == "success") {
			$flag = self::setNotificationStatusCount($id,$notification_text, $successCount,$failureCount, $invalidRegisteredCount, $notRegisteredCount, $article_image);
			if($flag["status"] == "success") {
				DB::table('articles')
				->where('id', $id)
				->update(['notification_sent_status' => 1]);

				$result["status"] = "success";
			}
			else {
				$result["status"] = "Server Error.";
			}
		}
		else {
			$result["status"] = "Server Error.";
		}
		return $result;
	}

	public function notify(Request $request, $id, $articleStack) {
		// dd("jey");
		$article = Article::find($id);
		if($article->notification_sent_status == 1) {
			return response()->json(['status' => 'Notification already Sent!']);
		}

		// $article_heading = $article->article_heading;
		$article_image = $article->article_image;
		$article_category = $article->article_category;
		$notification_text = $article->notification_text;
		$breaking_news_flag = $article->trending_news;
		$trending_news_flag = $article->breaking_news;
		$data_to_post = [
			"article_category" => $article_category,
			"breaking_news_flag" => $breaking_news_flag,
			"trending_news_flag" => $trending_news_flag,
		];

		// $ch = curl_init();
	    // curl_setopt($ch, CURLOPT_URL,"https://api.volvmedia.com/api/getAllFCMs/");
	    // curl_setopt($ch, CURLOPT_POST, 1);
	    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
	    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    // $response = curl_exec($ch);
	    // curl_close ($ch);
	   	// $fcms = json_decode($response);

		// dd($fcms);
		// foreach($fcms as $fcm) {
		// 	dd($fcm);
		// }
		   
		// $fcm_tokens = VolvAppUser::all()->value('fcm_token');
		// $fcm_tokens = DB::table('volv_app_users')->distinct()->pluck('fcm_token');
		$fcm_tokens = DB::select("select distinct fcm_token from volv_app_users where fcm_token is not null;");
		// dd($fcm_tokens);

		// $objToken = array();
		// foreach($fcm_tokens as $key => $fcm) {
		// 	// dd($fcm->fcm_token);
		// 	$objToken[] = $fcm->fcm_token;
		// 	// array_push($objToken, $fcm);
		// }
		// dd($objToken[0]);
	// Shekar
		// $a[0] = "fgx3mQBysE06sevUoMArY-:APA91bGs4ITTEAcXSBf0Ufm8BmVGLfUsbW1W9h76nD124tCvW6h5pJNs5_ELZggjGjOYAjHgvlZ07iGl2yIAK5k2-9LPQBAkc1H7id5FVkMpW6q4NRwaaR2Q1X1Rs5vUZxm5F8T9Zxjz";
	// Shekar
		// $a[1] = "eOfW_wQ5TqCYjBRDKnmk8l:APA91bE5o-1gTTJf_MuQRWEUCYl5IGYEX8e7wLO84m3GPXacRkcLvQM0Bnv7i2Gqj8z9GpWFvSmdv5IGB6z1YZgwLDNXXcg8C077bW9_kVIc1snRBF3lpVR3WT4ydXevnfZzTs_FiXpj";
	// Dipak
		// $a[0] = "d6QY-sewSQ2qzez4Ev-hPg:APA91bFEXvSqXcaaYJ4j53bRqLagTYhI5hmgs4bH8NuJqmH5uWIu62kPLaL_VLINZIT5ljL-qVqljSOIUo41-KfYQI33uH4Ptza9-6Qp69-Iw_-rX-khexoH4CFB0cPU4UCIdPBqju-l";
		// $a[1] = "d6QY-sewSQ2qzez4Ev-hPg:APA91bFEXvSqXcaaYJ4j53bRqLagTYhI5hmgs4bH8NuJqmH5uWIu62kPLaL_VLINZIT5ljL-qVqljSOIUo41-KfYQI33uH4Ptza9-6Qp69-Iw_-rX-khexoH4CFB0cPU4UCIdPBqju-l";

	// // Shannon
		// $a[1] = "duznabBHs0qEjDepab_5jL:APA91bGgvLz_NysdnXxbFSer_x0DWIRra6JikneL_tlRnWPmhUZddnYSRkN8HIUrZCjps4XX1beeE7UkFdJSLeOxUYVAS7tS2QsWN68D-XjsfpwDdG0GGETdcogPVXa5-8lmaKeVju9Y";

	// // //Priyanka
	// 	$a[2] = "c5cMlLPgfENosq44-zIHlS:APA91bHA0hnz_dz26CxQqyEf-vdTBGdDxBYVIXRbl-rnq-1T3pPeWVF4zkBASIHKhWnH7eDBLaj6Xp4KyG5FGU80AVf4FHeRBkQH6NfcpLVl8dX490NqFrZYMwPITs7PF4jWZecwU7F4";

	// // //Chris
	// 	$a[3] = "eJm-8AzjSTSYACqlrDaQmA:APA91bE_aw9HExdFAK6bEO5sMUstbx3QLl-fv0GScMs5flpVu-hb4WsiICOKYTuDNTF-eGpJGr2CyHD1J8dnLIxkRq2Iq2GcviPRolXDvi5GL0t3bLbHXyqTjyOtykwulXlMkxYAXRdr";
		
		// $fcm_token = $a;
		// dd($fcm_token);


		// $ch = curl_init();
	    // curl_setopt($ch, CURLOPT_URL,"https://backend.volvmedia.com/v1/sendNotificaiton");
	    // curl_setopt($ch, CURLOPT_POST, 1);
	    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($finalObj));
	    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    // $response = curl_exec($ch);
		// curl_close ($ch);
		// dd("d");
		$successCount=0;
		$failureCount=0;
		$tokenArray=[];
		// dd($fcm_tokens);
		foreach($fcm_tokens as $token){
			// dd($token->fcm_token);
			$tokenArray[0] = $token->fcm_token;
			$finalObj=[];
			$finalObj["title"] = "";
			$finalObj["body"] = $notification_text;
			$finalObj["image_url"] = $article_image;
			$finalObj["article_id"] = $articleStack;
			$finalObj["tokens"] = $tokenArray;
			$finalJSONObj = json_encode($finalObj);
			// dd($finalJSONObj);
			$serverKey = 'AAAALpOh8nA:APA91bErQAVgKN3WTuFY9EKBchyvSWI-f2CsK6Bv4zqxsnJWoyuCbSoOMOEpGEhn-fFTQFYW3gWm96fg3RK3suCwzulNTAMQc4EP8xe_Q9UZmA80-Ace9iXR8xBlQFjzUNkjG4ZTJzxo';
	
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Authorization: key='. $serverKey;
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://backend.volvmedia.com/v1/sendNotificaiton");
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $finalJSONObj);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);			
			$response = curl_exec($ch);
	
			$finalResponse = json_decode($response);
	
			$successCount = $successCount + $finalResponse->successCount;
			$failureCount = $failureCount + $finalResponse->failureCount;
		}




		// dd($finalResponse);

		$data = new NotificationAuthorSummary();
		$data->article_id = $id;
		$data->author_id = auth()->user()->id;
		$data->notification_text = $notification_text;
		$data->notffication_status = 1;
		$data->notification_sent_count = $successCount;
		$data->notification_failure_count = $failureCount;
		

		
		// $data->save()
		// $obj = self::sendNotification($id, $article_image, $notification_text, $fcm_tokens, $articleStack);
		// // dd($obj);
		if ($data->save()) {
			return response()->json(['status' => 'success']);
		}
		else {
			return response()->json(['status' => 'failure']);

			DB::table('articles')
			->where('id', $id)
			->update(['notification_sent_status' => 0]);
		}
	}

	public function getNotificationData($id) {
		$article = Article::find($id);
		$response["article_image"] = "<img src="."'".$article->article_image."'"." width='130'>";
		$response["notification_text"] = $article->notification_text;
		$response["article_heading"] = $article->article_heading;
		$response["article_summary"] = $article->article_summary;		
		return $response;
	}

	public function notification_status_each_user(Request $request) {
		$data = DB::select('SELECT articles.id, articles.article_image, articles.notification_text FROM volv.articles where notification_sent_status=1 order by created_at desc;');
		return view('notifications.notification_list', compact('data'));
	}	

	public function getNotificationStatus(Request $request, $id) {
		$obj = Article::select('article_heading')->where('id',$id)->first();
		$article_heading = $obj->article_heading;
		// dd($article_heading);
		$data = DB::select("select * from notification_status_each_users where article_heading="."'".$article_heading."'".";");
		// dd($data);
		return view('notifications.all_user_notif_status', compact('data'));
	}


	// public function sendNotificationAPI($article_heading, $article_body, $fcms, $articleStack) {

	// }
	}