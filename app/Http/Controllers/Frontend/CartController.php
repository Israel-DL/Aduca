<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function AddToCart(Request $request, $course_id){

        $course = Course::find($course_id);

        //Checks if the course is already in the cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($course_id) {
            return $cartItem->id === $course_id;
        });

        if ($cartItem->isNotEmpty()){
            return response()->json(['error' => 'Course already in cart' ]);
        }

    }//End method
}
