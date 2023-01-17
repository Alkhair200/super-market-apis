<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralTrait;
use Validator;
use App\Models\HodoorEnseraf;
use App\Models\User;
use Carbon\Carbon;

class HodoorEnserafController extends Controller
{
    use GeneralTrait;
    public function hodoorUser()
    {
        $users = User::where('status' ,0)->select('name','id')->get();
        return $this->returnData('users',$users , 'All user send');
    }  

    public function getHodoor()
    {
        $date =now()->format('Y-m-d');
        $hodoors = HodoorEnseraf::where('go' ,null)->get();
        return $this->returnData('hodoors',$hodoors , 'All hodoors send');
    }

    public function getُEnseraf()
    {
        $date =now()->format('Y-m-d');
        $hodoors = HodoorEnseraf::where('date',$date)->get();
        return $this->returnData('enseraf',$hodoors , 'All hodoors send');
    }
    
    public function storeHodoor(Request $request)
    {
        // dd(now()->format('g:i:s'));
        try {  

            $validator = Validator::make($request->all() ,[
            'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }

            $checkHodoorUser = HodoorEnseraf::where('user',$request->user_id)->get();
            if ($checkHodoorUser) {
                $date =now()->format('Y-m-d');
                foreach ($checkHodoorUser as $value) {
                    if ($value->date == $date) {
                        return $this->returnError(404,'تم تسجيل هذا المستخدم اليوم');
                    }
                }
            }

            $user_id = auth()->user()->id;
            $user = User::findOrFail($request->user_id);

            $come =now()->format('Y-m-d g:i:s');
            $time =now()->format('g:i:s A');
            $date =now()->format('Y-m-d');
            
            $hodoor = HodoorEnseraf::create([
                'name' =>$user->name,
                'come' => $come,
                'date' =>$date,
                'time' =>$time,
                'notes' =>$request->notes,
                'user_id' =>$user_id,
                'user' =>$user->id
            ]);
            return $this->returnSuccessMessage('تم تسجيل الحضور بنجاح');

        } catch (\Throwable $ex) {
            return $this->returnError(404,$ex->getMessage());
        }  
    } 

    public function enseraf(Request $request ,$id)
    {
        $enseraf = HodoorEnseraf::findOrFail($id);

        // وقت الانصراف
        // $go = date_create(now()->format('Y-m-d g:i:s'));
        // $come = date_create($enseraf->come);

        // $dateDiff =  date_diff($go,$come);

        // حساب الحضور و الانصراف الفرق بالساعات    
        $finshDate = Carbon::parse(now()->format('g:i:s'));
        $startDate = Carbon::parse($enseraf->come);
        $totalDuration = $finshDate->diffInMinutes($startDate)/60;
        //   diffForHumans
        // dd($totalDuration);
        // dd($dateDiff->h .':'.$dateDiff->i .':'.$dateDiff->s);

        $enseraf->update([
            'go' =>$finshDate,
            'difference' =>$totalDuration
        ]);
        return $this->returnSuccessMessage('تم إنصراف الموظف بنجاح');
    }

    public function reportUser(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all() ,[
            'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(404,$validator);
            }
            $report = "";
        // $user = HodoorEnseraf::findOrFail($request->user);
        if (!empty($request->to) && empty($request->from)) {
            $report = HodoorEnseraf::where('difference' ,'!=' ,null)->where('user' ,$request->user_id)->where('date' ,'<=',$request->to)->get();

        }else if(empty($request->to) && !empty($request->from)){
            $report = HodoorEnseraf::where('difference' ,'!=' ,null)->where('user' ,$request->user_id)->where('date' ,'>=',$request->from)->get();

        }else if(!empty($request->to) && !empty($request->from)){
            $report = HodoorEnseraf::where('difference' ,'!=' ,null)->where('user' ,$request->user_id)->whereBetween('date' ,[$request->from, $request->to])->get();
        }

        $totalDuration = 0;
        foreach ($report as $value) {
            $totalDuration += $value->difference;
        }

        return response()->json([
            "status"=> true ,
            "report"=>$report ,
             "totalDuration" => $totalDuration,
              "msg"=>'All report user send'
        ]);
    }
}
