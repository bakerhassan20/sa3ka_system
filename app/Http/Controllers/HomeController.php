<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function profile()
    {
        return view('profile');
    }

    public function profile_update(Request $request,FlasherInterface $flasher){

            $request->validate([
            'phone'=>"required",
            'name'=>"required",
            'email'=>"required|email|unique:users,email,".auth()->user()->id

            ]);
            auth()->user()->update([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'email'=>$request->email,
            ]);

            $flasher->addInfo('تم تعديل الحساب بنجاح');
            return redirect()->route('profile');


    }

    public function update_password(Request $request,FlasherInterface $flasher){
        $request->validate([
            'old_password'=>"required|string|min:8|max:190",
            'password'=>"required|string|confirmed|min:8|max:190"
        ]);
        if(Hash::check($request->old_password, auth()->user()->password)){
            auth()->user()->update([
                'password'=>Hash::make($request->password)
            ]);
           $flasher->addInfo('تم تغيير كلمة المرور بنجاح');
           return redirect()->route('profile');

        }else{
            $flasher->addError('كلمة المرور الحالية التي أدخلتها غير صحيحة');
            return redirect()->back();
        }
    }
}
