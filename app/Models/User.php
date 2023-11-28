<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static function getEmailSingle($email) {
        return self::where('email', '=', $email)->first();
    }

    static function getTokenSingle($remember_token) {
        return self::where('remember_token', '=', $remember_token)->first();
    }

    static function getAdmin() {
        $admins = self::select('users.*')
                    ->where('user_type', "=", "1")
                    ->where('is_deleted', "=", "0");
                    if(!empty(Request::get('email'))){
                        $admins = $admins->where('email', 'like', '%'.Request::get('email').'%');
                    };

                    if(!empty(Request::get('name'))){
                        $admins = $admins->where('name', 'like', '%'.Request::get('name').'%');
                    };

                    if(!empty(Request::get('date'))){
                        $admins = $admins->whereDate('created_at', '=', Request::get('date'));
                    };

                    if(!empty(Request::get('searchbar'))){
                        $admins = $admins->where('name', 'like', '%'.Request::get('searchbar').'%');
                    };


                    // if(!empty(Request::get('searchbar'))){
                    //     $admins = $admins->where('email', 'like', '%'.Request::get('searchbar').'%');
                    // }; NOT WORKING
        $admins = $admins->orderBy('id', 'asc')
                    // ->get(); KANI IF DILI MAG PAGINATION
                    ->paginate(20);

        return $admins;
    }

    static function getSingle($id) {
        return self::find($id);
    }

}
