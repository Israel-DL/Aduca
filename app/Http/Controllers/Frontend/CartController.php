<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    //
    public function AddToCart(Request $request, $id){

        $course = Course::find($id);

        //Checks if the course is already in the cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });

        if ($cartItem->isNotEmpty()){
            return response()->json(['error' => 'Course already in cart' ]);
        }

        if ($course->discount_price == NULL){
            
            Cart::add([
                'id' => $id,
                'name' => $request->course_name,
                'qty' => '1',
                'price' => $course->selling_price,
                'weight' => 1,
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                ],
            ]);

        }else{

            Cart::add([
                'id' => $id,
                'name' => $request->course_name,
                'qty' => '1',
                'price' => $course->discount_price,
                'weight' => 1,
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                ],
            ]);
        }    

        return response()->json(['success' => 'Course successfully added to cart']);

    }//End method

    public function CartData(){

        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));
    }//End Method

    public function GetMiniCart(){

        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));


    }//End Method

    public function RemoveMiniCart($rowId){

        Cart::remove($rowId);

        return response()->json(['success' => 'Course removed from cart']);
    }//End Method

    public function MyCart(){

        return view('frontend.mycart.view_mycart');
    }//End Method

    public function GetMyCart(){
        
        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));

    }//End Method

    public function RemoveMyCart($rowId){

        Cart::remove($rowId);

        return response()->json(['success' => 'Course removed from cart']);
    }//End Method

    public function ApplyCoupon(Request $request){

        $coupon = Coupon::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();

        if($coupon){
            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)
            ]);

            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully'
            ));
        }else{
            return response()->json(['error' => 'Invalid Coupon']);
        }


    }
}
