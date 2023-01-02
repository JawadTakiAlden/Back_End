<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded =[
        'id'
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
    ];

    public function setPasswordAttribute ($password){
        return $this->attributes['password'] = bcrypt($password);
    }

    public function setImageAttribute ($image){
        $newImageName = uniqid() . '_' . 'image' . '.' . $image->extension();

        $image->move(public_path('images') , $newImageName);

        return $this->attributes['image'] = public_path('images') . "/" . $newImageName;
    }

    public function scopeFilter($query , array $filters){
//        // Filter by role
//        $query->when($filters['role_id'] ?? false , fn($query , $role_id) =>
//            $query
//                ->whereHas('role' , fn($query) =>
//                    $query
//                        ->where('id' , $role_id)
//                )
//        );
//        // Filter by id
//        $query->when($filters['expert_id'] ?? false , fn($query , $expert_id) =>
//            $query
//                ->where('id' , $expert_id)
//                ->whereHas('role' , fn($query) =>
//                    $query
//                        ->where('id' , 2)
//                )
//
//        );
//        // Filter by first or last name
//
//        $query->when($filters['name'] ?? false , fn($query , $name) =>
//        $query
//            ->where(fn($query) =>
//                $query
//                    ->where('first_name' , 'like' , '%' . $name . '%')
//                    ->orWhere('last_name' , 'like' , '%' . $name . '%')
//            )
//            ->whereHas('role' , fn($query) =>
//                $query
//                    ->where('id' , 2)
//                )
//
//        );
//
//        // Filter by consultation type
//
//        $query->when($filters['type_id'] ?? false , fn($query , $type_id) =>
//            $query
//                ->whereHas('role' , fn($query) =>
//                    $query->where('id' , 2)
//                )
//                ->whereHas('consultationItems' , fn($query , $type_id) =>
//                    $query->whereHas('consultationType' , fn($query , $type_id) =>
//                        $query->where('id' , $type_id)
//                    )
//                )
//        );

        // Search

        $query->when($filters['search'] ?? false , fn($query , $search) =>
        $query
            ->where(fn($query) =>
            $query
                ->where('first_name' , 'like' , '%' . $search . '%')
                ->orWhere('last_name' , 'like' , '%' . $search . '%')
            )
            ->whereHas('role' , fn($query) =>
            $query
                ->where('id' , 2)
            )

        );

        $query->when($filters['type_id'] ?? false , fn($query , $type_id) =>
            $query
                ->whereHas('consultationItems' , fn($query , $type_id) =>
                    $query
                        ->whereHas('consultationType' , fn($query , $type_id) =>
                            $query
                                ->where('id' , $type_id)
                        )
                )
        );

    }

    public function workTimes(){
        return $this->hasMany(WorkTime::class);
    }

    public function skills(){
        return $this->hasMany(Skill::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function consultationItems(){
        return $this->hasMany(ConsultationItem::class);
    }
    public function dates(){
        return $this->hasMany(Date::class);
    }
    public function AvTimes(){
        return $this->hasMany(AvTime::class);
    }
}
