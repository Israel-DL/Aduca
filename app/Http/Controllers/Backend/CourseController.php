<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;


class CourseController extends Controller
{
    //
    public function AllCourse(){

        $id = Auth::user()->id;
        $courses = Course::where('instructor_id',$id)->orderBy('id','desc')->get();
        return view('instructor.courses.all_courses',compact('courses'));

    }//End Method

    public function AddCourse(){

        $categories = Category::latest()->get();
        return view('instructor.courses.add_course', compact('categories'));

    }//End Method

    public function GetSubCategory($category_id){

        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
        return json_encode($subcat);

    }//End

    public function StoreCourse(Request $request){
        
        $request->validate([
            'video' => 'required|mimes:mp4|max:1000',
        ]);

        

        if ($request->file('course_image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('course_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('course_image'));
            $img = $img->resize(370,246);

            $img->toJpeg(80)->save(base_path('public/upload/course/thumbnail/'.$name_gen));
            $save_url = 'upload/course/thumbnail/'.$name_gen;
        }


        $video = $request->file('video');
        $videoName = time().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('upload/course/video/'),$videoName);
        $save_video = 'upload/course/video/'.$videoName;


        $course_id = Course::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'instructor_id' => Auth::user()->id,
            'course_title' => $request->course_title,
            'course_name' => $request->course_name,
            'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
            'description' => $request->description,
            'video' => $save_video,

            'label' => $request->label,
            'duration' => $request->duration,
            'resources' => $request->resources,
            'certificate' => $request->certificate,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'prerequisites' => $request->prerequisites,

            'bestseller' => $request->bestseller,
            'featured' => $request->featured,
            'highestrated' => $request->highestrated,
            'status' => 1,
            'course_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);


        /// Course Goals Add Form/////////////////////////////////////
        $goals = Count($request->course_goals);
        if ($goals != NULL) {
            for ($i=0; $i < $goals; $i++) { 
                # code...
                $goal_count = new Course_goal();
                $goal_count->course_id = $course_id;
                $goal_count->goal_name = $request->course_goals[$i];
                $goal_count->save();
            }
        }
        ////////// End Course Goal Add Form ///////////////////////////

        $notification = array(
            'message' => 'Course Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('all.course')->with($notification);  

    }//End method

    public function EditCourse($id){

        $course = Course::find($id);
        $goals = Course_goal::where('course_id',$id)->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        return view('instructor.courses.edit_course', compact('course', 'categories', 'subcategories', 'goals'));

    }//End Method

    public function UpdateCourse(Request $request){

        $cid = $request->course_id;



        Course::find($cid)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'instructor_id' => Auth::user()->id,
            'course_title' => $request->course_title,
            'course_name' => $request->course_name,
            'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
            'description' => $request->description,

            'label' => $request->label,
            'duration' => $request->duration,
            'resources' => $request->resources,
            'certificate' => $request->certificate,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'prerequisites' => $request->prerequisites,

            'bestseller' => $request->bestseller,
            'featured' => $request->featured,
            'highestrated' => $request->highestrated,
        ]);


        $notification = array(
            'message' => 'Course Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('all.course')->with($notification);  


    }//End Method

    public function UpdateCourseImage(Request $request){
        
        $course_id = $request->id;
        $oldImage = $request->old_img;

        if ($request->file('course_image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('course_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('course_image'));
            $img = $img->resize(370,246);

            $img->toJpeg(80)->save(base_path('public/upload/course/thumbnail/'.$name_gen));
            $save_url = 'upload/course/thumbnail/'.$name_gen;
        }

        if (file_exists($oldImage)){
            unlink($oldImage);
        }

        Course::find($course_id)->update([
            'course_image' => $save_url,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Course Image Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);  

    }

    public function UpdateCourseVideo(Request $request){
        $course_id = $request->vid;
        $oldVideo = $request->old_vid;

        $video = $request->file('video');
        $videoName = time().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('upload/course/video/'),$videoName);
        $save_video = 'upload/course/video/'.$videoName;

        if (file_exists($oldVideo)){
            unlink($oldVideo);
        }

        Course::find($course_id)->update([
            'video' => $save_video,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Course Intro Video Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);  

    }//End Method


    public function UpdateCourseGoals(Request $request){

        $cid = $request->id;
        if ($request->course_goals == NULL) {
            # code...
            return redirect()->back();
        } else{

            Course_goal::where('course_id',$cid)->delete();

             /// Course Goals Add Form/////////////////////////////////////
            $goals = Count($request->course_goals);
            
                for ($i=0; $i < $goals; $i++) { 
                    # code...
                    $goal_count = new Course_goal();
                    $goal_count->course_id = $cid;
                    $goal_count->goal_name = $request->course_goals[$i];
                    $goal_count->save();
                }// End for 
            
            ////////// End Course Goal Add Form ///////////////////////////
        }//End Else

        $notification = array(
            'message' => 'Course Goals Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification); 

    }//End method

    public function DeleteCourse($id){
        $course = Course::find($id);
        unlink($course->course_image);
        unlink($course->video);

        Course::find($id)->delete();

        $goalsData = Course_goal::where('course_id',$id)->get();
        foreach ($goalsData as $item) {
            # code...
            $item->goal_name;
            Course_goal::where('course_id',$id)->delete();
        }

        $notification = array(
            'message' => 'Course Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification); 
    }//End Method

    public function AddCourseLecture($id){

        $course = Course::find($id);

        $section = CourseSection::where('course_id',$id)->latest()->get();


        return view('instructor.courses.section.add_course_lecture', compact('course','section'));
        
    }//End Method

    public function AddCourseSection(Request $request){

        $cid = $request->id;

        CourseSection::insert([
            'course_id' => $cid,
            'section_title' => $request->section_title, 
        ]);

        $notification = array(
            'message' => 'Course Section Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);


    }//End Method

    public function SaveLecture(Request $request){

        $lecture = new CourseLecture();
        $lecture->course_id = $request->course_id;
        $lecture->section_id = $request->section_id;
        $lecture->lecture_title = $request->lecture_title;
        $lecture->url = $request->lecture_url;
        $lecture->content = $request->content;
        $lecture->save();

        return response()->json(['success' => 'Lecture Saved Successfully']);
    }//End Method

    public function EditLecture($id){

        $clecture = CourseLecture::find($id);
        return view('instructor.courses.lecture.edit_course_lecture', compact('clecture'));

    }//End Method

    public function UpdateCourseLecture(Request $request){
        $lid = $request->id;

        CourseLecture::find($lid)->update([
            'lecture_title' => $request->lecture_title,
            'url' => $request->url,
            'content' => $request->content,
        ]);

        $notification = array(
            'message' => 'Lecture Updated Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }//End Method

    public function DeleteLecture($id){

        CourseLecture::find($id)->delete();

        $notification = array(
            'message' => 'Lecture Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }//End Method

    public function DeleteSection($id){

        $section = CourseSection::find($id);

        ///Delete Related Lectures
        $section->lectures()->delete();
        ///Delete The Section
        $section->delete();
        

        $notification = array(
            'message' => 'Course Section Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
        
    }//End method
    
}
