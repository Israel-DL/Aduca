<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Wishlist;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    //
    public function AddToWishList(Request $request, $course_id){

        if (Auth::check()){
            $exists = Wishlist::where('user_id', Auth::id())->where('course_id', $course_id)->first();
            
            if (!$exists){
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'course_id' => $course_id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Course Successfully added to Wishlist']);
            } else{
                return response()->json(['error' => 'Course already exist in your Wishlist']);   
            }
        } else{
            return response()->json(['error' => 'You need to login before adding this course to your Wishlist']);
        }

    }//End method

    public function AllWishlist(){

        return view('frontend.wishlist.all_wishlist');
    }//End method

    public function GetWishlistCourse(){

        $wishlist = Wishlist::with('course')->where('user_id', Auth::id())->latest()->get();

        $wishlistQty = Wishlist::count();

        return response()->json(['wishlist' => $wishlist, 'wishlistQty' => $wishlistQty]);
    }//End Method

    public function RemoveWishlist($id){

        Wishlist::where('user_id', Auth::id())->where('id',$id)->delete();

        return response()->json(['success' => 'Course removed successfully']);

    }

}
