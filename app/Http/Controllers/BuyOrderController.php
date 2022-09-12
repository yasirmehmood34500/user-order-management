<?php

namespace App\Http\Controllers;

use App\Models\BuyOrder;
use App\Models\matching;
use App\Models\Pair;
use App\Models\SellOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('admin.buy_orders.index');

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
                ->addColumn('contact', function($row){
                    $data = $row->Contact ? $row->Contact->name:'N/A';
                    return $data;
                })
                ->addColumn('company', function($row){
                    $data = $row->Company ? $row->Company->comp_name:'N/A';
                    return $data;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#editBuyModal" onclick="getBuyID('.$row->buy_id.')">Edit</a>'
                    .'<a href="javascript:void(0)" class="edit btn btn-secondary btn-sm" data-toggle="modal"
                        data-target="#pairBuyModal" onclick="pairOrder('.$row->buy_id.')">Pair</a>'
                    ;
                    return $btn;
                })
                ->rawColumns(['action'])
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
         'valuation'=>$request->valuation,
         'structure'=>$request->structure,
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
            'valuation'=>$request->valuation,
            'structure'=>$request->structure,
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
