<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Importers extends Model
{
    use HasFactory;
    protected $table = "importers";
    public $fillable = ['name' ,'phone' ,'address' ,'type','balance' 
    ,'user_id']; 
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
