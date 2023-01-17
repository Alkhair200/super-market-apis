<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;
use App\Models\Products;

class ProductsController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $products = Products::all();
        return $this->returnData('products',$products , 'All Products send');
    }

    public function store(Request $request)
    {

        try {        
            $reques_data = $request->all();
            $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }

            $user_id = auth()->user()->id;
            Products::create([
                'name' => $request->name,
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

            $Product = Products::findOrFail($id);
            $Product->update($reques_data);
            return $this->returnSuccessMessage('تم التعديل بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }  
    } 
    
    public function destroy($id)
    {
        try {

            $id = Products::findOrFail($id);
            $id->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }
    }  
}
