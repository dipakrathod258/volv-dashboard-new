<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationAuthorSummary;
use DB;
use App\Article;
use App\VolvAppUser;

class NotificationController extends Controller
{


    public function countNotificationOpens($article_id) {
        $query = 'select count(*) as count from notification_opens where article_id='.$article_id.'';
        $notification_open_count = DB::select($query);
        return $notification_open_count[0]->count;
    }

    public function index() {

        $notifications = Article::select('id','article_image','created_at','notification_text')->where('notification_text',"!=", "")->orderBy('created_at','desc')->get();                    
        
        return view('notifications.index', compact('notifications'));
    }

    public function notificationOpenRate(Request $request, $article_id) {

        $url = "https://userdata.volvmedia.com/notificationData";

        $post = [
            "article_id" => $article_id
        ];


        $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $notificationOpenUids = json_decode($response);
        $notificationOpenCount = count($notificationOpenUids);


        // dd($notificationOpenUids);      
        $notificationOpenUids = implode(",", $notificationOpenUids);  

        $notificationOpenUidsObj = [
            "uids" => $notificationOpenUids 
        ];

        $url1 = "https://api.volvmedia.com/api/getAppUserDetails";


        $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url1);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($notificationOpenUidsObj));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $obj = json_decode($response);
        $notifOpenUserDetails = $obj->user_details;
        $totalUserCount = $obj->totalUserCount;
        $total_users = $totalUserCount->total_users;
        $uniqueUserCount = $obj->uniqueUserCount;
        $unique_count = $uniqueUserCount->unique_count;
        $article = Article::select("article_heading", "notification_text", "article_image")->where('id', $article_id)->first();
        return view('notifications.notification_open_rate', compact('notifOpenUserDetails', 'article', "notificationOpenCount", "unique_count", "total_users"));
    }

    public function viewNotificationOpenUserDetails($id) {
        $url = "https://userdata.volvmedia.com/notificationData";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//Send the request
		$notif_data = curl_exec($ch);
        $notif_data = json_decode($notif_data);
        
        $notification=[];

        $opens=[];

        foreach($notif_data as $notif) {
            $articleRecords = $notif->clicked_on_notification;
            
            foreach($articleRecords as $record) {
                $article_id = (int)($record->article_id);
                $notification[$article_id][] = $notif->uid;
            }
        }   
        
            $article = Article::find((int)$id);

           $article_heading = $article->article_heading;
            $article_image = $article->article_image;
            $notification_text = $article->notification_text;

            $final["article_heading"] = $article_heading;
            $final["article_image"] = $article_image;
            $final["notification_text"] = $notification_text;

            $users = $notification[$id];
            // dd($users);
            foreach($users as $user) {
                // dd($user);
                $user = VolvAppUser::find((int)$user);
                $final["user"][] = $user->name;
            }
            // dd($final);
            $users = $final['user'];
            return view('notifications.open_rate_user_names', compact('final','users'));
    }
}
