<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function autor(){
        return $this->belongsTo(User::class,'author_id','id');
    }

    public function files(){
        return $this->belongsToMany(File::class,'file_tickets');
    }


    public function comments(){
        return $this->hasMany(Comment::class);
    }


    public function severity(){
        return $this->belongsTo(Severity::class);
    }

    public function developer(){
        return $this->belongsTo(User::class);
    }
    public function tester(){
        return $this->belongsTo(User::class);
    }

}
