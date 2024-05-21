<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ExamModel;
use App\Models\ClassModel;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;


class ExaminationsController extends Controller
{
    public function exam_list()
    {
        $data['getRecord']=ExamModel::getRecord();
        $data['header_title']="Exam List";
        return view('admin.examinations.exam.list',$data);

    }
    public function exam_add()
    {
        $data['header_title']="Add New Exam";
        return view('admin.examinations.exam.add',$data);

    }
    public function exam_insert(Request $request)
    {

         $exam = new ExamModel;
         $exam->name=trim($request->name);
         $exam->note=trim($request->note);
         $exam->created_by=Auth::user()->id;
         $exam->save();

         return redirect('admin/examinations/exam/list')->with('success',"Exam successfully created");

    }

    public function exam_edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if(!empty($data['getRecord']))
        {
        $data['header_title']="Edit Exam";
        return view('admin.examinations.exam.edit',$data);
        }else
        {
            abort(404);
        }

    }

    public function exam_update($id, Request $request)
    {

         $exam = ExamModel::getSingle($id);
         $exam->name=trim($request->name);
         $exam->note=trim($request->note);
         $exam->save();

         return redirect('admin/examinations/exam/list')->with('success',"Exam successfully updated");

    }

    public function exam_delete($id)
    {
        $getRecord = ExamModel::getSingle($id);
        if(!empty($getRecord))
        {
           $getRecord->is_delete=1;
           $getRecord->save();

           return redirect()->back()->with('admin/examinations/exam/list')->with('success',"Exam successfully deleted");

        }
        else
        {
            abort(404);
        }

    }
      
      public function exam_schedule(Request $request)
      {
        $data['getClass']=ClassModel::getClass();
        $data['getExam']=ExamModel::getExam();


        $result=array();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $getSubject=ClassSubjectModel::MySubject($request->get('class_id'));
            foreach($getSubject as $value)
            {
                $dataS['subject_id']=$value->subject_id;
                $dataS['class_id']=$value->class_id;
                $dataS['subject_name']=$value->subject_name;
                $dataS['subject_type']=$value->subject_type;

                $ExamSchedule=ExamScheduleModel::getRecordSingle($request->get('exam_id'),$request->get('class_id'),$value->subject_id);
               if(!empty($ExamSchedule))
               {

                   $dataS['exam_date'] = $ExamSchedule->exam_date;
                   $dataS['start_time'] = $ExamSchedule->start_time;
                   $dataS['end_time'] = $ExamSchedule->end_time;
                   $dataS['room_number'] = $ExamSchedule->room_number;
                   $dataS['full_marks'] = $ExamSchedule->full_marks;
                   $dataS['passing_mark'] = $ExamSchedule->passing_mark;
                }
               else
               {
                   $dataS['exam_date'] = '';
                   $dataS['start_time'] = '';
                   $dataS['end_time'] = '';
                   $dataS['room_number'] = '';
                   $dataS['full_marks'] = '';
                   $dataS['passing_mark'] = '';

               }
                $result[]=$dataS;

            }
        }
        $data['getRecord']=$result;

        $data['header_title']="Exam Schedule";
        return view('admin.examinations.exam_schedule',$data);
       
      }

      public function exam_schedule_insert(Request $request)
{
    ExamScheduleModel::deleteRecord($request->exam_id, $request->class_id);
     if(!empty($request->schedule)) {
        foreach ($request->schedule as $schedule) {
            if (!empty($schedule['subject_id']) && !empty($schedule['exam_date']) && !empty($schedule['start_time']) && !empty($schedule['end_time'])
                && !empty($schedule['room_number'])  && !empty($schedule['passing_mark'])) {
                
                // Instantiate ExamScheduleModel
                $exam = new ExamScheduleModel;
                
                // Assign properties
                $exam->exam_id = $request->exam_id;
                $exam->class_id = $request->class_id;
                $exam->subject_id = $schedule['subject_id'];
                $exam->exam_date = $schedule['exam_date'];
                $exam->start_time = $schedule['start_time'];
                $exam->end_time = $schedule['end_time'];
                $exam->room_number = $schedule['room_number'];
                $exam->grades = $schedule['full_marks'];
                $exam->grades = $schedule['passing_mark'];
                $exam->created_by = Auth::user()->id;

                // Save the exam schedule
                $exam->save();
            }
        }
    }

    // Redirect with success message
    return redirect()->back()->with('success', "Exam Schedule successfully saved");
}


// student side
    public function MyExamTimetable(Request $request){
        

        $class_id = Auth::user()->class_id;
        $getExam = ExamScheduleModel::getExam($class_id);
        $result = array();
        foreach($getExam as $value){
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable = ExamScheduleModel::getExamTimetable($value->exam_id, $class_id);
            $resultS = array();
          foreach($getExamTimetable as $valueS){
            $dataS = array();
            $dataS['subject_name'] = $value->subject_name;
            $dataS['exam_date'] = $value->exam_date;
            $dataS['start_time'] = $value->start_time;
            $dataS['end_time'] = $value->end_time;
            $dataS['room_number'] = $value->room_number;
            $dataS['full_marks'] = $value->full_marks;
            $dataS['passing_mark'] = $value->passing_mark;
        
            $resultS[] = $dataS;

          }

          $dataE['exam'] = $resultS;
          $result[] = $dataE;

        }
        $data['getRecord'] = $result;
        $data['header_title']="My Exam Timetable";
        return view('student.my_exam_timetable',$data);

    }

}
