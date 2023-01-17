<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Customers extends Model
{
    use HasFactory;
    protected $table = "customers";
    public $fillable = ['name' ,'phone' ,'address' ,'type','balance' 
    ,'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
