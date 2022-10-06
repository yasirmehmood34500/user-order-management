<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BuyOrder;
use App\Models\Company;
use App\Models\Holding;
use App\Models\Location;
use App\Models\matching;
use App\Models\Pair;
use App\Models\Sector;
use App\Models\SellOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::orderBy('comp_name','ASC')->get();
        $sectors = Sector::all();
        $business = Business::all();
        $locations = Location::all();
        $share_classes = DB::table('shareclass')->get();
        $categories = DB::table('usercategory')->get();
        $structures = DB::table('structure')->get();
        $users = User::whereHas('roles',function ($q){
            $q->where('name','User');
        })->get();
        if (\request('search')){
            $activeCompany = Company::where('company_id',\request('search'))->first();
        } else {
            $activeCompany = $companies[0];
        }


        $data = [
            'all_companies'=>$companies,
            'sectors'=>$sectors,
            'business'=>$business,
            'locations'=>$locations,
            'active_company'=>$activeCompany,
            'share_classes'=>$share_classes,
            'categories'=>$categories,
            'structures'=>$structures,
            'contacts'=>$users
        ];

        return view('admin.companies.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $company = Company::create([
            'comp_name'=>$request->company_name,
            'geog_id'=>$request->location,
            'invest_stage'=>$request->invest_stage,
            'comment'=>$request->comment,
            'sector_id'=>$request->sectors,
            'business_id'=>$request->business_orient,
            'deal_type'=>$request->deal_type,
            'background'=>$request->company_background
        ]);

        if ($company) {
            return response()->json(['status' => true, 'message' => 'company saved']);
        }else{
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }

    }


    public function edit($id)
    {
        $company = Company::where('company_id',$id)->first();
        return response()->json(['status' => true, 'data' => $company]);


    }


    public function update(Request $request, $id)
    {
        $company = Company::where('company_id',$id)->update([
            'comp_name'=>$request->company_name,
            'geog_id'=>$request->location,
            'invest_stage'=>$request->invest_stage,
            'comment'=>$request->comment,
            'sector_id'=>$request->sectors,
            'business_id'=>$request->business_orient,
            'deal_type'=>$request->deal_type,
            'background'=>$request->company_background
        ]);

        if ($company) {
            return response()->json(['status' => true, 'message' => 'company updated']);
        }else{
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function DeleteFromGrid(Request $request){
        $id=$request->id;
        $type=$request->type;

        if ($type=='sell_order'){
            SellOrder::where('sell_id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'Sell Order Deleted']);
        }elseif($type == 'buy_order'){
            BuyOrder::where('buy_id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'Buy Order Deleted']);
        }elseif($type=='company'){
            Company::where('company_id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'Company Deleted']);

        }elseif($type=='contact'){
            User::where('id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'contact Deleted']);

        }elseif($type=='holding'){
            User::where('id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'holding Deleted']);
        }elseif($type=='target'){
            User::where('id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'target Deleted']);
        }

    }

    public function DeleteCompanyRecord(Request $request){
        SellOrder::where('company_id',$request->id)->delete();
        BuyOrder::where('company_id',$request->id)->delete();
        Holding::where('company_id',$request->id)->delete();
        matching::where('company_id',$request->id)->delete();

        return response()->json(['status' => true, 'message' => 'All Records of this company are deleted']);

    }
}
