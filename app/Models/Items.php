<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\User;
use App\Models\Companies;
use App\Models\Places;
use App\Models\Operations;


class Items extends Model
{
    use HasFactory;
    protected $table = "items";
    public $fillable = ['name' ,'barcode' ,'product_id' ,'place_id','user_id',
    'limit','max_discound','earn' ,'quntity' ,'company_id' ,'price'];      

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    
    public function place()
    {
        return $this->belongsTo(Places::class, 'place_id');
    }
    
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function operation()
    {
        return $this->hasMany(Operations::class, 'item_id');
    }     
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    
}
