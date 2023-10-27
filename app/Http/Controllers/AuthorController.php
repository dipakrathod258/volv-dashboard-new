<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\User;
use Mail;
use Hash;

class AuthorController extends Controller
{
    public function indexUser(Request $request){
    	$authors = Author::select('author_name', 'author_email')->get();
        $users = User::all();
    	return view("users.index", compact('authors', 'users'));
    }

    public function createNewAuthor(Request $request) {
    	// dd($request->all());
    	return view("users.create");
    }

    public function submitNewAuthor(Request $request) {
    	// dd($request->all());

        $this->validate($request,[
            'author_name'=> 'required',
            'email'=> 'required',
        ]);


        $email = $request["email"];
        $response = Author::where("author_email", $email)->first();

        if ($response) {
            $status["status"]="This author already exists!";
            return $status;
        }

        $response = User::where("email", $email)->first();

        if ($response) {
            $status["status"]="This author already exists!";
            return $status;
        }

        $data = new User();
        $data->name = $request["author_name"];
        $data->email = $email;
        $data->password = Hash::Make('volv@123');
        $data->save();


    	$author = new Author();
    	$author->author_name = $request["author_name"];
        $author->author_email = $email;
        $author->password = "volv@123";

        // $target_dir = "assets/imgs/author_profile_pics/";
        // $unique_id= uniqid();
        // $author->profile_image = $target_dir.$unique_id.''.$_FILES["profile_image"]["name"];
        // $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        // move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        // // $category->category_image_active = $request->category_image_active;
        // $author->profile_image = $target_dir.''.$_FILES["profile_image"]["name"];

    	if($author->save()) {
            $title="User Registration";
            $message = "Welcome to Volv Dashboard!";
            $message_data = ["message" => $message, "email"=>$email];
            Mail::send('users.welcome_author_mail', ['title' => $title, 'message_data' => $message_data], function ($message) use($message_data)
            {
                $message->from('connect@volvmedia.com');
                $message->to($message_data['email'])->subject('Welcome to Volv Dashboard');
            });

            return response()->json(['status' => 'success']);
        }
    }

    public function editAuthor(Request $request, $id){
    	$user = User::find($id);
    	return view("users.edit", compact('user'));
    }

    public function updateAuthor(Request $request, $id) {  


        $email = $request["email"];

        $user = User::find($id);
        $user->name = $request["author_name"];
        $user->email = $email;
        $user->password = "volv@123";

        // $target_dir = "assets/imgs/author_profile_pics/";
        // $unique_id= uniqid();
        // $author->profile_image = $target_dir.$unique_id.''.$_FILES["profile_image"]["name"];
        // $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        // move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        // // $category->category_image_active = $request->category_image_active;
        // $author->profile_image = $target_dir.''.$_FILES["profile_image"]["name"];

        if($user->update()) {
            return response()->json(['status' => 'success']);
        }

    }
    public function deleteAuthor(Request $request, $id) {
    	$user = User::find($id);
    	$user->delete();
    	return redirect("/create_user");
    }

 }