<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Importers;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;

class ImportersController extends Controller
{
    use GeneralTrait; 

    public function index()
    {
        $importer = Importers::all();
        return $this->returnData('importer',$importer , 'All Importers send');
    }

    public function store(Request $request)
    {

        try {
            $reques_data = $request->all();
            $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'address' => 'required|min:3',
            'balance' => 'required',
            'type' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }
            
            $user_id = auth()->user()->id;
            Importers::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'type' => $request->type,
                'balance' => $request->balance,
                'user_id' => $user_id
            ]);
            return $this->returnSuccessMessage('تم الحفظ بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $reques_data = $request->all();
            $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'address' => 'required|min:3',
            'balance' => 'required',
            'type' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
                
            }
            
            $importer = Importers::findOrFail($id);
            $importer->update($reques_data);
            return $this->returnSuccessMessage('تم التعديل بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $id = Importers::findOrFail($id);
            $id->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }
    }
}
