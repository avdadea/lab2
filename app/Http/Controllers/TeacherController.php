<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel;
use Hash;
use Auth;
use Str;


class TeacherController extends Controller
{
    public function list()
    {
        $data['getRecord']=User::getTeacher();
        $data['header_title']="Teacher List";
        return view('admin.teacher.list',$data);

    }

    public function add()
    {
        $data['header_title']="Add New Teacher";
        return view('admin.teacher.add',$data);
    }


    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
        ]);


        $teacher = new User;
        $teacher->name=trim($request->name);
        $teacher->last_name=trim($request->last_name);
        $teacher->gender=trim($request->gender);

        if(!empty($request->date_of_birth))
        {
            $teacher->date_of_birth=trim($request->date_of_birth);
           
        }

        if(!empty($request->admission_date))
        {
            $teacher->admission_date=trim($request->admission_date);
           
        }

        if(!empty($request->file('profile_picture')))
        {
            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $teacher->profile_picture = $filename;
        }

        $teacher->address=trim($request->address);
        $teacher->mobile_number=trim($request->mobile_number);
        $teacher->qualification=trim($request->qualification);
        $teacher->work_experience=trim($request->work_experience);
        $teacher->status=trim($request->status);
        $teacher->email=trim($request->email);
        $teacher->password=hash::make($request->password);
        $teacher->user_type=2;
        $teacher->save();

        return redirect('admin/teacher/list')->with('success', "Teacher successfully added"); 

    }

    public function edit($id){
        $data['getRecord']=User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title']="Edit Teacher";
            return view('admin.teacher.edit',$data);
        }
        else{
            abort(404);
        }
    
    }


    public function update($id, Request $request){
        
        request()->validate([
            'email' => 'required|email|unique:users,email,' .$id,
            'mobile_number' => 'max:15 | min:8',

        ]);


        $teacher = User::getSingle($id);
        $teacher->name=trim($request->name);
        $teacher->last_name=trim($request->last_name);
        $teacher->gender=trim($request->gender);

        if(!empty($request->date_of_birth))
        {
            $teacher->date_of_birth = trim($request->date_of_birth);
        }
       
        if(!empty($request->file('profile_picture')))
        {

            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $teacher->profile_picture = $filename;
        }

        $teacher->address=trim($request->address);
        $teacher->mobile_number=trim($request->mobile_number);
        $teacher->qualification=trim($request->qualification);
        $teacher->work_experience=trim($request->work_experience);
        $teacher->status=trim($request->status);
        $teacher->email=trim($request->email);


        if(!empty($teacher->password))
        {
        $teacher->password=hash::make($request->password);
        }
        $teacher->save();

        return redirect('admin/teacher/list')->with('success', "Teacher successfully Updated"); 
  
    }

    public function delete($id)
    {
        $getRecord=User::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete=1;
            $getRecord->save();

            return redirect()->back()->with('success',"Teacher Successfully Deleted");
        }
        else{
            abort(404);
        }
    }




}
