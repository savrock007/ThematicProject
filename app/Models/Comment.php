<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function author(){
        return $this->belongsTo(User::class,'author_id','id');
    }

    public function files(){
        return $this->belongsToMany(File::class,'file_comments');
    }
}
