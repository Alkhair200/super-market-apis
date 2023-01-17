<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Items;

class Operations extends Model
{
    use HasFactory;
    protected $table = "operations";
    public $fillable = ['buy_id' ,'item_id' ,'buy_quantity' ,'buy_discound','buy_expire_date' 
    ,'buy_notes','user_id'];    

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }    
    
}
