<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = []; //We can pass here columns which are need to be guarded i.e Columns which are specified cannot to filled using create method

    public function blogs() {
        return $this->belongsToMany(Blog::class)->withTimestamps();
    }
}
