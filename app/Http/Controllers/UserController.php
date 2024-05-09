<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class UserController extends Controller
{
    public function MyAccount()
    {
        $data['getRecord']=User::getSingle(Auth::user()->id);
        $data['header_title']= "My Account";
        if(Auth::user()->user_type ==1)
        {
            return view('admin.my_account', $data);
        }
        else if(Auth::user()->user_type ==2)
        {
            return view('teacher.my_account', $data);
        }

       else if(Auth::user()->user_type ==3)
       {
        return view('student.my_account', $data);

       }
       else if(Auth::user()->user_type ==4)
       {
        return view('parent.my_account', $data);

       }

    }

    public function UpdateMyAccount(Request $request){
        $id=Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' .$id,
            'mobile_number' => 'max:15 | min:8',
            'marital_status' => 'max:50',

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

        $teacher->marital_status=trim($request->marital_status);
        $teacher->address=trim($request->address);
        $teacher->mobile_number=trim($request->mobile_number);
        $teacher->permanent_address=trim($request->permanent_address);
        $teacher->qualification=trim($request->qualification);
        $teacher->work_experience=trim($request->work_experience);
        $teacher->email=trim($request->email);

        $teacher->save();

        return redirect()->back()->with('success', "Account successfully Updated"); 
    }

    public function UpdateMyAccountStudent(Request $request){

        $id=Auth::user()->id;

        request()->validate([
            'email' => 'required|email|unique:users,email,' .$id,
            'weight' => 'max:10',
            'blood_group' => 'max:10',
            'mobile_number' => 'max:15 | min:8',
            'caste' => 'max:50',
            'religion' => 'max:50',
            'height' => 'max:10'

        ]);


        $student = User::getSingle($id);
        $student->name=trim($request->name);
        $student->last_name=trim($request->last_name);
        $student->gender=trim($request->gender);

        if(!empty($request->date_of_birth))
        {
            $student->date_of_birth = trim($request->date_of_birth);
        }
       
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

        $student->caste=trim($request->caste);
        $student->religion=trim($request->religion);
        $student->mobile_number=trim($request->mobile_number);
        if(!empty($request->admission_date))
        {
        $student->admission_date=trim($request->admission_date);
        }
        $student->blood_group=trim($request->blood_group);
        $student->height=trim($request->height);
        $student->weight=trim($request->weight);
        $student->email=trim($request->email);
        $student->save();

        return redirect('admin/student/list')->with('success', "Student successfully Updated"); 
    }

  
    public function UpdateMyAccountParent(Request $request){

        $id=Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' .$id,
            'mobile_number' => 'max:15 | min:8',
            'address' => 'max:255',
            'occupation' => 'max:255'
    
        ]);
    
    
        $parent = User::getSingle($id);
    
            $parent->name=trim($request->name);
            $parent->last_name=trim($request->last_name);
            $parent->gender=trim($request->gender);
            $parent->occupation=trim($request->occupation);
            $parent->address=trim($request->address);
    
    
            // if(!empty($request->file('profile_picture')))
            // {
            //     if(!empty($parent->getProfile()))
            //     {
            //         unlink('upload/profile/'.$student->profile_picture);
            //     }
            //     $ext = $request->file('profile_picture')->getClientOriginalExtension();
            //     $file = $request->file('profile_picture');
            //     $randomStr = date('Ymdhis').Str::random(20);
            //     $filename = strtolower($randomStr).'.'.$ext;
            //     $file->move('upload/profile/', $filename);
            //     $parent->profile_picture = $filename;
            // }
    
    
            $parent->mobile_number=trim($request->mobile_number);
            $parent->email=trim($request->email);
       
     
        $parent->save();
    
        return redirect()->back()->with('success', "Account successfully Updated"); 
        



    }

    public function UpdateMyAccountAdmin(Request $request){

        $id=Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,' .$id
        ]);

        $admin =User::getSingle($id);
        $admin->name=trim($request->name);
        $admin->email=trim($request->email);
        if(!empty($request->password))
        {
            $admin->password=Hash::make($request->password);
        }
        $admin->save();

        return redirect()->back()->with('succcess',"Account successfully updated");

    }

    public function change_password()
    {
        $data['header_title']= "Change Password";
       return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
       $user= User::getSingle(Auth::user()->id);
       if(Hash::check($request->old_password, $user->password))
       {
           $user->password= Hash::make($request->new_password);
           $user->save();
            return redirect()->back()->with('success', "Password successfully updated");
       }
       else
       {
             return redirect()->back()->with('error', "Old password is not correct");
       }
    }
}
