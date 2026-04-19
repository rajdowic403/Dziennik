<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{

    protected $fillable = [
        'name',
        'department'
    ];
    
    public function students() {
        return $this->hasMany(User::class, 'class_group_id');
    }
}
