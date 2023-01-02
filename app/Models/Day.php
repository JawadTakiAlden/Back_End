<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;


    public function scopeFilter($query , array $filters){
        $query->when($filters['expert_id'] ?? false , fn($query , $expert_id) =>
            $query
                ->with('avTimes')
                ->whereHas('avTimes' , fn($query) =>
                    $query->where('expert_id' , $expert_id)
                )
        );
    }

    public function workTimes(){
        return $this->hasMany(WorkTime::class);
    }

    public function avTimes(){
        return $this->hasMany(AvTime::class);
    }
}
