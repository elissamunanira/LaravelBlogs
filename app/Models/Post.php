<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //use HasFactory;

    //Table name
    protected $table = 'posts';
    //primary key
    public $primaryKey = 'id';
    //Timestamp
    public $timestamp = true;

    protected $fillable = [
        'title',
        'body'
    ];

    public function User(){
        return $this->belongsTo('App\Models\User');
    }
}


