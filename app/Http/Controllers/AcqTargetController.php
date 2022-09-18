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
        //
    }
}
