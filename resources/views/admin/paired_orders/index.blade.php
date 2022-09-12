@extends('layouts.app')

@section('title','Paired Orders')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>{{ __('Paired Orders') }}</p>
                    <form action="{{url('paired-order')}}" class="d-flex">
                        <input type="search" name="search" placeholder="search" class="form-control input-group-sm" value="{{request('search')}}">
                        <button class="btn btn-primary ml-1 btn-sm">Search</button>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Contacts (SO - PO)</th>
                            <th>EST Size (SO - PO)</th>
                            <th>PPS  (SO - PO)</th>
                            <th>Valuation  (SO - PO)</th>
                            <th>Pair Comment</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($pairs as $index=>$pair)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        @foreach($pair->Matchings as $matching)
                                            <p>{{$matching->SaleOrder->Contact ? $matching->SaleOrder->Contact->name : 'N/A'}} - {{$matching->SaleOrder->Contact ? $matching->BuyOrder->Contact->name : 'N/A'}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($pair->Matchings as $matching)
                                            <p>{{$matching->SaleOrder->est_size ? $matching->SaleOrder->est_size : 'N/A'}} - {{$matching->SaleOrder->est_size ? $matching->BuyOrder->est_size : 'N/A'}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($pair->Matchings as $matching)
                                            <p>{{$matching->SaleOrder->pps ? $matching->SaleOrder->pps : 'N/A'}} - {{$matching->SaleOrder->pps ? $matching->BuyOrder->pps : 'N/A'}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($pair->Matchings as $matching)
                                            <p>{{$matching->SaleOrder->valuation ? $matching->SaleOrder->valuation : 'N/A'}} - {{$matching->SaleOrder->valuation ? $matching->BuyOrder->valuation : 'N/A'}}</p>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$pair->comment}}
                                    </td>
                                    <td>
                                        <a href="{{url('paired_order_delete').'/'.$pair->id}}" class="btn btn-danger btn-sm"> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between" style="float: right">
                        {{$pairs->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
