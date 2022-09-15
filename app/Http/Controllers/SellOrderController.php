<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BuyOrder;
use App\Models\Company;
use App\Models\Location;
use App\Models\Sector;
use App\Models\SellOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SellOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['Location','Sector'])->get();
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
            $activeUser = $users[0];
        }
        $data = [
            'contacts'=>$users,
            'sectors'=>$sectors,
            'business'=>$business,
            'locations'=>$locations,
            'active_user'=>$activeUser,
            'companies'=>$companies,
            'share_classes'=>$share_classes,
            'categories'=>$categories,
            'structures'=>$structures,
        ];
        return view('admin.sell_orders.index',$data);

    }
    public function saleOrders(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('Admin')) {
                if ($request->filter_orders_of == 'company') {
                    $data = SellOrder::query()->with(['Contact', 'Company'])->where('company_id',$request->id)->get();
                }else if ($request->filter_orders_of == 'contacts'){
                    $data = SellOrder::query()->with(['Contact', 'Company'])->where('user_id',$request->id)->get();
                }else{
                    $data = SellOrder::query()->with(['Contact', 'Company'])->get();
                }
            }else{
                $data = SellOrder::query()->where('user_id',Auth::id())->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('contact', function($row){
                    $data = $row->Contact ? $row->Contact->name:'N/A';
                    return $data;
                })->addColumn('company', function($row){
                    $data = $row->Company ? $row->Company->comp_name:'N/A';
                    return $data;
                })->addColumn('action', function($row){
                    $btn = '<i class="fa fa-edit font-weight-bold cursor-pointer p-1" data-toggle="modal"
                        data-target="#editSOModal" onclick="getSO_ID('.$row->sell_id.')"></i>';
//                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-toggle="modal"
//                        data-target="#editSOModal" onclick="getSO_ID('.$row->sell_id.')">Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function forPairSellOrders(Request $request){

        if ($request->ajax()) {
            if (auth()->user()->hasRole('Admin')) {
                if ($request->filter_orders_of == 'company') {
                    $data = SellOrder::query()->with(['Contact', 'Company'])->where('company_id',$request->id)->get();
                }else if ($request->filter_orders_of == 'contacts'){
                    $data = SellOrder::query()->with(['Contact', 'Company'])->where('user_id',$request->id)->get();
                }else{
                    $data = SellOrder::query()->with(['Contact', 'Company'])->get();
                }
            }else{
                $data = SellOrder::query()->where('user_id',Auth::id())->get();
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
                    $btn = '<input type="checkbox" class="sell_checkbox" onclick="selectSO('.$row->sell_id.')"/>';
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $buy_order = SellOrder::create([
            'user_id'=>$request->contact,
            'company_id'=>$request->company,
            'estsize'=>$request->est_size,
            'pps'=>$request->price,
            'shareclass'=>$request->share_class,
            'valuation'=>$request->valuation,
            'structure'=>$request->structure,
            'comments'=>$request->bo_comment,
            'category_id'=>$request->category_id,
        ]);

        if ($buy_order) {
            return response()->json(['status' => true, 'message' => 'Sell Order saved']);
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
        $sell_order = SellOrder::where('sell_id',$id)->first();
        return response()->json(['status' => true, 'data' => $sell_order]);

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
        $buy_order = SellOrder::where('sell_id',$id)->update([
            'user_id'=>$request->contact,
            'company_id'=>$request->company,
            'estsize'=>$request->est_size,
            'pps'=>$request->price,
            'shareclass'=>$request->share_class,
            'valuation'=>$request->valuation,
            'structure'=>$request->structure,
            'comments'=>$request->bo_comment,
            'category_id'=>$request->category_id,
        ]);

        if ($buy_order) {
            return response()->json(['status' => true, 'message' => 'Sell Order Updated']);
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
