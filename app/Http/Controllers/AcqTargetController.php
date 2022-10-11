<?php

namespace App\Http\Controllers;

use App\Models\AcqTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AcqTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.acquistion_target.index');

    }
    public function getTargets(){
        $data = AcqTarget::with(['Contact', 'Company'])->where('user_id',\request('id'))->get();
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
                $deleteType = 4;
                $id=$row->target_id;
                $btn = '<i class="fa fa-edit fa--customer-icon"  data-toggle="modal"  style="background-color: #dde1e5;"
                    data-target="#editTargetModal" onclick="getTargetID('.$row->target_id.')"></i>'.'<i class="fa fa-trash text-danger fa--customer-icon" onclick="deleteFromGrid('.$id.','.$deleteType.')"> </i>';
                return $btn;
            })
            ->make(true);
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
        $target = AcqTarget::create([
            'user_id'=>$request->contact_acq,
            'company_id'=>$request->company_acq,
            'estsize'=>$request->est_size_acq,
            'pps'=>$request->pps_acq,

        ]);
        if ($target) {
            return response()->json(['status' => true, 'message' => 'Target saved']);
        } else {
            return response()->json(['status' => false, 'message' => 'Some thing went wrong']);
        }
    }


    public function edit($id)
    {
        $target = AcqTarget::where('target_id',$id)->first();
        return response()->json(['status' => true, 'data' => $target]);

    }

    public function update(Request $request, $id)
    {
        $target = AcqTarget::where('target_id',$id)->update([
            'user_id'=>$request->contact_acq,
            'company_id'=>$request->company_acq,
            'estsize'=>$request->est_size_acq,
            'pps'=>$request->pps_acq,

        ]);
        if ($target) {
            return response()->json(['status' => true, 'message' => 'Target update']);
        } else {
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
