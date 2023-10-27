<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use App\User;
use Excel;
use Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FeedbackController extends Controller
{
    public function index(Request $request) {
    	return view("feedback.create");
    }

    public function store(Request $request) {
        $count = count($request->feedback_title);
        // dd($request->all());
        // dd($count);

        for ($i=0; $i < $count; $i++) {
            if ($i==1) {
                 continue;
             } 
                // dd($request->all());
                if(isset($request->option1[$i])){
                    $option1 =$request->option1[$i];
                }
                else {
                    $option1 =null;
                }
                if(isset($request->option2[$i])){
                    $option2 =$request->option2[$i];
                }
                else {
                    $option2 =null;
                }
                if(isset($request->option3[$i])){
                    $option3 =$request->option3[$i];
                }
                else {
                    $option3 =null;
                }


                if(isset($request->option4[$i])){
                    $option4 =$request->option4[$i];
                }
                else {
                    $option4 =null;
                }

                if(isset($request->option5[$i])){
                    $option5 =$request->option5[$i];
                }
                else {
                    $option5 =null;
                }


                if (isset($request->has_slides[$i])) {
                    $slides_count = $request->slides_count[$i];
                }

                $created_at =  date("Y-m-d h:i:s");

                $response = ArticleController::cropImages($request->feedback_img_url[$i]);
                // dd($response);
                $left_pixel_color = $response["left_px_color"];
                $right_pixel_color = $response["right_px_color"];
                // dd($request->all());


                    $object1 = ['feedback_title' => $request->feedback_title[$i], 'feedback_type' => $request->feedback_type[$i], 'feedback_body' => $request->feedback_body[$i], 'options_count' => $request->option_count[$i], 'option1' => $option1, 'option2' => $option2, 'option3' => $option3, 'option4' => $option4, 'option5' => $option5, 'slider_min' => $request->slider_min[$i], 'slider_max' => $request->slider_max[$i],'slider_stops' => 1 ,'feeback_image' => $request->feedback_img_url[$i], 'created_at'=> $created_at, 'updated_at' => $created_at, "left_color" => $left_pixel_color, "right_color" => $right_pixel_color];

                    DB::table('feedback_slides')->insert($object1);

                
        }

        $query ="select id from feedback_slides order by id desc limit ".((int)$count-1).";";
        // dd($query);
        $lastInsertedIds = DB::select($query);

        // dd($lastInsertedIds);
        $lastInsertedIdsString = "";
        foreach ($lastInsertedIds as $key => $value) {
            $lastInsertedIdsString.=','.$value->id;
        }
        

        $lastInsertedIdsString = $lastInsertedIdsString;

        $lastInsertedIdsString = substr($lastInsertedIdsString, 1);
        // dd($lastInsertedIdsString);
        // dd($request->has_slides[0]);
        if ($request->has_slides[0] == "Yes") {
            $has_slides ="true";
        }
        else {
            $has_slides = "false";
        }
        // dd(boolval($has_slides));

        for ($i=0; $i < $count; $i++) {
            if ($i==0) {
                    $object = ['feedback_title' => $request->feedback_title[$i], 'feedback_type' => $request->feedback_type[$i], 'feedback_body' => $request->feedback_body[$i], 'options_count' => $request->option_count[$i], 'option1' => $option1, 'option2' => $option2, 'option3' => $option3, 'option4' => $option4, 'option5' => $option5, 'slider_min' => $request->slider_min[$i], 'slider_max' => $request->slider_max[$i],'feedback_image' => $request->feedback_img_url[$i], 'has_slides' => $has_slides, 'slides_count' =>(int)$slides_count, 'slides' => $lastInsertedIdsString, 'created_at'=> $created_at, 'updated_at' => $created_at, "left_color" => $left_pixel_color, "right_color" => $right_pixel_color, "feedback_published" => "Rollback"];

                    DB::table('feedback')->insert($object);
            }        
        }

	    return redirect('/show_feedbacks')->with("success", "Feedback saved successfully.");
    
    }

    public function show(Request $request) {

    	$feedbacks = DB::select("select * from feedback order by id desc;");
        $status_options = ["Published", "Rollback"];
        // dd($feedbacks);
    	return view('feedback.show', compact('feedbacks', "status_options"));
    }

    public function display(Request $request, $feedback_id) {
        $feedback = DB::table('feedback')->where('id', $feedback_id)->first();
        // dd($feedback);
        $feedback_option = ["Text", "Multiple", "Slider"];
        return view('feedback.display', compact('feedback', "feedback_option"));
    }
    public function updateFeedbackStatus(Request $request, $feedback_id) {
        $status = $request->feedback_published;
        // dd($status);

        $flag = DB::table('feedback')
        ->where('id', $feedback_id)
        ->update(['feedback_published' => $status]);

        DB::table('feedback')
        ->where('id','<>' ,$feedback_id)
        ->update(['feedback_published' => "Rollback"]);


        if ($flag ==1) {
            $response["status"] = "success"; 
        }
        else{
            $response["status"] = "failure"; 
        } 
        return $response;
    }
    public function feedbackResults($feedback_id, $flag=False) {
        $feedback_results = DB::select("select * from feedback_results where feedback_id = ".$feedback_id." order by id desc");
        $feedback = DB::select("select * from feedback where id = ".$feedback_id." ");
        $feedback = $feedback[0];
        // dd($feedback_id);
        // dd($feedback);

        $obj=[];
        foreach ($feedback_results as $key => $value) {
            $uid = (int)$value->user_id;
            // dd($uid);
            $user_name = DB::connection('mysql2')->select("select id, email, name from volv_users where id =".$uid." ");
            $id = $user_name[0]->id;
            $name = $user_name[0]->name;
            $user_email = $user_name[0]->email;
            // dd($user_email);
            // dd($user_name); 
            // $feedback_results[$key]->user_name = $user_name;
            $pair = $name.'-'.$user_email;
            $obj[$id][0] = $name;
            $obj[$id][1] = $user_email;
            $obj[$id]["feedback_answers"][] = $value->feedback_answer;
        }
        // dd(gettype((int)'1') == 'integer');
        foreach ($obj as $key => $value) {
           // dd($value["feedback_answers"]);
           $o = array_unique($value["feedback_answers"]);
            $obj[$key]["feedback_answers"] = $o;
        }
        // dd($obj);

        if ($flag==1) {
            // dd(json_encode($obj));
            return $obj;
        }

        return view("feedback.feedback_results", compact('obj', 'feedback_results','feedback'));
    }

    public function downloadFeedbackResults($feedback_id) {
        // dd($feedback_id);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // $articles = Article::all();

        $obj = self::feedbackResults($feedback_id, 1);
        // dd($response);

        $sheet->setCellValue('A1', "Username");
        $sheet->setCellValue('B1', "Email");
        $sheet->setCellValue('C1', "Feedback Result 1");
        $sheet->setCellValue('D1', "Feedback Result 2");
        $sheet->setCellValue('E1', "Feedback Result 3");

        $count =2;
        

        $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setAutoSize(true);

        foreach($obj as $article) {
            // dd($article["feedback_answers"]);
            // $spreadsheet->getActiveSheet()->getRowDimension($count)->setRowHeight(50);
            $sheet->setCellValue('A'.$count, $article[0]);
            $sheet->setCellValue('B'.$count, $article[1]);
            
            $feedback_answers_obj = $article["feedback_answers"];
            foreach ($feedback_answers_obj as $key => $value) {
                // dd($value);
                if ($value == "") {                    
                    $sheet->setCellValue('C'.$count, "Feedback Visited");
                }
                if ($value == "feedbackComplete" ) {
                    $sheet->setCellValue('D'.$count, "Feedback Completed" );
                }
                if (is_numeric($value)) {
                    # code...
                    $valueObj = round($value*10);
                    $sheet->setCellValue('E'.$count, $valueObj );
                }
                else {
                    $sheet->setCellValue('E'.$count, $value );

                }

            }


            // if ($article->publish_article=='Y') {
            //     $sheet->setCellValue('E'.$count, "Published");
            // }
            // else if($article->publish_article=='N') {
            //     $sheet->setCellValue('E'.$count, "In Review");                
            // }
            $count+=1;
        }
        // dd($sheet);
        $writer = new Xlsx($spreadsheet);
        $writer->save('feedback_results.xlsx');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");

    }

}
