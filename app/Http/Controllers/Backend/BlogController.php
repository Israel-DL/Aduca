<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;


class BlogController extends Controller
{
    //
    public function AdminBlogCategory(){
        $category = BlogCategory::latest()->get();
        return view('admin.backend.blogcategory.blog_category', compact('category'));
    }

    public function BlogCategoryStore(Request $request){

        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        $notification = array(
            'message' => 'Blog Category Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification); 
    }

    public function EditBlogCategory($id){

        $categories = BlogCategory::find($id);
        return response()->json($categories);
    }

    public function BlogCategoryUpdate(Request $request){

        $cat_id = $request->cat_id;

        BlogCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);

        $notification = array(
            'message' => 'Blog Category Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteBlogCategory($id){

        BlogCategory::find($id)->delete();

        $notification = array(
            'message' => 'Blog Category Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }
}
