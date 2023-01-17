<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;
use App\Http\Controllers\Traits\GeneralTrait;

class AuthController extends Controller
{
    use GeneralTrait;
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify', ['except' => 'login']);
    // }

    public function login(Request $request)
    {
        // return response()->json($request);
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if ($validate->fails()) {
            return $this->returnValidationError(404,$validate);
        } 
        if (!$token = JWTAuth::attempt($validate->validated())) {
            return $this->returnError(401,'بيانات الدخول غير صحيحة');
        }

        return $this->createNewToken($token);
    }  

    public function register(Request $request)
    {
        $reques_data = $request->all();
        $validate = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => ['required', Rule::unique('users')],
            'password' => 'required|min:4',
            'c_password' => 'required|same:password',
            'address' => 'required',
            'phone' => 'required|min:10',
        ]);

        if ($validate->fails()) {
            return $this->returnValidationError('404',$validate);
        } 

        $reques_data['password'] = bcrypt($request->password);
        $user = User::create($reques_data);

        return $this->returnSuccessMessage('تم الحفظ بنجاح');
        
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
                if ($request->new_password && $request->old_password) {
                    if (Hash::check($request->old_password , $hashedPassword)) {
    
                        if (!\Hash::check($request->new_password , $hashedPassword)) {
        
                            $request_data['password'] = bcrypt($request->new_password);
                           
                        }
                        else{

                            return $this->returnError(404,'لا يمكن أن تكون كلمة المرور الجديدة هي كلمة المرور القديمة!');                        
                        }

                    }
                    else{
        
                        return $this->returnError(404,'كلمة المرور القديمة غير متطابقة');     
               
                    }
                }

                $user->update($request_data);

                return $this->returnSuccessMessage('تم التعديل بنجاح');

        }  
        
      } catch (\Throwable $ex) {
        return $this->returnError(404 ,$ex->getMessage());
     }
        
    } 
    
    
    public function logout(Request $request)
    {

        $token = $request['token'];

        if ($token) {

            try {

                // borken access controller or user enumeratoion
                JWTAuth::setToken($token)->invalidate(); // logout
                
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                
                return $this->returnError('E0001' , 'some thing want wrong');

            }

            return $this->returnSuccessMessage('تم ستجيل الخروج بنجاح');

        } else {
            
            return $this->returnError('E0001' , 'some thing want wrong');
        }        
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    
    protected function createNewToken($token)
    {
        return $this->returnUserAuth($token , auth()->user());
    }    
}
