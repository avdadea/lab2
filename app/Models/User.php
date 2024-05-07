<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Request;

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
            return "";
        }
        
    }
}
