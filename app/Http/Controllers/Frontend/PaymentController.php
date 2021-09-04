<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function index() {

        return view('frontend.payment.payment');
    }
    

    public function checkout() {
        
        return redirect("/payment/complete");
    }


    public function complete() {

        return view('frontend.payment.complete');
    }
}
