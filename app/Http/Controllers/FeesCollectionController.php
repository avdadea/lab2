<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use App\Models\SettingModel;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Session;

class FeesCollectionController extends Controller
{
    public function collect_fees(Request $request){
        $data['getClass'] = ClassModel::getClass();

        if(!empty($request->all())){
            $data['getRecord'] = User::getCollectFeesStudent();
        }
        $data['header_title'] = "Collect Fees";
    
        return view('admin.fees_collection.collect_fees', $data);
    } 

    public function collect_fees_add($student_id){
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = "Add Collect Fees";
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        return view('admin.fees_collection.add_collect_fees', $data);    
    }

    public function collect_fees_insert($student_id, Request $request){
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        if(!empty($request->amount)) {
            $RemainingAmount = $getStudent->amount - $paid_amount;

            if($RemainingAmount >= $request->amount) {
                $remaining_amount_user = $RemainingAmount - $request->amount;
                $payment = new StudentAddFeesModel;
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $RemainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();
                
                return redirect()->back()->with('success', 'Fees Successfully Added');
            } else {
                return redirect()->back()->with('error', 'Your amount is greater than your remaining amount');
            }
        } else {
            return redirect()->back()->with('error', 'You need to add your amount at least $1');
        }
    }

    // Student side work
    public function CollectFeesStudent(Request $request){
        $student_id = Auth::user()->id;
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = "Fees Collection";
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        return view('student.my_fees_collection', $data);    
    }

    public function CollectFeesStudentPayment(Request $request){
        $getStudent = User::getSingleClass(Auth::user()->id);
        $paid_amount = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

        if(!empty($request->amount)) {
            $RemainingAmount = $getStudent->amount - $paid_amount;
            if($RemainingAmount >= $request->amount) {
                $remaining_amount_user = $RemainingAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = Auth::user()->id;
                $payment->class_id = Auth::user()->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount = $RemainingAmount;
                $payment->remaining_amount = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;
                $payment->is_payment = 1;
                $payment->save();

                $getSetting = SettingModel::getSingle();

                if ($request->payment_type == 'Stripe') {
                    $setApiKey = $getSetting->stripe_secret;
                    $setPublicKey = $getSetting->stripe_key;

                    Stripe::setApiKey($setApiKey);
                    $finalprice = $request->amount * 100;

                    $session = StripeSession::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'usd',
                                'unit_amount' => intval($finalprice),
                                'product_data' => [
                                    'name' => 'Student Fees',
                                    'description' => 'Student Fees',
                                    'images' => [url('assets/img/logo-2x.png')],
                                ],
                            ],
                            'quantity' => 1,
                        ]],
                        'mode' => 'payment',
                        'success_url' => url('student/stripe/payment-success'),
                        'cancel_url' => url('student/stripe/payment-error'),
                    ]);

                    // Store the session ID in the Laravel session
                    Session::put('stripe_session_id', $session->id);

                    // Redirect to Stripe Checkout
                    return redirect($session->url, 303);
                }

                return redirect()->back()->with('success', 'Fees Successfully Added');
            } else {
                return redirect()->back()->with('error', 'Your amount is greater than your remaining amount');
            }
        } else {
            return redirect()->back()->with('error', 'You need to add your amount at least $1');
        }
    }

    public function PaymentSuccessStripe(Request $request){
        $getSetting = SettingModel::getSingle();
        $setApiKey = $getSetting->stripe_secret;
    
        // Retrieve the session ID from the Laravel session
        $trans_id = Session::get('stripe_session_id');
    
        if (!$trans_id) {
            \Log::error('Invalid session ID. Please try again.');
            return redirect('student/fees_collection')->with('error', "Invalid session ID. Please try again.");
        }
    
        $getFee = StudentAddFeesModel::where('stripe_session_id', '=', $trans_id)->first();
        Stripe::setApiKey($setApiKey);
        $getdata = StripeSession::retrieve($trans_id);
    
        // Log data for debugging
        \Log::info('Stripe Session Data Retrieved', [
            'session_id' => $trans_id,
            'stripe_data' => $getdata,
            'fee_data' => $getFee
        ]);
    
        // Check if data meets the conditions
        if (!empty($getdata->id) && $getdata->id == $trans_id && !empty($getFee)) {
            \Log::info('Session IDs match and fee data is present.');
    
            if ($getdata->status == 'complete' && $getdata->payment_status == 'paid') {
                \Log::info('Stripe session status and payment status are valid.');
    
                $getFee->is_payment = 1;
                $getFee->payment_data = json_encode($getdata);
                $getFee->save();
    
                Session::forget('stripe_session_id');
    
                \Log::info('Payment was successful. Redirecting with success message.');
    
                return redirect('student/fees_collection')->with('success', "Your Payment was Successful");
            } else {
                \Log::error('Stripe session status or payment status are not valid.', [
                    'status' => $getdata->status,
                    'payment_status' => $getdata->payment_status
                ]);
            }
        } else {
            \Log::error('Session ID or fee data do not match.', [
                'stripe_session_id' => $getdata->id,
                'trans_id' => $trans_id,
                'fee_data' => $getFee
            ]);
        }
    
        return redirect('student/fees_collection')->with('error', "Due to some error, please try again");
    }
    
    
    

    public function PaymentError() {
        return redirect('student/fees_collection')->with('error', "Due to some error, please try again");
    }

    public function PaymentSuccess(Request $request){
        if (!empty($request->item_number) && !empty($request->st) && $request->st == 'Completed') {
            $fees = StudentAddFeesModel::getSingle($request->item_number);
            if (!empty($fees)) {
                $fees->is_payment = 1;
                $fees->payment_data = json_encode($request->all());
                $fees->save();
                return redirect('student/fees_collection')->with('success', "Your Payment Successfully");
            } else {
                return redirect('student/fees_collection')->with('error', "Due to some error, please try again");
            }
        } else {
            return redirect('student/fees_collection')->with('error', "Due to some error, please try again");
        }
    }
}
