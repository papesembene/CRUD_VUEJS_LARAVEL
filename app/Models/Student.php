<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected  $fillable = [
        'fname',
        'lname',
        'phone',
        'email',
        'level_id',
    ];
    public function schoolclass()
    {
        return $this->belongsTo(SchoolClass::class,'level_id');
    }

}
