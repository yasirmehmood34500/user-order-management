@extends('layouts.app')

@section('title','Buy Orders')

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Buy Orders</p>
                    <button type="button" id="buy_order" class="text-muted btn btn-muted" data-toggle="modal"
                            data-target="#addBuyModal">
                        Buy New Order
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered buy-orders">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Contact</th>
                            <th>Est Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                            <th>Share Class</th>
                            <th>Structure</th>
                            @if(auth()->user()->hasRole('Admin'))
                                <th>comment</th>
                                <th width="100px">Action</th>
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
    <script type="text/javascript">

        $(function () {
            var table = $('.buy-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('buyOrders') }}",
                    {{--data: function (d) {--}}
                    {{--    d.id = "{{$active_user->id}}";--}}
                    {{--    d.filter_orders_of = "contacts";--}}
                    {{--}--}}
                },
                columns: [
                    {data: 'buy_id', name: 'buy_id'},
                    {data: 'company', name: 'company'},
                    {data: 'estsize', name: 'estsize'},
                    {data: 'pps', name: 'pps'},
                    {data: 'valuation', name: 'valuation'},
                    {data: 'shareclass', name: 'shareclass'},
                    {data: 'structure', name: 'structure'},
                        @if(auth()->user()->hasRole('Admin'))
                    {data: 'comments', name: 'comments'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    @endif
                ]
            });

        });
        </script>
    @endpush
