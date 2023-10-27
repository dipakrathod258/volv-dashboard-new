<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class AppController extends Controller
{
    public function appAnalytics(Request $request) {


        $data_to_post = [
            "uid"=>1,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.volvmedia.com/api/userDisabledNotification");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_to_post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        // dd($result);

        $userDisableNotifCount =$result->userDisableNotifCount;
        $userEnableNotifCount =$result->userEnableNotifCount;
        $totalUserCount =$result->totalUserCount;
        $no_of_curated_category_saved =$result->no_of_curated_category_saved;



        $headers = [
		  'Content-Type' => 'application/json',
		  'Content-Length' => 1
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_seven_days_activities");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $result = json_decode($response);  
        // dd($result);
        // dd($cubrid_result(result, row)t);        
        $active=0;
        $inactive=0;
        foreach ($result as $key => $value) {
        	if($value->Is_Active_From_Last_7_days == true) {
        		$active+=1;
        	}
        	else {
        		$inactive+=1;
        	}
        }


// No of Uninstalled users
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/silentNotification/users_app_install_status");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        // dd($result);
        $installed_count = 0;
        $uninstalled_count = 0;
        foreach ($result as $key => $value) {
            // dd($value->isAppInstalled == false);
            if ($value->isAppInstalled == false) {
                $uninstalled_count +=1;
            }
            else if($value->isAppInstalled == true) {

                $installed_count +=1;
            }
        }
        // dd($installed_count);
        return  view("app_analytics.index", compact('totalUserCount', 'active', 'inactive', 'userDisableNotifCount', 'userEnableNotifCount', 'installed_count', 'uninstalled_count', 'no_of_curated_category_saved'));
    }


    // public function activeInactiveUsers() {
    //     return view("app_analytics.active_inactive");
    // }

    public function findActiveInactiveBasedMonth1(Request $request) {

        $month = $request->month;
        $year = $request->year;
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];
  
        $url = "http://tech.volvmedia.com/api/users/month_activities/".$month."/".$year;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  


        $monthBasedActive=0;
        $monthBasedInactive=0;

        foreach ($result as $key => $value) {
            if($value->Is_User_Active_In_Given_Month == true) {
                $monthBasedActive+=1;
            }
            else {
                $monthBasedInactive+=1;
            }
        }

        $finalResponse["month_based_active"] = $monthBasedActive;
        $finalResponse["month_based_inactive"] = $monthBasedInactive;
        $monthNum  = $month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
        $finalResponse["month_year"] = $monthName."-".$year;
        return $finalResponse;
    }  

    public function findActiveInactiveBasedMonth($month, $year) {

        // dd($request->all());

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];
  
        $url = "http://tech.volvmedia.com/api/users/month_activities/".$month."/".$year;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  


        $monthBasedActive=0;
        $monthBasedInactive=0;

        foreach ($result as $key => $value) {
            if($value->Is_User_Active_In_Given_Month == true) {
                $monthBasedActive+=1;
            }
            else {
                $monthBasedInactive+=1;
            }
        }

        $finalResponse["month_based_active"] = $monthBasedActive;
        $finalResponse["month_based_inactive"] = $monthBasedInactive;
        $monthNum  = $month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
        $finalResponse["month_year"] = $monthName."-".$year;
        return $finalResponse;
    }  


    public function activeInactiveUsers() {
        $headers = [
          'Content-Type' => 'application/json',
          'Content-Length' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_7_days_activities");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        // dd($cubrid_result(result, row)t);        
        $active=0;
        $inactive=0;
        $active1=0;
        $inactive1=0;
        $active2=0;
        $inactive2=0;
        foreach ($result as $key => $value) {
            if($value->Is_Active_From_Last_7_days == true) {
                $active+=1;
            }
            else {
                $inactive+=1;
            }
        }

        $headers = [
		  'Content-Type' => 'application/json',
		  'Content-Length' => 1
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_month_activities");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $result = json_decode($response);  
        // dd($cubrid_result(result, row)t);        
        $active1=0;
        $inactive1=0;

        foreach ($result as $key => $value) {
        	if($value->Is_Active_From_Last_Month == true) {
        		$active1+=1;
        	}
        	else {
        		$inactive1+=1;
        	}
        }



        $headers = [
          'Content-Type' => 'application/json',
          'Content-Length' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_year_activities");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        $active2=0;
        $inactive2=0;
        foreach ($result as $key => $value) {
            if($value->Is_Active_From_Last_Year == true) {
                $active2+=1;
            }
            else {
                $inactive2+=1;
            }
        }


        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];
          
          $month =  date('m');
          $year =  date('yy');

          $response = self::findActiveInactiveBasedMonth($month, $year);

          $monthBasedActive = $response['month_based_active'];
          $monthBasedInactive = $response['month_based_inactive'];
          $monthYear = $response['month_year'];


        return view("app_analytics.active_inactive", compact('active', 'inactive', 'active1', 'inactive1', 'active2', 'inactive2','monthBasedActive', 'monthBasedInactive','monthYear'));

    }

    public function activeInactiveUsersPOST(Request $request) {
        $month = $request->month;
        $year = $request->year;
        
        $headers = [
          'Content-Type' => 'application/json',
          'Content-Length' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_7_days_activities");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        // dd($cubrid_result(result, row)t);        
        $active=0;
        $inactive=0;
        $active1=0;
        $inactive1=0;
        $active2=0;
        $inactive2=0;
        foreach ($result as $key => $value) {
            if($value->Is_Active_From_Last_7_days == true) {
                $active+=1;
            }
            else {
                $inactive+=1;
            }
        }

        $headers = [
		  'Content-Type' => 'application/json',
		  'Content-Length' => 1
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_month_activities");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close ($ch);
        $result = json_decode($response);  
        // dd($cubrid_result(result, row)t);        
        $active1=0;
        $inactive1=0;

        foreach ($result as $key => $value) {
        	if($value->Is_Active_From_Last_Month == true) {
        		$active1+=1;
        	}
        	else {
        		$inactive1+=1;
        	}
        }



        $headers = [
          'Content-Type' => 'application/json',
          'Content-Length' => 1
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/last_year_activities");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        $active2=0;
        $inactive2=0;
        foreach ($result as $key => $value) {
            if($value->Is_Active_From_Last_Year == true) {
                $active2+=1;
            }
            else {
                $inactive2+=1;
            }
        }






        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];
          

          $response = self::findActiveInactiveBasedMonth($month, $year);

          $monthBasedActive = $response['month_based_active'];
          $monthBasedInactive = $response['month_based_inactive'];
          $monthYear = $response['month_year'];

        return view("app_analytics.active_inactive", compact('active', 'inactive', 'active1', 'inactive1', 'active2', 'inactive2','monthBasedActive', 'monthBasedInactive','monthYear'));

    }

    public function monthYearActiveUsers() {
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/months_wise_activities/");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        // dd($result);

        foreach($result as $r) {
            print_r($r);
        }
        exit();
        $active2=0;
        $inactive2=0;
        foreach ($result as $key => $value) {
            if($value->Is_Active_From_Last_Year == true) {
                $active2+=1;
            }
            else {
                $inactive2+=1;
            }
        }

        return view("app_analytics.month_year_count", compact('active'));

    }
    public function monthYearActiveCount() {

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/months_wise_active_users_count/2019");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  


        $finalArray = [];
        foreach ($result as $key => $value) {
            if($value->_id != "Not Found!")
                $finalArray[$value->_id] = $value->usersActive;
    
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tech.volvmedia.com/api/users/months_wise_active_users_count/2020");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result1 = json_decode($response);  
        // dd($result);

        foreach ($result1 as $key => $value) {
            if($value->_id != "Not Found!")
                $finalArray[$value->_id] = $value->usersActive;
        }
        // dd($result1);

        // dd($finalArray);

        // $active2=0;
        // $inactive2=0;
        // foreach ($result as $key => $value) {
        //     if($value->Is_Active_From_Last_Year == true) {
        //         $active2+=1;
        //     }
        //     else {
        //         $inactive2+=1;
        //     }
        // }
        return view("app_analytics.month_year_count", compact('finalArray'));


    }
    public function activity_after_register() {

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];


            $url = "http://tech.volvmedia.com/api/users/user_next_days_activities/1";


        // $url = "http://tech.volvmedia.com/api/users/user_next_days_activities/".$days;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  
        // dd($result);
        // foreach ($result as $key => $value) {
        //     dd($value->uid);
        //     dd($value->userActivityCount);            
        // }
        $days=1;
        return view("app_analytics.activity_after_register", compact('result', 'days'));
    }


    public function activity_after_register_post(Request $request) {

        $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];

          $days = $request->monthInMumbai;


        $url = "http://tech.volvmedia.com/api/users/user_next_days_activities/".$days;


        // $url = "http://tech.volvmedia.com/api/users/user_next_days_activities/".$days;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($response);  

        return view("app_analytics.activity_after_register", compact('result', 'days'));

    }

    public function articleShared() {

          $headers = [
            'Content-Type' => 'application/json',
            'Content-Length' => 1
          ];

          // $days = $request->monthInMumbai;


            $url = "http://tech.volvmedia.com/api/users/user_articles_share_count/";


            // $url = "http://tech.volvmedia.com/api/users/user_next_days_activities/".$days;


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close ($ch);
            $result = json_decode($response); 


            $total_shares = $result->totalCount;
            $shares = $result->result;
            // dd($shares);
            $data=[];
            foreach ($shares as $key => $value) {
                # code...
                array_push($data, $value->articlesShareCount);
            }
            // $data = array_values($data);

            // dd($data);
            $result =0;



            $url = "http://tech.volvmedia.com/api/users/users_articles_shared_via_platforms_count/";


            // $url = "http://tech.volvmedia.com/api/users/user_next_days_activities/".$days;


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close ($ch);
            $result2 = json_decode($response); 
            // dd($result2);
            $articles_shared=$result2;
            return view("app_analytics.articles_shared", compact('result','data', 'total_shares', 'shares', 'articles_shared'));        
    }

    public function notificationAnalysis() {
        return view("app_analytics.notification_status");
    }
    public function notificationBreakdownAnalysis() {
        return view("app_analytics.notification_breakdown_analysis");
    }


}
