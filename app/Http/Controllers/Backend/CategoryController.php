<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class CategoryController extends Controller
{
    public function AllCategory(){

        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));

    }//End Method

    public function AddCategory(){
        return view('admin.backend.category.add_category');
    }//End Method

    public function StoreCategory(Request $request){

        if ($request->file('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('image')->getClientOriginalExtension();

            $img = $manager->read($request->file('image'));
            $img = $img->resize(370,246);

            $img->toJpeg(80)->save(base_path('public/upload/category_images/'.$name_gen));
            $save_url = 'upload/category_images/'.$name_gen;

            Category::insert([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
                'image' => $save_url,
            ]);
        }//End If Conditon  

        $notification = array(
            'message' => 'Category Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('all.category')->with($notification);        
    }//End Method 

    public function EditCategory($id){

        $category = Category::find($id);
        return view('admin.backend.category.edit_category',compact('category'));

    }//End Method

    public function UpdateCategory(Request $request){

        $cat_id = $request->id; // "id" is the hidden id from the edit_category.blade.php file

        if ($request->file('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('image')->getClientOriginalExtension();

            $img = $manager->read($request->file('image'));
            $img = $img->resize(370,246);

            $img->toJpeg(80)->save(base_path('public/upload/category_images/'.$name_gen));
            $save_url = 'upload/category_images/'.$name_gen;

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
                'image' => $save_url,
            ]);//End If Conditon  

            $notification = array(
                'message' => 'Category Updated with image Successfully!',
                'alert-type' => 'success',
            );
            return redirect()->route('all.category')->with($notification);
        }else{

            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-',$request->category_name)),
            ]);//End If Conditon  

            $notification = array(
                'message' => 'Category Updated without image Successfully!',
                'alert-type' => 'success',
            );
            return redirect()->route('all.category')->with($notification);
        }//End Else Statement
        

    }//End Method 

    public function DeleteCategory($id){

        $item = Category::find($id);
        $img = $item->image;
        unlink($img);

        Category::find($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }//End Method



    /////////////////// All SubCategory Methods ///////////////////// AddSubCategory
    public function AllSubCategory(){
        $subcategory = SubCategory::latest()->get();
        return view('admin.backend.subcategory.all_subcategory', compact('subcategory'));
    }//End Method

    public function AddSubCategory(){
        $category = Category::latest()->get();
        return view('admin.backend.subcategory.add_subcategory', compact('category'));
    }//End Method  

    public function StoreSubCategory(Request $request){

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'SubCategory Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('all.subcategory')->with($notification); 
    }//End Method 

    public function EditSubCategory($id){

        $category = Category::latest()->get();
        $subcategory = SubCategory::find($id);
        return view('admin.backend.subcategory.edit_subcategory',compact('category','subcategory'));

    }//End Method

    public function UpdateSubCategory(Request $request){

        $subcat_id = $request->id;

        SubCategory::find($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('all.subcategory')->with($notification); 

    }

    public function DeleteSubCategory($id){

        SubCategory::find($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification); 

    }

}
