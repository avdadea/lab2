<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ClassModel;
use App\Models\User;


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
        $data['getStudent'] = User::getSingleClass($student_id);
        $data['header_title'] = "Add Collect Fees";
    
        return view('admin.fees_collection.add_collect_fees', $data);   
    }

    public function collect_fees_insert($student_id, Request $request){
        dd($request->all());
    }
}
