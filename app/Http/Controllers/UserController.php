<?php
namespace App\Http\Controllers;
use DB;
use Hash;
use App\Models\User;
use App\Models\Entitie;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Flasher\Prime\FlasherInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$data = User::orderBy('id','DESC')->paginate(5);
return view('users.index',compact('data'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{

}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request,FlasherInterface $flasher)
{

    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:users,name',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|same:confirm-password',
        'roles_name' => 'required',
        'entity_id' => 'required',
    ], [
        'name.required' => 'الاسم مطلوب.',
        'name.unique' => 'الاسم موجود بالفعل.',
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
        'phone.required' => 'رقم الهاتف مطلوب.',
        'phone.unique' => 'رقم الهاتف موجود بالفعل.',
        'password.required' => 'كلمة المرور مطلوبة.',
        'password.same' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين.',
        'roles_name.required' => 'الرجاء تحديد اسم الدور.',
        'entity_id.required' => 'الفرع مطلوب.',
    ]);

    // Check if validation failed
    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $flasher->addError($error);
        }
        return redirect()->route('users.index')->withInput();
    }



    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    $user->assignRole($request->input('roles_name'));
    $flasher->addSuccess('تم اضافه المستخدم بنجاح');
    return redirect()->route('users.index');

}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$user = User::find($id);
return view('users.show',compact('user'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$user = User::find($id);
$roles = Role::pluck('name','name')->all();
$userRole = $user->roles->pluck('name','name')->all();
$branches = Entitie::where('type','internal')->get();
return view('users.edit',compact('user','roles','userRole','branches'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id,FlasherInterface $flasher)
{
    $this->validate($request, [
        'name' => 'required|unique:users,name,' . $id,
        'email' => 'required|email|unique:users,email,' . $id,
        'phone' => 'required|unique:users,phone,' . $id,
        'password' => 'same:confirm-password',
        'roles' => 'required',
        'entity_id' => 'required',
    ], [
        'name.required' => 'الاسم مطلوب.',
        'name.unique' => 'الاسم موجود بالفعل.',
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
        'phone.required' => 'رقم الهاتف مطلوب.',
        'phone.unique' => 'رقم الهاتف موجود بالفعل.',
        'password.same' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين.',
        'roles.required' => 'الرجاء تحديد الدور.',
        'entity_id.required' => 'الفرع مطلوب.',
    ]);


        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            // Use Arr::except to remove 'password' from the input array
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        $flasher->addInfo('تم تعديل المستخدم بنجاح');
        return redirect()->route('users.index');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy(Request $request,$id,FlasherInterface $flasher)
{

User::find( $request->user_id)->delete();
$flasher->addError('تم حذف المستخدم بنجاح');
return redirect()->route('users.index');
}
}
