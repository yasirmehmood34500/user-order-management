@extends('layouts.app')

@section('title','Paired Orders')

@section('content')
    <style>
        td { white-space:pre !important; }
    </style>
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>{{ __('Paired Orders') }}</p>
                </div>

                <div class="card-body">
                    <table class="table table-bordered" id="paired_orders_table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Contact</th>
                            <th>EST Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                            <th>Share Class</th>
                            <th>Structure</th>
                            @if(auth()->user()->hasRole('Admin'))
                            <th>Fee Structure</th>
                            <th>Comment</th>
                                @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var table=null;
        $(function () {
            table =  $('#paired_orders_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('getPairOrders') }}",
                },
                columns: [
                    {data: 'dt_id', name: 'dt_id'},
                    {data: 'dt_contacts', name: 'dt_contacts'},
                    {data: 'dt_est_size', name: 'dt_est_size'},
                    {data: 'dt_pps', name: 'dt_pps'},
                    {data: 'dt_valuation', name: 'dt_valuation'},
                    {data: 'dt_share_class', name: 'dt_share_class'},
                    {data: 'dt_structure', name: 'dt_structure'},
                    @if(auth()->user()->hasRole('Admin'))
                    {data: 'dt_fee_structure', name: 'dt_fee_structure'},
                    {data: 'dt_comments', name: 'dt_comments'}
                    @endif
                ]
            });

        });

        function deletePair(id) {
            $.ajax({
                type: "POST",
                url: "{{url('delete-matching')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    'match_id':id
                },
                success: function (result) {
                    table.draw();
                }
            });
        }
    </script>
@endpush
