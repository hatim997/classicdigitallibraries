<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function subcourse()
    {
        return $this->belongsTo(Subcourse::class, 'sub_course_id');
    }
}
