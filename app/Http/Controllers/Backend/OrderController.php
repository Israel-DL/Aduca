<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

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
}
