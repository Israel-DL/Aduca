<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Coupon;


class CouponController extends Controller
{
    //
    public function AdminAllCoupons(){

        $coupon = Coupon::latest()->get();

        return view('admin.backend.coupons.all_coupons', compact('coupon'));

    }//End Method 

    public function AdminAddCoupon(){

        return view('admin.backend.coupons.add_coupon');

    }//End Method  

    public function AdminStoreCoupon(Request $request){

        Coupon::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Coupon Created Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.all.coupons')->with($notification);  
    }
}
