<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use App\Models\StudentAttendanceModel;
use Auth;

class AttendanceController extends Controller
{
    public function AttendanceStudent(Request $request)
    {

        $data['getClass']=ClassModel::getClass();

        if(!empty($request->class_id) && !empty($request->attendance_date))
        {
            $data['getStudent']=User::getStudentClass($request->get('class_id'));
        }
        $data['header_title']="Student Attendance";
        return view('admin.attendance.student',$data);


    }
    public function AttendanceStudentSubmit(Request $request)
    {
        // Check if attendance already exists
        $check_attendance = StudentAttendanceModel::CheckAlreadyAttendance($request->student_id, $request->class_id, $request->attendance_date);

        if (!empty($check_attendance)) {
            $attendance = $check_attendance;
        } else {
            $attendance = new StudentAttendanceModel;
            $attendance->student_id = $request->student_id;
            $attendance->class_id = $request->class_id;
            $attendance->attendance_date = $request->attendance_date;
            $attendance->created_by = Auth::user()->id;
        }

        // Update the attendance type
        $attendance->attendance_type = $request->attendance_type;
        $attendance->save();

        // Return JSON response
        return response()->json(['message' => 'Attendance successfully saved']);
    }

}
