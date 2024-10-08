<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\FeesCollectionController;
use App\Http\Controllers\ChatController;



Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);


Route::group(['middleware' => \App\Http\Middleware\CommonMiddleware::class], function(){
    Route::get('chat', [ChatController::class, 'chat']);
    Route::post('submit_message', [ChatController::class, 'submit_message']);
    Route::post('get_chat_windows', [ChatController::class, 'get_chat_windows']);
    Route::post('get_chat_search_user', [ChatController::class, 'get_chat_search_user']);

});

Route::get('admin/account', [UserController::class, 'MyAccount']);
Route::post('admin/account', [UserController::class, 'UpdateMyAccountAdmin']);

Route::get('admin/setting', [UserController::class, 'Setting']);
Route::post('admin/setting', [UserController::class, 'UpdateSetting']);





Route::get('admin/admin/list', function () {
    return view('admin.admin.list');
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});


Route::group(['middleware' => AdminMiddleware::class], function (){
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);
   
    
        //Teacher 
    Route::get('admin/teacher/list', [TeacherController::class, 'list']);
    Route::get('admin/teacher/add', [TeacherController::class, 'add']);
    Route::post('admin/teacher/add', [TeacherController::class, 'insert']);
    Route::get('admin/teacher/edit/{id}', [TeacherController::class, 'edit']);
    Route::post('admin/teacher/edit/{id}', [TeacherController::class, 'update']);
    Route::get('admin/teacher/delete/{id}', [TeacherController::class, 'delete']);
    
    //student
    Route::get('admin/student/list', [StudentController::class, 'list']);
    Route::get('admin/student/add', [StudentController::class, 'add']);
    Route::post('admin/student/add', [StudentController::class, 'insert']);
    Route::get('admin/student/edit/{id}', [StudentController::class, 'edit']);
    Route::post('admin/student/edit/{id}', [StudentController::class, 'update']);
    Route::get('admin/student/delete/{id}', [StudentController::class, 'delete']);

    //parent

    Route::get('admin/parent/list', [ParentController::class, 'list']);
    Route::get('admin/parent/add', [ParentController::class, 'add']);
    Route::post('admin/parent/add', [ParentController::class, 'insert']);
    Route::get('admin/parent/edit/{id}', [ParentController::class, 'edit']);
    Route::post('admin/parent/edit/{id}', [ParentController::class, 'update']);
    Route::get('admin/parent/delete/{id}', [ParentController::class, 'delete']);
    Route::get('admin/parent/my_student/{id}', [ParentController::class, 'myStudent']);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}', [ParentController::class, 'AssignStudentParent']);
    Route::get('admin/parent/assign_student_parent_delete/{student_id}', [ParentController::class, 'AssignStudentParentDelete']);


   // class url
   Route::get('admin/class/list', [ClassController::class, 'list']);
   Route::get('admin/class/add', [ClassController::class, 'add']);
   Route::post('admin/class/add', [ClassController::class, 'insert']);
   Route::get('admin/class/edit/{id}', [ClassController::class, 'edit']);
   Route::post('admin/class/edit/{id}', [ClassController::class, 'update']);
   Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);

   // subject url
   Route::get('admin/subject/list', [SubjectController::class, 'list']);
   Route::get('admin/subject/add', [SubjectController::class, 'add']);
   Route::post('admin/subject/add', [SubjectController::class, 'insert']);
   Route::get('admin/subject/edit/{id}', [SubjectController::class, 'edit']);
   Route::post('admin/subject/edit/{id}', [SubjectController::class, 'update']);
   Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);

    // assign_subject

   Route::get('admin/assign_subject/list', [ClassSubjectController::class, 'list']);
   Route::get('admin/assign_subject/add', [ClassSubjectController::class, 'add']);
   Route::post('admin/assign_subject/add', [ClassSubjectController::class, 'insert']);
   Route::get('admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'edit']);
   Route::post('admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'update']);
   Route::get('admin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete']);
   Route::get('admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'edit_single']);
   Route::post('admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'update_single']);

   //class_timetable
   Route::get('admin/class_timetable/list', [ClassTimetableController::class, 'list']);
   Route::post('admin/class_timetable/get_subject', [ClassTimetableController::class, 'get_subject']);
   Route::post('admin/class_timetable/add', [ClassTimetableController::class, 'insert_update']);


   // assign_class_teacher

   Route::get('admin/assign_class_teacher/list', [AssignClassTeacherController::class, 'list']);
   Route::get('admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'add']);
   Route::post('admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'insert']);
   Route::get('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'edit']);
   Route::post('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'update']);
   Route::get('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'edit_single']);
   Route::post('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'update_single']);
   Route::get('admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);


   Route::get('admin/change_password', [UserController::class, 'change_password']);
   Route::post('admin/change_password', [UserController::class, 'update_change_password']);   

    


});
  
//examination

    Route::get('admin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);
    Route::get('admin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);
    Route::post('admin/examinations/exam/add', [ExaminationsController::class, 'exam_insert']);
    Route::get('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);
    Route::post('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_update']);
    Route::get('admin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']);
   
   
    Route::get('admin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('admin/examinations/exam_schedule_insert', [ExaminationsController::class, 'exam_schedule_insert']);

    Route::get('admin/examinations/marks_register', [ExaminationsController::class, 'marks_register']);
    Route::post('admin/examinations/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);
    Route::post('admin/examinations/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

    Route::get('admin/examinations/marks_grade', [ExaminationsController::class, 'marks_grade']);
    Route::get('admin/examinations/marks_grade/add', [ExaminationsController::class, 'marks_grade_add']);
    Route::post('admin/examinations/marks_grade/add', [ExaminationsController::class, 'marks_grade_insert']);
    Route::get('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'marks_grade_edit']);
    Route::post('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'marks_grade_update']);
    Route::get('admin/examinations/marks_grade/ delete/{id}', [ExaminationsController::class, 'marks_grade_delete']);
   

    Route::get('admin/attendance/student', [AttendanceController::class, 'AttendanceStudent']);
    Route::post('admin/attendance/student/  ve', [AttendanceController::class, 'AttendanceStudentSubmit']);

    Route::get('admin/attendance/report', [AttendanceController::class, 'AttendanceReport']);

    Route::get('admin/communicate/notice_board', [CommunicateController::class, 'NoticeBoard']);
    Route::get('admin/communicate/notice_board/add', [CommunicateController::class, 'AddNoticeBoard']);
    Route::post('admin/communicate/notice_board/add', [CommunicateController::class, 'InsertNoticeBoard']);
    
    Route::get('admin/communicate/notice_board/edit/{id}', [CommunicateController::class, 'EditNoticeBoard']);
    Route::post('admin/communicate/notice_board/edit/{id}', [CommunicateController::class, 'UpdateNoticeBoard']);
    Route::get('admin/communicate/notice_board/delete/{id}', [CommunicateController::class, 'DeleteNoticeBoard']);

    Route::get('admin/communicate/send_email', [CommunicateController::class, 'SendEmail']);
    Route::post('admin/communicate/send_email', [CommunicateController::class, 'SendEmailUser']);

    Route::get('admin/communicate/search_user', [CommunicateController::class, 'SearchUser']);
   
    Route::get('admin/fees_collection/collect_fees', [FeesCollectionController::class, 'collect_fees']);
    Route::get('admin/fees_collection/collect_fees_report', [FeesCollectionController::class, 'collect_fees_report']);


    Route::get('admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class, 'collect_fees_add']);
    Route::post('admin/fees_collection/collect_fees/add_fees/{student_id}', [FeesCollectionController::class, 'collect_fees_insert']);


    
    //teacher middleware

Route::group(['middleware' => TeacherMiddleware::class], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('teacher/change_password', [UserController::class, 'change_password']);
    Route::post('teacher/change_password', [UserController::class, 'update_change_password']);   

    Route::get('teacher/account', [UserController::class, 'MyAccount']);
    Route::post('teacher/account', [UserController::class, 'UpdateMyAccount']);

    Route::get('teacher/my_student', [StudentController::class, 'MyStudent']);


    Route::get('teacher/my_class_subject', [AssignClassTeacherController::class, 'MyClassSubject']);
    Route::get('teacher/my_class_subject/class_timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'MyTimetableTeacher']);

    Route::get('teacher/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetableTeacher']);


    Route::get('teacher/marks_register', [ExaminationsController::class, 'marks_register_teacher']);
    Route::post('teacher/submit_marks_register', [ExaminationsController::class, 'submit_marks_register']);
    Route::post('teacher/single_submit_marks_register', [ExaminationsController::class, 'single_submit_marks_register']);

    Route::get('teacher/attendance/student', [AttendanceController::class, 'AttendanceStudentTeacher']);
    Route::post('teacher/attendance/student/save', [AttendanceController::class, 'AttendanceStudentSubmit']);

    Route::get('teacher/attendance/report', [AttendanceController::class, 'AttendanceReportTeacher']);

    Route::get('teacher/my_notice_board', [CommunicateController::class, 'MyNoticeBoardTeacher']);

});
//student 
Route::group(['middleware' => StudentMiddleware::class], function () {
    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('student/account', [UserController::class, 'MyAccount']);
    Route::post('student/account', [UserController::class, 'UpdateMyAccountStudent']);
    

    Route::get('student/my_subject', [SubjectController::class, 'MySubject']);
    Route::get('student/my_timetable', [ClassTimetableController::class, 'MyTimetable']);

    Route::get('student/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetable']);


    Route::get('student/change_password', [UserController::class, 'change_password']);
    Route::post('student/change_password', [UserController::class, 'update_change_password']);   
    
    Route::get('student/my_exam_result', [ExaminationsController::class, 'myExamResult']);
   
    Route::get('student/my_exam_result/print', [ExaminationsController::class, 'myExamResultPrint']);
   
    Route::get('student/my_attendance', [AttendanceController::class, 'myAttendanceStudent']);
    
    Route::get('student/my_notice_board', [CommunicateController::class, 'MyNoticeBoardStudent']);

    Route::get('student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudent']);
    Route::post('student/fees_collection', [FeesCollectionController::class, 'CollectFeesStudentPayment']);

    Route::get('student/paypal/payment-error', [FeesCollectionController::class, 'PaymentError']);
    Route::get('student/paypal/payment-success', [FeesCollectionController::class, 'PaymentSuccess']);

    Route::get('student/stripe/payment-error', [FeesCollectionController::class, 'PaymentError']);
    Route::get('student/stripe/payment-success', [FeesCollectionController::class, 'PaymentSuccessStripe']);

    

});

//parent
Route::group(['middleware' => ParentMiddleware::class], function () {
    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);

    
    Route::get('parent/account', [UserController::class, 'MyAccount']);
    Route::post('parent/account', [UserController::class, 'UpdateMyAccountParent']);
    Route::get('parent/change_password', [UserController::class, 'change_password']);
    Route::post('parent/change_password', [UserController::class, 'update_change_password']);   

    Route::get('parent/my_student/subject/{student_id}', [SubjectController::class, 'ParentStudentSubject']);
    Route::get('parent/my_student/exam_timetable/{student_id}', [ExaminationsController::class, 'ParentMyExamTimetable']);

    Route::get('parent/my_student/exam_result/{student_id}', [ExaminationsController::class, 'ParentMyExamResult']);
    Route::get('parent/my_student/subject/class_timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class, 'MyTimetableParent']);
    
    Route::get('parent/my_student/attendance/{student_id}', [AttendanceController::class, 'myAttendanceParent']);

    Route::get('parent/my_student', [ParentController::class, 'myStudentParent']);

    Route::get('parent/my_notice_board', [CommunicateController::class, 'MyNoticeBoardParent']);

    Route::get('parent/my_student_notice_board', [CommunicateController::class, 'MyStudentNoticeBoardParent']);


    Route::get('parent/my_student/fees_collection/{student_id}', [FeesCollectionController::class, 'CollectFeesStudentParent']);

    Route::post('parent/my_student/fees_collection/{student_id}', [FeesCollectionController::class, 'CollectFeesStudentPaymentParent']);

    Route::get('parent/stripe/payment-error/{student_id}', [FeesCollectionController::class, 'PaymentErrorParent']);
    Route::get('parent/stripe/payment-success/{student_id}', [FeesCollectionController::class, 'PaymentSuccessStripeParent']);
    


});