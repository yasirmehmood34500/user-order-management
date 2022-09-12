<?php

namespace App\Http\Controllers;

use App\Models\matching;
use App\Models\Pair;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PairedOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\request('search')){
            $pairs = Pair::with(['matchings.SaleOrder.Contact', 'matchings.BuyOrder.Contact'])
                ->whereHas('matchings',function ($q){
                    $q->whereHas('SaleOrder',function ($sq){
                        $sq->whereHas('Contact',function ($sq_contact){
                            $sq_contact->where('name',\request('search'));
                        });
                    })->orwhereHas('BuyOrder',function ($sq){
                        $sq->whereHas('Contact',function ($sq_contact){
                            $sq_contact->where('name',\request('search'));
                        });
                    });
                })->paginate(50);
        }else {
            $pairs = Pair::with(['matchings.SaleOrder.Contact', 'matchings.BuyOrder.Contact'])->paginate(50);
        }
        return view('admin.paired_orders.index',compact('pairs'));

    }

//    public function pairOrders(Request $request)
//    {
//        if ($request->ajax()) {
//           $pairs = Pair::with(['matching.SaleOrder.Contact','matching.BuyOrder.Contact'])->get();
//            return Datatables::of($pairs)
//                ->addIndexColumn()
//                ->addColumn('so_contact', function($row){
////                    $data=
//                    foreach ($row->matching->SaleOrder as $so){
//
//                    }
//                    $data = $row->matching->SaleOrder ? ($row->matching->SaleOrder->Contact ? $row->matching->SaleOrder->Contact->name:'N/A') : 'N/A';
//                    return $data;
//                })
//                ->addColumn('bo_contact', function($row){
//                    $data = $row->matching->BuyOrder ? ($row->matching->BuyOrder->Contact ? $row->matching->BuyOrder->Contact->name:'N/A') : 'N/A';
//                    return $data;
//                })
//                ->addColumn('so_est_size', function($row){
//                    $data = $row->matching->SaleOrder ? $row->matching->SaleOrder->estsize : 'N/A';
//                    return $data;
//                })
//                ->addColumn('bo_est_size', function($row){
//                    $data = $row->matching->BuyOrder ? $row->matching->BuyOrder->estsize : 'N/A';
//                    return $data;
//                })
//                ->addColumn('so_pps', function($row){
//                    $data = $row->matching->SaleOrder ? $row->matching->SaleOrder->pps : 'N/A';
//                    return $data;
//                })
//                ->addColumn('bo_pps', function($row){
//                    $data = $row->matching->BuyOrder ? $row->matching->BuyOrder->pps : 'N/A';
//                    return $data;
//                })
//                ->addColumn('company', function($row){
//                    $data = $row->Company ? $row->Company->comp_name:'N/A';
//                    return $data;
//                })
//                ->make(true);
//        }
//    }

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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pair::where('id',$id)->delete();
        matching::where('pair_id',$id)->delete();
        return back();
    }
}
