<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request) {
    	$categories = Category::all();
    	// dd(count($categories));
    	// dd($categories[0]->category_image_active);
    	// dd($categories);
    	// dd($categories);
    	$dir = "assets/imgs/category_images";
    	
    	// if (count($categories)>0) {
    		# code...
    	// }
    	// dd($categories[0]->category_image);
    	$category_image_path = False;
		// $category_image_path = $dir.$categories[0]->category_image;
    	// dd($category_image_path);
    	// dd($category_image_path);
    	return view("categories.index", compact('categories', 'category_image_path'));
    }

    public function edit(Request $request, $id) {
        // dd($id);
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id) {

        try {

            $this->validate($request,[
                'category_title'=> 'required',
                'category_image'=> 'required|image|max:1024',
            ]);

            // dd($request->category_title);
            // dd($request->all());
            $category = Category::find($id);

            $category_title = $request->category_title;

            $response = Category::where("category_title", $category_title)->first();


            $target_dir = "assets/imgs/category_images/";
            $unique_id = uniqid();
            // dd($target_file_dir.''.$_FILES["category_image"]["name"]);
            $category->category_title = $request->category_title;
            $category->category_image_path = $target_dir.$unique_id.''.$_FILES["category_image"]["name"];
            $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
            move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file);
            // $category->category_image_active = $request->category_image_active;
            $category->category_image_path = $target_dir.''.$_FILES["category_image"]["name"];
            if ($category->save()) {
                return response()->json(['status' => 'success']);
                # code...
            }
            else {
                dd("Server error! Please contact website admin connect@volvmedia.compact(varname)");
            }
            // dd($target_dir.''.$_FILES["category_image"]["name"]);
            // $category->category_order = $request->category_order;
            // $category->category_status = $request->category_status;
                
        } catch (Exception $e) {
            return view("error");           
        }        
    }

    public function view(Request $request, $id) {
    	$category = Category::find($id);
    	return view("categories.views", compact('category'));

    }

    public function create(Request $request) {
    	
    	return view("categories.create");
    }
    public function store(Request $request) {
    	try {

            $this->validate($request,[
                'category_title'=> 'required',
                'category_image'=> 'required|image|max:1024',
            ]);

	    	// dd($request->category_title);
	    	// dd($request->all());
	    	$category = new Category();

            $category_title = $request->category_title;

            $response = Category::where("category_title", $category_title)->first();

            if ($response) {
                $status["status"]="This article already exists!";
                return $status;
            }

			$target_dir = "assets/imgs/category_images/";
            $unique_id = uniqid();
	    	// dd($target_file_dir.''.$_FILES["category_image"]["name"]);
	    	$category->category_title = $request->category_title;
	    	$category->category_image_path = $target_dir.$unique_id.''.$_FILES["category_image"]["name"];
			$target_file = $target_dir . basename($_FILES["category_image"]["name"]);
			move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file);
	    	// $category->category_image_active = $request->category_image_active;
	    	$category->category_image_path = $target_dir.''.$_FILES["category_image"]["name"];
	    	if ($category->save()) {
                return response()->json(['status' => 'success']);
	    		# code...
	    	}
	    	else {
	    		dd("Server error! Please contact website admin connect@volvmedia.compact(varname)");
	    	}
			// dd($target_dir.''.$_FILES["category_image"]["name"]);
	    	// $category->category_order = $request->category_order;
	    	// $category->category_status = $request->category_status;
	    		
    	} catch (Exception $e) {
			return view("error");    		
    	}

    }
    public function destroy(Request $request, $id) {
    	// dd(1);
    	$category = Category::find($id);
    	$category->delete();

    	return redirect('/show_category');
    }
}
