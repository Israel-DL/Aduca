<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    //
    public function AdminPendingOrders(){

        $payment = Payment::where('status', 'pending')->orderBy('id', 'DESC')->get();
        return view('admin.backend.orders.pending_orders', compact('payment'));
    }//End Method

    public function AdminOrderDetails($payment_id){

        $payment = Payment::where('id', $payment_id)->first();
        $orderItems = Order::where('payment_id', $payment_id)->orderBy('id', 'DESC')->get();

        return view('admin.backend.orders.admin_order_details', compact('payment', 'orderItems'));
    }

    public function AdminConfirmPendingOrder($payment_id){

        Payment::find($payment_id)->update(['status' => 'confirmed']);

        $notification = array(
            'message' => 'Order Confirmed Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.confirmed.orders')->with($notification);  
    }

    public function AdminConfirmedOrders(){

        $payment = Payment::where('status', 'confirmed')->orderBy('id', 'DESC')->get();
        return view('admin.backend.orders.confirmed_orders', compact('payment'));
    }

    public function InstructorAllOrders(){

        $id = Auth::user()->id;
        $orderItems = Order::where('instructor_id', $id)->orderBy('id','desc')->get();

        return view('instructor.orders.all_orders', compact('orderItems'));
    }

    public function InstructorOrderDetails($payment_id){

        $payment = Payment::where('id', $payment_id)->first();
        $orderItems = Order::where('payment_id', $payment_id)->orderBy('id', 'DESC')->get();

        return view('instructor.orders.instructor_order_details', compact('payment', 'orderItems'));
    }

    public function InstructorOrderInvoice($payment_id){

        $payment = Payment::where('id', $payment_id)->first();
        $orderItems = Order::where('payment_id', $payment_id)->orderBy('id', 'DESC')->get();

        $pdf = Pdf::loadView('instructor.orders.order_pdf', compact('payment','orderItems'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }
}
