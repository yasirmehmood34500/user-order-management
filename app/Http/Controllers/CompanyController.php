<?php

namespace App\Http\Controllers;

use App\Models\AcqTarget;
use App\Models\Business;
use App\Models\BuyOrder;
use App\Models\Company;
use App\Models\CompanyHasSectors;
use App\Models\Holding;
use App\Models\Location;
use App\Models\matching;
use App\Models\Pair;
use App\Models\Sector;
use App\Models\SellOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CompanyController extends Controller
{

    public function index()
    {
        $companies=[];
//        dd(\session()->get('filters'));
//            dd(\session()->get('filters'));
        if (\session()->has('filters')){
//            dd('lb');

            if (!is_null(\session()->get('filters')['location_filter']) && count(\session()->get('filters')['sectors_filter']) > 0 && !is_null(\session()->get('filters')['business_filter'])){
                $companies =Company::with(['Sectors.Sector','Business'])->where('geog_id',\session()->get('filters')['location_filter'])->whereHas('Sectors',function ($q){
                    $q->whereIn('sector_id',\session()->get('filters')['sectors_filter']);
                })->where('business_id',\session()->get('filters')['business_filter'])->orderBy('comp_name', 'ASC')->get();
            }
            elseif (!is_null(\session()->get('filters')['location_filter']) && count(\session()->get('filters')['sectors_filter']) >0){
                $companies =Company::with(['Sectors.Sector','Business'])->where('geog_id',\session()->get('filters')['location_filter'])->whereHas('Sectors',function ($q){
                    $q->whereIn('sector_id',\session()->get('filters')['sectors_filter']);
                })->orderBy('comp_name', 'ASC')->get();
            }
            elseif (!is_null(\session()->get('filters')['location_filter']) && !is_null(\session()->get('filters')['business_filter'])){
                $companies =Company::with(['Sectors.Sector','Business'])->where('geog_id',\session()->get('filters')['location_filter'])
                    ->where('business_id',\session()->get('filters')['business_filter'])->orderBy('comp_name', 'ASC')->get();
            }
            elseif (!is_null(\session()->get('filters')['location_filter'])){
                $companies =Company::with(['Sectors.Sector','Business'])->where('geog_id',\session()->get('filters')['location_filter'])->orderBy('comp_name', 'ASC')->get();
            }elseif (count(\session()->get('filters')['sectors_filter']) > 0){
                $companies =Company::with(['Sectors.Sector','Business'])->whereHas('Sectors',function ($q){
                    $q->whereIn('sector_id',\session()->get('filters')['sectors_filter']);
                })->orderBy('comp_name', 'ASC')->get();

            }elseif (!is_null(\session()->get('filters')['business_filter'])){

                $companies = Company::with(['Sectors.Sector','Business'])->where('business_id',\session()->get('filters')['business_filter'])->orderBy('comp_name', 'ASC')->get();
            }
        }else{
            $companies = Company::with(['Sectors.Sector','Business'])->orderBy('comp_name', 'ASC')->get();
        }

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
            $activeCompany = Company::with(['Sectors.Sector'])->where('company_id',\request('search'))->first();
        } else {
            $activeCompany = count($companies) > 0 ?  $companies[0] : null;
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
            return view('admin.companies.index', $data);
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
            'business_id'=>$request->business_orient,
            'deal_type'=>$request->deal_type,
            'background'=>$request->company_background
        ]);
        foreach ($request->sectors as $sector){
            CompanyHasSectors::create([
                'company_id' =>$company->id,
                'sector_id' =>$sector,
            ]);
        }

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
        CompanyHasSectors::where('company_id',$id)->delete();
        foreach ($request->sectors as $sector){
            CompanyHasSectors::create([
                'company_id' =>$id,
                'sector_id' =>$sector,
            ]);
        }
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
            if ($id!=1) {
                User::where('id', $id)->delete();
                return response()->json(['status' => true, 'message' => 'Contact Deleted']);
            }else{
                return response()->json(['status' => true, 'message' => 'Admin Account not allow to Delete']);
            }
        }elseif($type=='holding'){
            Holding::where('holding_id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'Holding Deleted']);
        }elseif($type=='target'){
            AcqTarget::where('target_id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'Target Deleted']);
        }elseif($type=='pair'){
            matching::where('match_id',$id)->delete();
            return response()->json(['status' => true, 'message' => 'paired order Deleted']);
        }

    }

    public function DeleteCompanyRecord(Request $request){
        SellOrder::where('company_id',$request->id)->delete();
        BuyOrder::where('company_id',$request->id)->delete();
        Holding::where('company_id',$request->id)->delete();
        matching::where('company_id',$request->id)->delete();

        return response()->json(['status' => true, 'message' => 'All Records of this company are deleted']);

    }

    public function filterCompany(Request $request){
//        dd($request->all());
        if ($request->location_filter || $request->sectors_filter || $request->business_filter) {
            $filters = [
                'location_filter' => $request->location_filter,
                'sectors_filter' => $request->sectors_filter ? array_values($request->sectors_filter): [],
                'business_filter' => $request->business_filter
            ];
            Session::put('filters', $filters);

            return redirect('companies')->with(['filter_success' => 'Filter Applied']);
        } else {
            Session::forget('filters');
            return redirect('companies')->with(['filter_failed' => 'All filters Removed']);
        }
    }
}
