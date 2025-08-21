<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //
    public function StoreReview(Request $request){

        $course = $request->course_id;
        $instructor = $request->instructor_id;

        $request->validate([
            'comment' => 'required',
        ]);

        Review::insert([
            'course_id' => $course,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rate,
            'instructor_id' => $request->$instructor,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Review awaiting approval',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}
