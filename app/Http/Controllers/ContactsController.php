<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BuyOrder;
use App\Models\Location;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
{

    public function index()
    {
        $users = User::all();
        $sectors = Sector::all();
        $business = Business::all();
        $locations = Location::all();
        if (\request('search')){
            $activeUser = User::where('id',\request('search'))->first();
        } else {
            $activeUser = $users[0];
        }
        $data = [
            'users'=>$users,
            'sectors'=>$sectors,
            'business'=>$business,
            'locations'=>$locations,
            'active_user'=>$activeUser
        ];
        return view('admin.contacts.index',$data);
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user =  User::create([
            "name" => $request->user_name,
            "geog_id" => $request->location,
            "email" => $request->email,
            "phone" => $request->phone,
            "sector_id" => $request->sectors,
            "password" => Hash::make($request->password),
            "street_address" => $request->street_address,
            "comments" => $request->comment
        ]);
        $role = Role::where('name','User')->first();
        $user->assignRole($role->id);

        if ($user) {
            return response()->json(['status' => true, 'message' => 'User saved']);
        }else{
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $arr = [
            "name" => $request->user_name,
            "geog_id" => $request->location,
            "email" => $request->email,
            "phone" => $request->phone,
            "sector_id" => $request->sectors,
            "street_address" => $request->street_address,
            "comments" => $request->comment
        ];
        if ($request->password){
            $arr['password']=  Hash::make($request->password);
        }
        $user =  User::where('id',$id)->update($arr);

        if ($user) {
            return response()->json(['status' => true, 'message' => 'User update']);
        }else{
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }

    public function destroy($id)
    {
        //
    }
}
