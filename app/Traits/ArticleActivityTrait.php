<?php
 
namespace App\Traits;
 
use Illuminate\Http\Request;
 
trait ArticleActivityTrait {
 
    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */
    // public function verifyAndStoreImage( Request $request, $fieldname = 'image', $directory = 'unknown' ) {
 
    //     if( $request->hasFile( $fieldname ) ) {
 
    //         if (!$request->file($fieldname)->isValid()) {
 
    //             flash('Invalid Image!')->error()->important();
 
    //             return redirect()->back()->withInput();
 
    //         }
 
    //         return $request->file($fieldname)->store('image/' . $directory, 'public');
 
    //     }
 
    //     return null;
 
    // }

    public static function secondsConverter($timeSecond) {
        $timeFirst  = strtotime(date('Y-m-d H:i:s', time()));
        $timeSecond = strtotime($timeSecond);
        $differenceInSeconds =  $timeFirst - $timeSecond;    
        return $differenceInSeconds;
    }

    public function timeConverter($articles) {
        foreach ($articles as $key => $value) {
            $value=(array)$value;
            $seconds = self::secondsConverter($value["updated_at"]);
            if(!($seconds > 86400)) {
                $converted_time = self::articlePublishTimeConverter($value["updated_at"]);
                $articles[$key]->time_ago = $converted_time;
            }
            else {
                $articles[$key]->time_ago = $value["updated_at"];
            }
        }
        return $articles;
    }

}