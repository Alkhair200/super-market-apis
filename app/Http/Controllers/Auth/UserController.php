<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    use GeneralTrait;


    public function index()
    {
        $users = User::where('status' ,0)->get();
        return $this->returnData('users',$users , 'All users send');
    }


    public function store(Request $request)
    {
        try {
            $reques_data = $request->all();
            $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'email' => ['required', Rule::unique('users')],
            'job' => 'required|min:3',
            'password' =>"required|min:4"
            ]);

        if ($validator->fails()) {
            return $this->returnValidationError(404,$validator);

        }else{
            $reques_data['password'] = bcrypt($request->password);    
    
            $user = User::create($reques_data);
            return $this->returnSuccessMessage('تم الحفظ بنجاح');
        }   

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }
    }

    public function update(Request $request ,$id)
    {
        try {
        $validator = Validator::make($request->all() ,[
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'email' => ['required', Rule::unique('users')->ignore($id),],
            'address' => 'required',
            'job' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(404,$validator);

        }else{

            $user = User::findOrFail($id);
         
                $request_data = $request->all();

                $hashedPassword = $user->password;
                if ($request->c_password && $request->password) {

                    $validator = Validator::make($request->all() ,[
                        'password' => 'required|min:4',
                        'c_password' => 'required|min:4',
                    ]);
            
                    if ($validator->fails()) {
                        return $this->returnValidationError(404,$validator);
            
                    }                    
                    if (Hash::check($request->password , $hashedPassword)) {
    
                        if (!\Hash::check($request->c_password , $hashedPassword)) {
        
                            $request_data['password'] = bcrypt($request->c_password);
                           
                        }
                        else{

                            return $this->returnError(401,'لا يمكن أن تكون كلمة المرور الجديدة هي كلمة المرور القديمة!');                        
                        }

                    }
                    else{
        
                        return $this->returnError(401,'كلمة المرور القديمة غير متطابقة');     
               
                    }
                }

                $user->update($request_data);

                return $this->returnSuccessMessage('تم التعديل بنجاح');

        }  
        
    } catch (\Throwable $ex) {
        return $this->returnError(404 ,$ex->getMessage());
   }
        
    }


    public function destroy($id)
    {
        try {

            $user = User::findOrFail($id);
            $user->delete();

            return $this->returnSuccessMessage('تم الحذف بنجاح');

        } catch (\Throwable $ex) {
             return $this->returnError(404,$ex->getMessage());
        }

    }    
}
