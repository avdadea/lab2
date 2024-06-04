
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Print Exam Result</title>
      <style type="text/css">
        @page {
            size: 8.3in 11.7in;
        }
        @page {
            size: A4;
        }
        .margin-bottom{
         margin-bottom: 3px;
        }
        .table-bg{
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
        .th{
            border:1px solid #000;
            padding: 10px;
        }
        .td{
            border:1px solid #000;
            padding: 3px;
        }
        .text-container{
             text-align: left;
             padding-left: 5px;

        }
        @media print {
            @page {
            margin: 0px;
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
         <td width="15%"><img style="width: 110px;" src="C:\xampp\htdocs\lab2\upload\logo"></td>
         <td align="left">
            <h1>SCHOOL MODEL 
               INTERNATIONAL SCHOOL
            </h1>
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
                <td width="27%">Name Of Student : </td>
                <td style="border-bottom: 1px solid; width: 100%;"></td>
                </tr>
           </tbody>
         </table>


         <table class="margin-bottom" style="width: 100%;">
           <tbody>
                <tr>
                <td width="23%">Admission No : </td>
                <td style="border-bottom: 1px solid; width: 100%;"></td>
                </tr>
           </tbody>
         </table>

         <table class="margin-bottom" style="width: 100%;">
           <tbody>
                <tr>
                <td width="23%">Class : </td>
                <td style="border-bottom: 1px solid; width: 100%;"></td>
                </tr>
           </tbody>
         </table>

            <table class="margin-bottom" style="width: 100%;">
                <tbody>
                    <tr>
                        <td width="11%">Term : </td>
                        <td style="border-bottom: 1px solid; width: 80%;"></td>
                    </tr>
                </tbody>
             </table>

             <table class="margin-bottom" style="width: 100%;">
                <tbody>
                    <tr>
                        <td width="19%">Total Score : </td>
                        <td style="border-bottom: 1px solid; width: 50%;"></td>
                        <td width="16%">Average: </td>
                        <td style="border-bottom: 1px solid; width: 50%;"></td>
                    </tr>
                </tbody>
             </table>

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
                    <tr>
                        <td class="td text-container">LAB1</td>
                        <td class="td">5</td>
                        <td class="td">20</td>
                        <td class="td">50</td>
                        <td class="td">75</td>
                        <td class="td"></td>
                        <td class="td"></td>
                        <td class="td"> 
                            <span style="color: green;"><b>Passed</b></span> 
                        </td>
                    </tr>

                
                    <tr>
                        <td class="td text-container" colspan="1">
                          <b>Grand Total: 441/600</b>
                        </td>
                        <td class="td" colspan="3">
                          <b>Percentage: 73.5%</b>
                        </td>
                        <td class="td" colspan="1">
                           <b>Grade: C</b>
                        </td>
                        <td class="td" colspan="3">
                          <b>Result:
                        <span style="color: green; ">Pass</span>
                        </b>
                        </td>
                    </tr>
     
                </tbody>
                </table>
      </div>

      <div>

      <p>Lorem Ipsum is simply dummy text of the printing and typesetting 
        industry. Lorem Ipsum has been the industry's standard dummy text 
        ever since the 1500s, when an unknown printer took a galley of type 
        and scrambled it to make a type specimen book. It has survived not 
        only five centuries, but also the leap into electronic typesetting, 
        remaining essentially unchanged. It was popularised in the 1960s 
        with the release of Letraset sheets containing Lorem Ipsum passages, 
        and more recently with desktop publishing software like Aldus PageMaker
         including versions of Lorem Ipsum.</p>
</div>
            <table class="margin-bottom" style="width: 100%;">
                <tbody>
                        <tr>
                        <td width="15%">Signature : </td>
                        <td style="border-bottom: 1px solid; width: 100%;"></td>
                        </tr>
                </tbody>
                </table>



</div>

<script type="text/javascript">
   // window.print();
</script>
</body>
</html>