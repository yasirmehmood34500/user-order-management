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
        return view('admin.paired_orders.index');

    }

    public function pairOrders(Request $request)
    {
        if ($request->ajax()) {
            if (is_null(request('company_id'))) {
                $pairs = matching::with(['SellOrder.Contact', 'BuyOrder.Contact', 'Company'])->get();
            }else {
                $pairs = matching::with(['SellOrder.Contact', 'BuyOrder.Contact', 'Company'])->where('company_id',request('company_id'))->get();
            }
            return Datatables::of($pairs)
                ->addIndexColumn()
                ->addColumn('dt_id',function ($row){
                    return '<input type="checkbox" class="mr-4 ml-2 sub_check_boxes" id="sub_check_box'.$row->match_id.'" onclick="checkOneBox('.$row->match_id.')"/><i class="fa fa-trash text-danger fa--customer-icon" onclick="deletePair('.$row->match_id.')"> </i>'.($row->Company ? $row->Company->comp_name : 'N/A') . ' - B-'.$row->sell_id.' - S-'.$row->buy_id;
                })
                ->addColumn('dt_contacts', function($row){
                    $dt_contacts = ($row->BuyOrder ? ($row->BuyOrder->Contact ? $row->BuyOrder->Contact->name:'N/A') : 'N/A') .
                        '<br />'.($row->SellOrder ? ($row->SellOrder->Contact ? $row->SellOrder->Contact->name:'N/A') : 'N/A') ;
                    return $dt_contacts;
                })
                ->addColumn('dt_est_size', function($row){
                    $dt_est_size = $row->BuyOrder ? $row->BuyOrder->estsize : 'N/A';
                    $dt_est_size = $dt_est_size."<br />";
                    $dt_est_size = $dt_est_size.($row->SellOrder ? $row->SellOrder->estsize : 'N/A');
                    return $dt_est_size;
                })
                ->addColumn('dt_pps', function($row){
                    $data = $row->BuyOrder ? $row->BuyOrder->pps : 'N/A';
                    $data = $data."<br />";
                    $data = $data.($row->SellOrder ? $row->SellOrder->pps : 'N/A');
                    return $data;
                })
                ->addColumn('dt_valuation', function($row){
                    $data = $row->BuyOrder ? $row->BuyOrder->valuation : 'N/A';
                    $data = $data."<br />";
                    $data = $data.($row->SellOrder ? $row->SellOrder->valuation : 'N/A');
                    return $data;
                })
                ->addColumn('dt_share_class', function($row){
                    $data = $row->BuyOrder ? $row->BuyOrder->shareclass : 'N/A';
                    $data = $data."<br />";
                    $data = $data.($row->SellOrder ? $row->SellOrder->shareclass : 'N/A');
                    return $data;
                })
                ->addColumn('dt_structure', function($row){
                    $data = $row->BuyOrder ? $row->BuyOrder->structure : 'N/A';
                    $data = $data."<br />";
                    $data = $data.($row->SellOrder ? $row->SellOrder->structure : 'N/A');
                    return $data;
                })
                ->addColumn('dt_fee_structure', function($row){
                    $data = $row->BuyOrder ? $row->BuyOrder->fee_structure : 'N/A';
                    $data = $data."<br />";
                    $data = $data.($row->SellOrder ? $row->SellOrder->fee_structure : 'N/A');
                    return $data;
                })
                ->addColumn('dt_comments', function($row){
                    $data = $row->BuyOrder ? $row->BuyOrder->comments : 'N/A';
                    $data = $data."<br />";
                    $data = $data.($row->SellOrder ? $row->SellOrder->comments : 'N/A');
                    return $data;
                })
                ->rawColumns(['dt_id','dt_contacts','dt_est_size','dt_pps','dt_valuation','dt_share_class','dt_structure','dt_fee_structure','dt_comments'])
                ->make(true);
        }
    }
    public function deleteMatching(){
        $id = \request('match_id');
        matching::where('match_id',$id)->delete();
        return response()->json(['status'=>true,"message"=>"Deleted"]);
    }

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
