<?php

namespace App\Http\Controllers;

use App\Models\Holding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CurrentHoldingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.current_holdings.index');

    }

    public function getHoldings(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('Admin')) {
                if ($request->filter_orders_of == 'company') {
                    $data = Holding::with(['Contact', 'Company'])->where('company_id', $request->id)->get();

                } else if ($request->filter_orders_of == 'contacts') {
                    $data = Holding::query()->with(['Contact', 'Company'])->where('user_id', $request->id)->get();
                } else {
                    $data = Holding::query()->with(['Contact', 'Company'])->get();
                }
            } else {
                $data = Holding::with(['Contact', 'Company'])->where('user_id', Auth::id())->get();

            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('contact', function ($row) {
                    $data = $row->Contact ? $row->Contact->name : 'N/A';
                    return $data;
                })
                ->addColumn('company', function ($row) {
                    $data = $row->Company ? $row->Company->comp_name : 'N/A';
                    return $data;
                })
                ->addColumn('action', function($row){
                    $deleteType = 3;
                    $id=$row->holding_id;
                    $btn = '<i class="fa fa-edit fa--customer-icon"  data-toggle="modal"  style="background-color: #dde1e5;"
                    data-target="#editHoldModal" onclick="getHoldID('.$row->holding_id.')"></i>'.'<i class="fa fa-trash text-danger fa--customer-icon" onclick="deleteFromGrid('.$id.','.$deleteType.')"> </i>';
                    return $btn;
                })
                ->rawColumns(['action', 'buy_id'])
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


    public function store(Request $request)
    {
//        dd($request);
        $holding = Holding::create([
            'company_id' => $request->company_id,
            'user_id' => $request->hold_contact,
            'holding' => $request->holding,
            'pps' => $request->hold_pps,
            'target' => $request->hold_target,
            'shareclass' => $request->hold_share_class,
            'comments' => $request->hold_comment,
        ]);
        if ($holding) {
            return response()->json(['status' => true, 'message' => 'Holding saved']);
        } else {
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }

    public function update(Request $request, $id)
    {
        $holding = Holding::where('holding_id',$id)->update([
            'company_id' => $request->company_id,
            'user_id' => $request->hold_contact,
            'holding' => $request->holding,
            'pps' => $request->hold_pps,
            'target' => $request->hold_target,
            'shareclass' => $request->hold_share_class,
            'comments' => $request->hold_comment,
        ]);
        if ($holding) {
            return response()->json(['status' => true, 'message' => 'Holding updated']);
        } else {
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }

    public function editHolding($id){
        $holding = Holding::where('holding_id',$id)->first();
        return response()->json(['status' => true, 'data' => $holding]);

    }
}
