<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $permissions;
    public function __construct() {}
    public function loginToken(){
        try{
            if(Auth::check())
                return response()->json(['msg' =>'login success','data'=>Auth::user(),'status'=>'success']);
            return response()->json(['msg' =>'login failed','status'=>'fail']);
        }
        catch(Exception $e){
            Log::error('Error in loginToken: '.$e->getMessage());
            return response()->json(['msg'=>'Error in loginToken','status'=>'fail']);
        }        
    }
    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')]))
            return response()->json(['msg' =>'login success','api_token'=>Auth::user()['api_token'],'status'=>'success']);
        return response()->json(['msg' =>'login failed','status'=>'fail']);
    }
    public function logout(){
        Auth::logout();
        return response()->json(['msg'=>'logout successfully','status'=>'success']);
    }
    public function register(Request $request){
        $this->beginTransaction();
        try{
            $data= $this->dataRequest($request);
            if(User::where('email',$data['email'])->exists())
                return json_encode(['msg'=>'User already exists','status'=>'success',]);
            $data['password']=Hash::make($data['password']);
            $user = User::create($data);
            $data['api_token']=$user->createToken($data['name'])->plainTextToken;
            User::whereId($user['id'])->update(['api_token'=> $data['api_token']]);
            $this->commitTransaction();
            return response()->json(['token'=>$data['api_token'],'msg'=>'register success','status'=>'success']);
        }catch(\Exception $e){
            $this->rollbackTransaction();
            return response()->json(['msg'=>'register fails '.$e->getMessage()]);
        }
    }
    public function profile(){
        if(Auth::check())
            return response()->json(['user'=>Auth::user(),'status'=>'success']);
        return response()->json(['msg'=>'you are not login','status'=>'fail']);
    }
    public function changePassword(Request $request){}
    public function updateProfile(Request $request){}    
    public function forgotPassword(Request $request){}
}
