<?php

namespace App\Http\Controllers\Traits;

trait GeneralTrait
{

    public function returnError($errNum ="R000", $msg)
    {
        return [
            
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg

        ];
    }

    public function returnSuccessMessage($msg = "" , $errNum = "S000")
    {
        return [
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg
        ];
    }

    public function returnData($key , $value , $msg)
    {
        return response()->json([

            'status' => true,
            'errNum' => "S000",
            'msg' => $msg,
            $key => $value
        ]);
    }

    public function returnUserAuth($access_token , $user)
    {
        return response()->json([

            'status' => true,
            'access_token' => $access_token,
            'token_type' => 'bearer',
            'user' => $user
        ]);
    }    

    public function returnValidationError($code = "E001" ,$validator)
    {
        return $this->returnError($code , $validator->errors());
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());

        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }   
    
    public function getErrorCode($input)
    {
        if ($input == 'name') {
            
            return 'E0011';

        }elseif ($input == 'email') {
            
            return 'E007';

        }elseif ($input == 'password') {
            
            return 'E002';

        }elseif ($input == 'phone') {
            
            return 'E003';

        }else {
            
            return "";
        }
    }
}
