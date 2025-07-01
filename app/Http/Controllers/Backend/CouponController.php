<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
}
