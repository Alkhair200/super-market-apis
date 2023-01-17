<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;
use App\Models\Operations;
use App\Models\Places;

class OperationsController extends Controller
{
    use GeneralTrait;    

    public function index()
    {
        # code...
        $operations = Operations::with('item')->orderBy('created_at','desc')->get();

        $operations->filter(function($value , $key){
            $place = Places::findOrFail($value->item->place_id);
            return $value->item->place_id = $place->name;
        });

        return $this->returnData('operations',$operations , 'All operations send');        
    }
    
    public function store(Request $request)
    {
        try {        

            $validator = Validator::make($request->all() ,[
            'buy_quantity' => 'required|numeric',
            'buy_discound' => 'required|numeric',
            'buy_expire_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }

            $user_id = auth()->user()->id;
            Operations::create([
                'buy_id' => 1 ,// من جدول المشتريات BuyBill
                'item_id' => $request->item_id,
                'buy_quantity' =>$request->buy_quantity,
                'buy_discound' =>$request->buy_discound,
                'buy_expire_date' =>$request->buy_expire_date,
                'buy_notes' =>$request->buy_notes,
                'user_id' => $user_id,
            ]);
            return $this->returnSuccessMessage('تم الحفظ بنجاح'); 
        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }    

    }   

    public function update(Request $request ,$id)
    {
        // dd($request);
        try {  
            
            $validator = Validator::make($request->all() ,[
                'buy_quantity' => 'required|numeric',
                'buy_discound' => 'required|numeric',
                'buy_expire_date' => 'required|date',
                ]);
    
                if ($validator->fails()) {
                    return $this->returnValidationError(404,$validator);
                }
                            
            $operation = Operations::findOrFail($id);
            $operation->update([
                'buy_quantity' =>$request->buy_quantity,
                'buy_discound' =>$request->buy_discound,
                'buy_expire_date' =>$request->buy_expire_date,
                'buy_notes' =>$request->buy_notes,
            ]);
            return $this->returnSuccessMessage('تم التعديل بنجاح'); 
        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }    

    }       

    public function destroy($id)
    {
        try {

            $id = Operations::findOrFail($id);
            $id->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }
    }
}
