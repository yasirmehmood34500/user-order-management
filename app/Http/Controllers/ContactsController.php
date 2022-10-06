<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BuyOrder;
use App\Models\Company;
use App\Models\Holding;
use App\Models\Location;
use App\Models\matching;
use App\Models\Sector;
use App\Models\SellOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
{

    public function index()
    {
        if (Auth::user()->hasRole('Admin')) {
            $users = User::with(['Location', 'Sector'])->orderBy('name', 'ASC')->get();
        }else{
            $users = User::with(['Location','Sector'])->where('id','!=',1)->orderBy('name','ASC')->get();
        }
        $sectors = Sector::all();
        $business = Business::all();
        $locations = Location::all();
        $companies = Company::all();
        $share_classes = DB::table('shareclass')->get();
        $categories = DB::table('usercategory')->get();
        $structures = DB::table('structure')->get();
        if (\request('search')){
            $activeUser = User::where('id',\request('search'))->first();
        } else {
            if (Auth::user()->hasRole('Admin')) {
                $activeUser = $users[0];
            }else{
                $activeUser = User::where('id',Auth::id())->first();
            }
        }
        $data = [
            'users'=>$users,
            'sectors'=>$sectors,
            'business'=>$business,
            'locations'=>$locations,
            'active_user'=>$activeUser,
            'companies'=>$companies,
             'share_classes'=>$share_classes,
            'categories'=>$categories,
            'structures'=>$structures,
        ];
        return view('admin.contacts.index',$data);
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'email'=>'required|unique:users,email',
           'password'=>'required',
           'user_name'=>'required',
        ]);
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
    public function DeleteUserRecord(Request $request){
        SellOrder::where('user_id',$request->id)->delete();
        BuyOrder::where('user_id',$request->id)->delete();
        Holding::where('user_id',$request->id)->delete();
        matching::where('user_id',$request->id)->delete();

        return response()->json(['status' => true, 'message' => 'All Records of this company are deleted']);

    }
}
