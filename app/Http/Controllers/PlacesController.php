<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;
use App\Models\Places;

class PlacesController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $places = Places::all();
        return $this->returnData('places',$places , 'All places send');
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
            Places::create([
                'name' => $request->name,
                'user_id' => $user_id
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

            $place = Places::findOrFail($id);
            $place->update($reques_data);
            return $this->returnSuccessMessage('تم التعديل بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }  
    } 
    
    public function destroy($id)
    {
        try {

            $id = Places::findOrFail($id);
            $id->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }
    }    
}
