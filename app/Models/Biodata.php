<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $fillable = [
        'namaSiswa',
        'episode',
        'is_new',
        'folder',
        'sub_course_id',
        'audio',
        'position',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function subcourse()
    {
        return $this->belongsTo(Subcourse::class, 'sub_course_id');
    }
}
