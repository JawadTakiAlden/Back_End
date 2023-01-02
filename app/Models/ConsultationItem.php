<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query , array $filters){
        $query->when($filters['type_id'] ?? false , fn($query , $type_id) =>
        $query
            ->where('type_id' , $type_id)
        );

        $query->when($filters['search'] ?? false , fn($query , $search) =>
            $query
                ->where(fn($query , $search) =>
                    $query
                        ->where('excerpt' , 'like' , '%' . $search . '%')
                        ->orWhere('body' , 'like' , '%' . $search . '%')
                )
                ->orWhereHas('consultationType' , fn($query , $search) =>
                    $query
                        ->where('name' , 'search')
                )

        );
    }

    public function consultationType(){
        return $this->belongsTo(ConsultationType::class);
    }
}
