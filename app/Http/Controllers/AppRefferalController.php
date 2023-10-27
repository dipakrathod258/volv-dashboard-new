<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppRefferalController extends Controller
{
    public function getRefferalDetails(Request $request) {
		// dd("d");

        $url = "https://api.volvmedia.com/api/getAppRefferalDetails";
   
		// $obj = file_get_contents("http://localhost:8001/api/getAppRefferalDetails");
		
		$curl_handle=curl_init();
		curl_setopt($curl_handle, CURLOPT_URL,$url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'volv api');
		$query = curl_exec($curl_handle);
		curl_close($curl_handle);
		$referrals = json_decode($query);		
        return view('app_referral.index', compact('referrals'));
    }
}