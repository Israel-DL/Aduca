<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirm;
use App\Models\Coupon;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;


class CartController extends Controller
{
    //
    public function AddToCart(Request $request, $id){

        $course = Course::find($id);

        if (Session::has('coupon')){
            Session::forget('coupon');
        }

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

        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)
            ]);

        }

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

    public function CouponCalculation(){

        if (Session::has('coupon')) {
            # code...
            return response()->json(array(
                'subtotal' => Cart::total(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ));
        } else{
            return response()->json(array(
                'total' => Cart::total(),
            ));
        }
    }

    public function CouponRemove(){

        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Remove Successfully']);
    }

    public function CheckoutCreate(){
        if(Auth::check()){

            if(Cart::total() > 0) {
                $carts = Cart::content();
                $cartTotal = Cart::total();
                $cartQty = Cart::count();

                return view('frontend.checkout.checkout_view', compact('carts', 'cartTotal', 'cartQty'));
            } else {
                $notification = array(
                    'message' => 'Cart is empty',
                    'alert-type' => 'error',
                );
                return redirect()->to('/')->with($notification);
            }

        } else{
            $notification = array(
                'message' => 'You Need To Login First',
                'alert-type' => 'error',
            );
            return redirect()->route('login')->with($notification);
        }
    }

    public function Payment(Request $request){

        if(Session::has('coupon')){
            $total_amount = Session::get('coupon')['total_amount'];
        } else{
            $total_amount = round(Cart::total());
        }

        // Create a new payment record
        $data = new Payment();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->cash_delivery = $request->cash_delivery;
        $data->total_amount = $total_amount;
        $data->payment_type = 'Direct Payment';

        $data->invoice_no = 'EOS' . mt_rand(10000000, 99999999);
        $data->order_date = Carbon::now()->format('d F Y');
        $data->order_month = Carbon::now()->format('F');
        $data->order_year = Carbon::now()->format('Y');
        $data->status = 'pending';
        $data->created_at = Carbon::now();
        $data->save();

        foreach($request->course_title as $key => $course_title) {

            $existingOrder = Order::where('user_id', Auth::user()->id)->where('course_id', $request->course_id[$key])->first();

            if($existingOrder){
                $notification = array(
                    'message' => 'You have already enrolled for this course',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }

            $order = new Order();
            $order->payment_id = $data->id;
            $order->user_id = Auth::user()->id;
            $order->course_id = $request->course_id[$key];
            $order->instructor_id = $request->instructor_id[$key];
            $order->course_title = $course_title;
            $order->price = $request->price[$key];
            $order->save();

        } // End Foreach 

        $request->session()->forget('cart');

        

        //Start Send Email to student after purchasing course
        $paymentId = $data->id;
        $sendmail = Payment::find($paymentId);

        $data = [
            'invoice_no' => $sendmail->invoice_no,
            'amount' => $total_amount,
            'name' => $sendmail->name,
            'email' => $sendmail->email,
        ];

        Mail::to($request->email)->send(new OrderConfirm($data));
        //End Send Email to student after purchasing course


        if ($request->cash_delivery == 'stripe'){
            echo "stripe";
        }else {
            $notification = array(
                'message' => 'Cash Payment Submitted Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('index')->with($notification);
        }
    }// End Method

    public function BuyToCart(Request $request, $id){

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


    }
}
