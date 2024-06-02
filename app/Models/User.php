<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Request;
use Cache;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
      
    }
    static function getSingle($id){

        return self::find($id);
        
    }
     public function OnlineUser()
    {
        return Cache::has('OnlineUser'.$this->id);
    }

    static public function getTotalUser($user_type)
    {
        return self::select('users.id')
        ->where('user_type','=', $user_type)
        ->where('is_delete','=',0)
        ->count();
           
    }

    static function getSingleClass($id){

        return self::select('users.*', 'class.amount','class.name as class_name')
        ->join('class','class.id','users.class_id')
        ->where('users.id', '=',$id)
        ->first();
        }


    static public function SearchUser($search)
    {
        $return = self::select('users.*')
                 ->where(function($query) use ($search){
                    $query->where('users.name', 'like', '%' . $search.'%') 
                   ->orWhere('users.last_name', 'like', '%' . $search. '%');
                 })
        ->limit(10)
        ->get();

        return $return;
    }

    static public function getAdmin(){
        
        $return = self::select('users.*')
                            ->where('user_type','=',1)
                            ->where('is_delete','=',0);
                            if(!empty(Request::get('name')))
                            {
                                $return= $return->where('name','like', '%'.Request::get('name').'%'); 
                            }
                            if(!empty(Request::get('email')))
                            {
                                $return= $return->where('email','like', '%'.Request::get('email').'%'); 
                            }
                            if(!empty(Request::get('date')))
                            {
                                $return= $return->whereDate('created_at','=', Request::get('date')); 
                            }
        $return= $return->orderBy('id','desc')
                            ->paginate(20);
        
        return $return;                
    } 

    static public function getParent(){
        
        $return = self::select('users.*')
                            ->where('user_type','=',4)
                            ->where('is_delete','=',0);
                            if(!empty(Request::get('name')))
                            {
                                $return= $return->where('users.name','like', '%'.Request::get('name').'%');
                            }
                            
                            if(!empty(Request::get('last_name')))
                            {
                                $return= $return->where('users.last_name','like', '%'.Request::get('last_name').'%');
                            }
                            
                            if(!empty(Request::get('email')))
                            {
                                $return= $return->where('users.email','like', '%'.Request::get('email').'%');
                            }
                            if(!empty(Request::get('date')))
                            {
                                $return= $return->where('users.created_at','like', '%'.Request::get('admission_number').'%');
                            }
        $return= $return->orderBy('id','desc')
                            ->paginate(20);
        
        return $return;                
    } 



    static public function getCollectFeesStudent(){
        
        $return = self::select('users.*','class.name as class_name', 'class.amount')
                            ->join('class', 'class.id','=','users.class_id')
                            ->where('users.user_type','=',3)
                            
                        ->where('users.is_delete','=',0);

                        if(!empty(Request::get('class_id'))){
                            $return = $return->where('users.class_id', '=', Request::get('class_id') );
                        }

                        if(!empty(Request::get('student_id'))){
                            $return = $return->where('users.id', '=', Request::get('student_id') );
                        }

                        if(!empty(Request::get('first_name')))
                        {
                            $return= $return->where('users.name','like', '%'.Request::get('first_name').'%');
                        }
                        
                        if(!empty(Request::get('last_name')))
                        {
                            $return= $return->where('users.last_name','like', '%'.Request::get('last_name').'%');
                        }
        $return= $return->orderBy('users.name','asc')
                            ->paginate(50);
        
        return $return;                
    } 



    static public function getStudent(){
        
        $return = self::select('users.*','class.name as class_name','parent.name as parent_name','parent.last_name as parent_last_name')
                            ->join('users as parent','parent.id','=','users.parent_id','left')
                            ->join('class', 'class.id','=','users.class_id','left')
                            ->where('users.user_type','=',3)
                            ->where('users.is_delete','=',0);

                            if(!empty(Request::get('name')))
                            {
                                $return= $return->where('users.name','like', '%'.Request::get('name').'%');
                            }
                            
                            if(!empty(Request::get('last_name')))
                            {
                                $return= $return->where('users.last_name','like', '%'.Request::get('last_name').'%');
                            }
                            
                            if(!empty(Request::get('email')))
                            {
                                $return= $return->where('users.email','like', '%'.Request::get('email').'%');
                            }
                            if(!empty(Request::get('admission_number')))
                            {
                                $return= $return->where('users.admission_number','like', '%'.Request::get('admission_number').'%');
                            }
                            if(!empty(Request::get('date')))
                            {
                                $return= $return->where('users.created_at','like', '%'.Request::get('admission_number').'%');
                            }
        $return= $return->orderBy('users.id','desc')
                            ->paginate(20);
        
        return $return;                
    } 

    static public function getSearchStudent()
    {
        $query = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
            ->join('users as parent','parent.id','=','users.parent_id','left')
            ->join('class', 'class.id', '=', 'users.class_id', 'left')
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);
    
        // Check if search parameters are provided
        if (!empty(Request::get('id'))) {
            $query->where('users.id', 'like', '%' . Request::get('id') . '%');
        }
    
        if (!empty(Request::get('name'))) {
            $query->where('users.name', 'like', '%' . Request::get('name') . '%');
        }
    
        if (!empty(Request::get('last_name'))) {
            $query->where('users.last_name', 'like', '%' . Request::get('last_name') . '%');
        }
    
        if (!empty(Request::get('email'))) {
            $query->where('users.email', 'like', '%' . Request::get('email') . '%');
        }
    
        // Order by ID in descending order and limit the results to 50
        $result = $query->orderBy('users.id', 'desc')
            ->limit(50)
            ->get();
    
        return $result;
    }
    
   public static function getMyStudent($parent_id){

    $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
        ->join('users as parent','parent.id','=','users.parent_id','left')
        ->join('class', 'class.id', '=', 'users.class_id', 'left')
        ->where('users.user_type', '=', 3)
        ->where('users.parent_id', '=', $parent_id)
        ->where('users.is_delete', '=', 0)
        ->orderBy('users.id', 'desc')
        ->get();

        return $return;
        } 

        public static function getMyStudentCount($parent_id){

            $return = self::select('users.id')
                ->join('users as parent','parent.id','=','users.parent_id','left')
                ->join('class', 'class.id', '=', 'users.class_id', 'left')
                ->where('users.user_type', '=', 3)
                ->where('users.parent_id', '=', $parent_id)
                ->where('users.is_delete', '=', 0)
                ->count();
        
                return $return;
                } 

            static public function getMyStudentIds($parent_id)
            {
                $return = self::select('users.id')
                ->join('users as parent','parent.id','=','users.parent_id','left')
                ->join('class', 'class.id', '=', 'users.class_id', 'left')
                ->where('users.user_type', '=', 3)
                ->where('users.parent_id', '=', $parent_id)
                ->where('users.is_delete', '=', 0)
                ->orderBy('users.id', 'desc')
                ->get();

                $student_ids=array();

                foreach($return as $value)
                {
                    $student_ids[]=$value->id;
                }
                return $student_ids;
        
            }    

   
        

    static public function getPaidAmount($student_id, $class_id)
    {
        return StudentAddFeesModel::getPaidAmount($student_id, $class_id);
    }    

    static public function getEmailSingle($email)
            {
                return User::where('email','=',$email)->first();
            }

    static public function getTokenSingle($remember_token)
            {
                return User::where('remember_token','=',$remember_token)->first();
            }

    public function getProfile()
    {
        if(!empty($this->profile_picture) && file_exists('upload/profile/'. $this->profile_picture))
        {
            return url('upload/profile/'.$this->profile_picture);
        }
        else
        {
            return '';
        }
        
    }

    public function getProfileDirect()
    {
        if(!empty($this->profile_picture) && file_exists('upload/profile/'. $this->profile_picture))
        {
            return url('upload/profile/'.$this->profile_picture);
        }
        else
        {
            return url('upload/profile/user.jpg');
        }
        
    }

    static public function getAttendance($student_id, $class_id, $attendance_date)
    {
        return StudentAttendanceModel::CheckAlreadyAttendance($student_id, $class_id, $attendance_date);

    }



static     public function getTeacher(){


                $return = self::select('users.*')
                ->where('users.user_type', '=', 2)
                ->where('users.is_delete', '=', 0);

                            if (!empty(Request::get('name'))) {
                                $return = $return->where('users.name', 'like', '%' . Request::get('name') . '%');
                            }

                            
                            if(!empty(Request::get('last_name')))
                            {
                                $return= $return->where('users.last_name','like', '%'.Request::get('last_name').'%');
                            }
                            
                            if(!empty(Request::get('email')))
                            {
                                $return= $return->where('users.email','like', '%'.Request::get('email').'%');
                            }
                            if(!empty(Request::get('gender')))
                            {
                                $return= $return->where('users.gender','=', Request::get('gender'));
                            }
                            if(!empty(Request::get('mobile_number')))
                            {
                                $return= $return->where('users.mobile_number','like', '%'.Request::get('mobile_number').'%');
                            }
                            if(!empty(Request::get('address')))
                            {
                                $return= $return->where('users.address','like', '%'.Request::get('address').'%');
                            }
                                                    
                            if(!empty(Request::get('admission_date')))
                            {
                                $return= $return->where('users.admission_date','=', '%'.Request::get('admission_date'));
                            }
                            if(!empty(Request::get('date')))
                            {
                                $return= $return->where('users.created_at','like', '%'.Request::get('admission_number'));
                            }
                            if(!empty(Request::get('status')))
                            {
                                $status=(Request::get('status')==100)? 0:1;
                                $return= $return->where('users.status','=',$status);
                            }

         $return = $return->orderBy('users.id', 'desc')
                          ->paginate(20);
            
            return $return;              
    } 

    static public function getUser($user_type)
    {
       return self::select('users.*')
                 ->where('user_type', '=', $user_type)
                 ->where('is_delete', '=', 0)
                 ->get();
    }
    static public function getStudentClass($class_id){
        
        return  self::select('users.id', 'users.name','users.last_name')
                            ->where('users.user_type','=',3)
                            ->where('users.is_delete','=',0)
                            ->where('users.class_id','=',$class_id)
                            ->orderBy('users.id','desc')
                            ->get();

        
    } 
        static public function getTeacherStudent($teacher_id){
        
            $return = self::select('users.*','class.name as class_name')
                                ->join('class', 'class.id','=','users.class_id')
                                ->join('assign_class_teacher', 'assign_class_teacher.class_id','=','class.id')
                                ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                                ->where('assign_class_teacher.status','=',0)
                                ->where('assign_class_teacher.is_delete','=',0)
                                ->where('users.user_type','=',3)
                                ->where('users.is_delete','=',0);
    
                $return= $return->orderBy('users.id','desc')
                                ->groupBy('users.id')
                                ->paginate(20);
            
            return $return;                
        
    }

    
    static public function getTeacherStudentCount($teacher_id){
        
        $return = self::select('users.id')
                            ->join('class', 'class.id','=','users.class_id')
                            ->join('assign_class_teacher', 'assign_class_teacher.class_id','=','class.id')
                            ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                            ->where('assign_class_teacher.status','=',0)
                            ->where('assign_class_teacher.is_delete','=',0)
                            ->where('users.user_type','=',3)
                            ->where('users.is_delete','=',0)
                            ->count();
        
        return $return;                
    
}

    static     public function getTeacherClass(){


        $return = self::select('users.*')
        ->where('users.user_type', '=', 2)
        ->where('users.is_delete', '=', 0);
     $return = $return->orderBy('users.id', 'desc')
                  ->get();
    
    return $return;              
} 

  /*  static public function getTeacherStudent($teacher_id)
    {
        $return = self::select('users.*', 'class.name as class_name')
            ->join('class', 'class.id', '=', 'users.class_id')
            ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('assign_class_teacher.status', '=', 0)
            ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
            ->where('users.user_type', '=', 3)
            ->where('users.is_delete', '=', 0);

        $return = $return->orderBy('users.id', 'desc')
            ->paginate(20);

        return $return;
    }
    */
}
