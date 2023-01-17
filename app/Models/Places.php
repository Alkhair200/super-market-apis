<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Places extends Model
{
    use HasFactory;
    protected $table = "places";
    public $fillable = ['name'];     
    
}
