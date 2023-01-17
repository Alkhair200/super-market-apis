<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HodoorEnseraf extends Model
{
    use HasFactory;
    protected $table = "hodoor_enserafs";
    public $fillable = ['name' ,'come' ,'go' ,'time','date' 
    ,'difference','notes','user','user_id'];  
}
