<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    public function AdminBlogPost(){
        $post = BlogPost::latest()->get();
        return view('admin.backend.post.all_blog_post', compact('post'));
    }

    public function AddBlogPost(){
        $blogcat = BlogCategory::latest()->get();
        return view('admin.backend.post.add_blog_post', compact('blogcat'));
    }

    public function StoreBlogPost(Request $request){

        if ($request->file('post_image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('post_image')->getClientOriginalExtension();

            $img = $manager->read($request->file('post_image'));
            $img = $img->resize(370,247);

            $img->toJpeg(80)->save(base_path('public/upload/blog_post/'.$name_gen));
            $save_url = 'upload/blog_post/'.$name_gen;

            BlogPost::insert([
                'blogcat_id' => $request->blogcat_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-',$request->post_title)),
                'long_desc' => $request->long_desc,
                'post_tags' => $request->post_tags,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }//End If Conditon  

        $notification = array(
            'message' => 'Blog Post Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.blog.post')->with($notification);
    }

    public function EditBlogPost($id){

        $blogcat = BlogCategory::latest()->get();
        $post = BlogPost::find($id);
        return view('admin.backend.post.edit_blog_post', compact('post', 'blogcat'));
    }

    public function UpdateBlogPost(Request $request){

        $post_id = $request->id; 

        if ($request->file('post_image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('post_image')->getClientOriginalExtension();

            $img = $manager->read($request->file('post_image'));
            $img = $img->resize(370,247);

            $img->toJpeg(80)->save(base_path('public/upload/blog_post/'.$name_gen));
            $save_url = 'upload/blog_post/'.$name_gen;

            BlogPost::find($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-',$request->post_title)),
                'long_desc' => $request->long_desc,
                'post_tags' => $request->post_tags,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
            'message' => 'Blog Post Updated Successfully!',
            'alert-type' => 'success',
            );
            return redirect()->route('admin.blog.post')->with($notification);
            
        }else{

            BlogPost::find($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-',$request->post_title)),
                'long_desc' => $request->long_desc,
                'post_tags' => $request->post_tags,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
            'message' => 'Blog Post Updated Successfully!',
            'alert-type' => 'success',
            );
            return redirect()->route('admin.blog.post')->with($notification);
        }//End Else Statement
    }

    public function DeleteBlogPost($id){

        $post = BlogPost::find($id);
        $img = $post->post_image;
        unlink($img);

        BlogPost::find($id)->delete();
        $notification = array(
            'message' => 'Blog Post Deleted Successfully!',
            'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
    }

    public function BlogDetails($slug){
        
        $blog = BlogPost::where('post_slug',$slug)->first();
        $tags = $blog->post_tags;
        $tags_all = explode(',',$tags);
        $bcategory = BlogCategory::latest()->get();
        $post = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_details', compact('blog','tags_all','bcategory','post'));
    }

    public function BlogCatList($id){

        $blog = BlogPost::where('blogcat_id',$id)->get();
        $bcatname = BlogCategory::where('id',$id)->first();
        $bcategory = BlogCategory::latest()->get();
        $post = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_category_list', compact('blog', 'bcatname','post','bcategory'));
    }

    public function Blog(){

        $blog = BlogPost::latest()->get();
        $bcategory = BlogCategory::latest()->get();
        $post = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_list', compact('blog', 'post','bcategory'));
    }
}
