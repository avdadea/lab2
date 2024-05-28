<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Str;

class ParentController extends Controller
{
    public function list()
    {
        $data['getRecord']=User::getParent();
        $data['header_title']="Parent List";
        return view('admin.parent.list',$data);

    }
    public function add()
    {
        $data['header_title']="Add New Parent";
        return view('admin.parent.add',$data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'mobile_number' => 'max:15 | min:8',
            'address' => 'max:255',
            'occupation' => 'max:255'
        ]);


        $student = new User;
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->gender=trim($request->gender);
        $student->occupation=trim($request->occupation);
        $student->address=trim($request->address);


        if(!empty($request->file('profile_picture')))
        {
            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $student->profile_picture = $filename;
        }

        $student->mobile_number=trim($request->mobile_number);
        $student->status=trim($request->status);
        $student->email=trim($request->email);
        $student->password=hash::make($request->password);
        $student->user_type=4;
        $student->save();

        return redirect('admin/parent/list')->with('success', "Parent successfully added"); 

        
    }

    public function edit($id){
        $data['getRecord']=User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title']="Edit Parent";
            return view('admin.parent.edit',$data);
        }
        else{
            abort(404);
        }
    
    }

   public function update($id, Request $request)
   {
    request()->validate([
        'email' => 'required|email|unique:users,email,' .$id,
        'mobile_number' => 'max:15 | min:8',
        'address' => 'max:255',
        'occupation' => 'max:255'

    ]);


    $student = User::getSingle($id);

    $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->gender=trim($request->gender);
        $student->occupation=trim($request->occupation);
        $student->address=trim($request->address);


        if(!empty($request->file('profile_picture')))
        {
        if(!empty($student->getProfile()))
        {
            unlink('upload/profile/'.$student->profile_picture);
        }
        
            $ext = $request->file('profile_picture')->getClientOriginalExtension();
            $file = $request->file('profile_picture');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $student->profile_picture = $filename;
        }

        $student->mobile_number=trim($request->mobile_number);
        $student->status=trim($request->status);
        $student->email=trim($request->email);
   
    if(!empty($student->password))
    {
    $student->password=hash::make($request->password);
    }
    $student->save();

    return redirect('admin/parent/list')->with('success', "Parent successfully Updated"); 
    }

    public function delete($id)
    {
        $getRecord=User::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete=1;
            $getRecord->save();

            return redirect()->back()->with('success',"Parent Successfully Deleted");
        }
        else{
            abort(404);
        }
    }

    public function myStudent($id)
    {
        $data['getParent']=User::getSingle($id);
        $data['parent_id']=$id;
        $data['getSearchStudent']=User::getSearchStudent();
        $data['getRecord']=User::getMyStudent($id);
        $data['header_title']="Parent Student List";
        return view('admin.parent.my_student',$data);
        
    }

    public function AssignStudentParent($student_id, $parent_id){

        $user = User::getSingle($student_id); // Assuming 'User' is your model
        $user->parent_id = $parent_id;
        $user->save();
    
        return redirect()->back()->with('success', "Student Successfully Assigned");
    }


    public function AssignStudentParentDelete($student_id){
        $user = User::getSingle($student_id); // Assuming 'User' is your model
        $user->parent_id = null;
        $user->save();
    
        return redirect()->back()->with('success', "Student Successfully Assigned Deleted");
        
    }

    //parent side
    public function myStudentParent()
    {
        $id=Auth::user()->id;
        $data['getRecord']=User::getMyStudent($id);

        $data['header_title']="My Student";
        return view('parent.my_student',$data);
        
    }

}
