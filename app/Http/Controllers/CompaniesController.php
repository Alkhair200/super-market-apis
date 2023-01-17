<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;
use App\Models\Companies;

class CompaniesController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $companies = Companies::all();
        return $this->returnData('companies',$companies , 'All companies send');
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
            Companies::create([
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

            $company = Companies::findOrFail($id);
            $company->update($reques_data);
            return $this->returnSuccessMessage('تم التعديل بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }  
    } 
    
    public function destroy($id)
    {
        try {

            $id = Companies::findOrFail($id);
            $id->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }
    }  
}
