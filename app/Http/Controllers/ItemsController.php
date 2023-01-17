<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;
use App\Models\Items;

class ItemsController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $items = Items::with('place','company','product')->get();
        return $this->returnData('items',$items , 'All Items send');
    }

    public function store(Request $request)
    {
        try {        
            $reques_data = $request->all();
            $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            'barcode' =>'required',
            'limit' =>'required',
            'max_discound' =>'required',
            'earn' =>'required',
            'quntity' =>'required|min:1',
            'price' =>'required',
            'company_id' =>'required',
            'place_id' =>'required',
            'product_id' =>'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }

            $user_id = auth()->user()->id;
            Items::create([
                'name' => $request->name,
                'barcode' =>$request->barcode,
                'limit' =>$request->limit,
                'max_discound' =>$request->max_discound,
                'earn' =>$request->earn,
                'quntity' =>$request->quntity,
                'price' =>$request->price,              
                'company_id' => $request->company_id,
                'place_id' => $request->place_id,
                'product_id' => $request->product_id,
                'user_id' => $user_id,
            ]);
            return $this->returnSuccessMessage('تم الحفظ بنجاح'); 
        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }    

    }   
    
    public function update(Request $request ,$id)
    {
        try {        
            $reques_data = $request->all();
            $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }

            $item = Items::findOrFail($id);
            $item->update($reques_data);
            return $this->returnSuccessMessage('تم التعديل بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }  
    } 
    
    public function destroy($id)
    {
        try {

            $id = Items::findOrFail($id);
            $id->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }
    } 
}
