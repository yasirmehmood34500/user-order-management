<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BuyOrder;
use App\Models\Company;
use App\Models\Location;
use App\Models\matching;
use App\Models\Pair;
use App\Models\Sector;
use App\Models\SellOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BuyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('admin.buy_orders.index',$data);

    }
    public function buyOrders(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('Admin')) {
                if ($request->filter_orders_of == 'company') {
                    $data = BuyOrder::query()->with(['Contact', 'Company'])->where('company_id',$request->id)->get();
                }else if ($request->filter_orders_of == 'contacts'){
                    $data = BuyOrder::query()->with(['Contact', 'Company'])->where('user_id',$request->id)->get();
                }else{
                    $data = BuyOrder::query()->with(['Contact', 'Company'])->get();
                }
            }else{
                $data = BuyOrder::query()->where('user_id',Auth::id())->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('buy_id', function($row) {
                    if (auth()->user()->hasRole('Admin')){
                        $pair_icon = '<i class="fa-solid fa-code-merge text-danger fa--customer-icon"  data-toggle="modal"
                        data-target="#pairBuyModal" onclick="pairOrder(' . $row->buy_id . ')"></i>';
                    }else{
                        $pair_icon='';
                    }
                    $data = $pair_icon. $row->buy_id;
                    return $data;
                })
                ->addColumn('contact', function($row){
                    $data = $row->Contact ? $row->Contact->name:'N/A';
                    return $data;
                })
                ->addColumn('company', function($row){
                    $data = $row->Company ? $row->Company->comp_name:'N/A';
                    return $data;
                })
                ->addColumn('action', function($row){
                    $btn = '<i class="fa fa-edit fa--customer-icon"  data-toggle="modal"  style="background-color: #dde1e5;"
                        data-target="#editBuyModal" onclick="getBuyID('.$row->buy_id.')"></i>';
                    return $btn;
                })
                ->rawColumns(['action','buy_id'])
                ->make(true);
        }
    }

    public function forPairBuyOrders(Request $request){

        if ($request->ajax()) {
            if (auth()->user()->hasRole('Admin')) {
                if ($request->filter_orders_of == 'company') {
                    $data = BuyOrder::query()->with(['Contact', 'Company'])->where('company_id',$request->id)->get();
                }else if ($request->filter_orders_of == 'contacts'){
                    $data = BuyOrder::query()->with(['Contact', 'Company'])->where('user_id',$request->id)->get();
                }else{
                    $data = BuyOrder::query()->with(['Contact', 'Company'])->get();
                }
            }else{
                $data = BuyOrder::query()->where('user_id',Auth::id())->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('contact', function($row){
                    $data = $row->Contact ? $row->Contact->name:'N/A';
                    return $data;
                })->addColumn('company', function($row){
                    $data = $row->Company ? $row->Company->comp_name:'N/A';
                    return $data;
                })->addColumn('sell_checkbox', function($row){
                    $btn = '<input type="checkbox" class="sell_checkbox" onclick="selectBO('.$row->buy_id.')"/>';
                    return $btn;
                })
                ->rawColumns(['sell_checkbox'])
                ->make(true);
        }
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

    public function pair(Request $request){
//        dd($request);
        $pair = Pair::create([
            'comment'=>$request->comment
        ]);
        foreach ($request->sell_orders as $sell_id){
            matching::create([
                'sell_id'=>$sell_id,
                'company_id'=>$request->company_id,
                'buy_id'=>$request->buy_order,
                'pair_id'=>$pair->id
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Buy Order Paired']);
    }

    public function store(Request $request)
    {
//        dd($request);
      $buy_order = BuyOrder::create([
         'user_id'=>$request->contact,
         'company_id'=>$request->company,
         'estsize'=>$request->est_size,
         'pps'=>$request->price,
         'shareclass'=>$request->share_class,
         'valuation'=>$request->est_size * $request->price,
         'structure'=>$request->structure,
         'fee_structure'=>$request->fee_structure,
         'comments'=>$request->bo_comment,
         'category_id'=>$request->category_id,
      ]);

        if ($buy_order) {
            return response()->json(['status' => true, 'message' => 'Buy Order saved']);
        }else{
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buy_order = BuyOrder::where('buy_id',$id)->first();
        return response()->json(['status' => true, 'data' => $buy_order]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request);
        $buy_order = BuyOrder::where('buy_id',$id)->update([
            'user_id'=>$request->contact,
            'company_id'=>$request->company,
            'estsize'=>$request->est_size,
            'pps'=>$request->price,
            'shareclass'=>$request->share_class,
            'valuation'=>$request->est_size * $request->price,
            'structure'=>$request->structure,
            'fee_structure'=>$request->fee_structure,
            'comments'=>$request->bo_comment,
            'category_id'=>$request->category_id,
        ]);

        if ($buy_order) {
            return response()->json(['status' => true, 'message' => 'Buy Order updated']);
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
}
