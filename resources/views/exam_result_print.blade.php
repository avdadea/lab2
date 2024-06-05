<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Print Exam Result</title>
      <style type="text/css">
        @page{
            size: 8.3in 11.7in;
        }
        @page{
            size: A4;
        }
        .margin-bottom
        {

        }
        .table-bg{
            border-collapse: collapse;
            width:100%;
            font-size: 15px;
            text-align: center;
        }
        .th{
            border: 1px solid #000;
            padding:10px;
        }
        .td{
            border: 1px solid #000;
            padding:3px;
        }
        .text-container{
            text-align: left;
            padding-left:5px;
        }
        @media print{
            @page{
                margin:0px;
                margin-left: 20px;
                margin-right: 20px;
            }
        }

      </style>
   </head>
   <body>
      <div id="page">
         <table style="width: 100%; text-align: center;">
            <tr>
               <td width="5%"></td>
               <td align="center">
                  <h1>SCHOOL MODEL <br> INTERNATIONAL SCHOOL</h1>
               </td>
             </tr>
            </table>
               
              <table style="width: 100%;">
                 <tr>
                    <td width="5%"></td>
                    <td width="70%">
                     
                    <table class="margin-bottom" style="width: 100%;">
                           <tbody>
                              <tr>
                                <td width="27%">Name of Student: </td>
                                <td style="border-bottom:1px solid; width:100%;"> </td>
                              </tr>
                           </tbody>
                       </table>
                           
                    <table class="margin-bottom" style="width: 100%;">
                           <tbody>
                              <tr>
                                <td width="23%">Admission  No: </td>
                                <td style="border-bottom:1px solid; width:100%;"> </td>
                              </tr>
                           </tbody>
                       </table>

                           
                    <table class="margin-bottom" style="width: 100%;">
                           <tbody>
                              <tr>
                                <td width="22%">Class: </td>
                                <td style="border-bottom:1px solid; width:100%;"> </td>
                              </tr>
                           </tbody>
                       </table>

                           
                    <table class="margin-bottom" style="width: 100%;">
                           <tbody>
                              <tr>
                                <td width="28%">Term: </td>
                                <td style="border-bottom:1px solid; width:100%;"> </td>
                              </tr>
                           </tbody>
                       </table>

                    </td>
                    <td width="5%"></td>
                    <td width="20%" valign="top">
                        <img src="http://localhost/lab2/upload/profile/user.jpg" style="border-radius:6px;" height="100px" width="100px">
                    </td>
                </tr>
             </table>
             <br>
             <div>
             <table class="table-bg">
                <thead>
                    <tr>
                        <th class="th">Subject</th>
                        <th class="th">Class Work</th>
                        <th class="th">Home Work</th>
                        <th class="th">Exam</th>
                        <th class="th">Total Score</th>
                        <th class="th">Passing Mark</th>
                        <th class="th">Full Mark</th>
                        <th class="th">Result</th>
                    </tr>
                </thead>


                <tbody>
                    @php
                    $total_score = 0;
                    $full_marks = 0;  
                    $result_validation = 0;                      
                    @endphp
                    @foreach($getExamMark as $exam)
                    @php
                    $total_score =$total_score+ $exam['total_score'];
                    $full_marks = $full_marks + $exam['full_marks'];
                    @endphp

                    <tr>
                        <td class="td" style="width: 300px">{{ $exam['subject_name']}}</td>
                        <td class="td">{{ $exam['class_work']}}</td>
                        <td class="td">{{ $exam['home_work']}}</td>
                        <td class="td">{{ $exam['exam']}}</td>
                        <td class="td">{{ $exam['total_score']}}</td>
                        <td class="td">{{ $exam['passing_mark']}}</td>
                        <td class="td">{{ $exam['full_marks']}}</td>
                        <td class="td"> 
                            @if($exam['total_score'] >= $exam['passing_mark'])
                                <span style="color: green;"><b>Passed</b></span> 
                            @else
                                @php
                                $result_validation = 1;
                                @endphp
                                <span style="color: red;"><b>Failed</b></span>                         
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="td" colspan="2">
                            <b>Grand Total: {{$total_score}}/{{ $full_marks}} </b>
                        </td>
                        <td class="td" colspan="2">
                        @php
                        $percentage = $full_marks > 0 ? ($total_score * 100) / $full_marks : 0;
                        $getGrade = $full_marks > 0 ? App\Models\MarksGradeModel::getGrade($percentage) : 'N/A'; 
                        @endphp
                        <b>Percentage: {{ round($percentage, 2) }}%</b>
                        </td>
                        <td class="td" colspan="2"><b>Grade: {{ $getGrade }}</b></td>
                        <td class="td" colspan="3"><b>Result: 
                            @if($result_validation == 0) 
                                <span style="color: green;"><b>Passed</b></span> 
                            @else 
                                <span style="color: red;"><b>Failed</b></span>
                            @endif
                        </b></td>
                    </tr>
                </tbody>



                </table>

             </div>

             <div>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                     industry. Lorem Ipsum has been the industry's standard dummy 
                     text ever since the 1500s, when an unknown printer took a galley
                      of type and scrambled it to make a type specimen book. It has 
                      survived not only five centuries, but also the leap into electroni
                      c typesetting, remaining essentially unchanged.</p>
             </div>
             
             <table class="margin-bottom" style="width: 100%;">
                           <tbody>
                              <tr>
                                <td width=" 15%">Signature: </td>
                                <td style="border-bottom:1px solid; width:100%;"> </td>
                              </tr>
                           </tbody>
                       </table>
        </div>
        <script type="text/javascript">
     //   window.print();
        </script>
    </body>
</html>