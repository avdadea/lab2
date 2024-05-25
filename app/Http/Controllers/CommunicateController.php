<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NoticeBoardModel;
use App\Models\NoticeBoardMessageModel;

use Auth;


class CommunicateController extends Controller
{
    public function NoticeBoard()
    {
        $data['getRecord']=NoticeBoardModel::getRecord();
        $data['header_title']='Notice Board';
        return view('admin.communicate.noticeboard.list',$data);
    }


    public function AddNoticeBoard()
    {
        $data['header_title']='Add New Notice Board';
        return view('admin.communicate.noticeboard.add',$data);
    }

    public function InsertNoticeBoard(Request $request){

        
        $save=new NoticeBoardModel;
        $save->title=$request->title;
        $save->notice_date=$request->notice_date;
        $save->publish_date=$request->publish_date;
        $save->message=$request->message;
        $save->created_by=Auth::user()->id;
        $save->save();

        if(!empty($request->message_to))
        {

        foreach($request->message_to as $message_to)
        {
            $message=new NoticeBoardMessageModel;
            $message->notice_board_id=$save->id;
            $message->message_to = $message_to;
            $message->save();

        }

    }
        return redirect('admin/communicate/notice_board')->with('success',"Notice Board successfully created");


    }
}
