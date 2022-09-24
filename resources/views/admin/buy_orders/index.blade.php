@extends('layouts.app')

@section('title','Buy Orders')

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Buy Orders</p>
                    <div >
                        <a href="#"  id="buy_order" class="btn btn-secondary"  onclick="exportTableToCSV('buy_orders {{now()->format('Y-d-m')}}')">
                            Export
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered buy-orders">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>User Profile</th>
                            <th>Est Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                            <th>Share Class</th>
                            <th>Structure</th>
                            <th>Fee Structure</th>
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

    <!--Pair Order Modal -->
    <div class="modal fade" id="pairBuyModal" tabindex="-1" role="dialog"
         aria-labelledby="pairBuyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pairBuyModalLabel">Sell Orders</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered make-so-pair">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Contact</th>
                            <th>Est Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="form-group">
                        <label for="pair_bo_comment">Comments</label>
                        <textarea name="pair_bo_comment" class="form-control" id="pair_bo_comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="pairBuyOrder">Pair Now</button>
                </div>
            </div>
        </div>
    </div>
    <!--Buy Order edit Modal -->
    <div class="modal fade" id="editBuyModal" tabindex="-1" role="dialog"
         aria-labelledby="editBuyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBuyModalLabel">Edit Buy Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="contact">Contacts</label>
                            <select name="contact" id="edit_contact" class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category">Category</label>
                            <select name="category" id="edit_category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->categoryname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="edit_price">
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="est_size">Est Size (.000)</label>
                            <input type="number" class="form-control" id="edit_est_size">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="share_class">Share Class</label>
                            <select name="share_class" id="edit_share_class" class="form-control">
                                @foreach($share_classes as $share_class)
                                    <option value="{{$share_class->classname}}">{{$share_class->classname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="structure">Structures</label>
                            <select name="structure" id="edit_structure" class="form-control">
                                @foreach($structures as $structure)
                                    <option value="{{$structure->structurename}}">{{$structure->structurename}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 form-group">
                                <label for="fee_structure">Fee structure</label>
                                <input type="number" class="form-control" id="edit_fee_structure">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="bo_comment">Comments</label>
                                <textarea name="bo_comment" class="form-control" id="edit_bo_comment"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBuyButton">Save Button</button>
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
                    {data: 'contact', name: 'contact'},
                    {data: 'estsize', name: 'estsize'},
                    {data: 'pps', name: 'pps'},
                    {data: 'valuation', name: 'valuation'},
                    {data: 'shareclass', name: 'shareclass'},
                    {data: 'structure', name: 'structure'},
                    {data: 'fee_structure', name: 'fee_structure'},
                        @if(auth()->user()->hasRole('Admin'))
                    {data: 'comments', name: 'comments'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    @endif
                ]
            });

        });
        </script>
    <script>
        let so_arr=[];
        function selectSO(id){
            if(!so_arr.includes(id)){          //checking weather array contain the id
                so_arr.push(id);               //adding to array because value doesnt exists
            }else{
                so_arr.splice(so_arr.indexOf(id), 1);  //deleting
            }
            // arr.push(id);
            console.log(so_arr);
        }
        function pairOrder(id) {
            BuyOrderID=id;
            console.log(id);
            $('.make-so-pair tbody').html(' ');

            $('.make-so-pair').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    url:"{{ route('forPairSellOrders') }}",
                    data: function (d) {
                        d.id = "";
                        d.filter_orders_of = "";
                    }
                },
                columns: [
                    {data: 'sell_checkbox', name: 'sell_checkbox'},
                    {data: 'contact', name: 'contact'},
                    {data: 'estsize', name: 'estsize'},
                    {data: 'pps', name: 'pps'},
                    {data: 'valuation', name: 'valuation'},
                ]
            });
        }
        $("#pairBuyOrder").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('pair-buy-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "sell_orders":so_arr,
                    "buy_order":BuyOrderID,
                    "company_id":"0",
                    "comment":$('#pair_bo_comment').val()
                },
                success: function (result) {
                    if (result.status) {
                        alert(result.message);
                        window.location.reload();
                    }
                }
            });
        });
        function getBuyID(id) {
            BuyOrderID = id;
            $.ajax({
                type: "GET",
                url: "{{url('edit-buy-order')}}" + "/" + id,
                success: function (res) {
                    let result = res.data;
                    $('#edit_price').val(result.pps);
                    $('#edit_fee_structure').val(result.fee_structure);
                    $('#edit_est_size').val(result.estsize);
                    $('#edit_bo_comment').val(result.comments);
                    $("#edit_contact option[value=" + result.user_id + "]").prop("selected", true);
                    $("#edit_category option[value="+result.category_id+"]").prop("selected", true);
                    $("#edit_share_class option[value="+result.shareclass+"]").prop("selected", true);
                    $("#edit_structure option[value='"+result.structure+"']").prop("selected", true);
                }
            });
        }
    </script>
    <script>
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll(".buy-orders tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length-1 ; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }

        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }
    </script>
    <script>
        $("#updateBuyButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('update-buy-order')}}"+"/"+BuyOrderID,
                data: {
                    "_token": "{{csrf_token()}}",
                    "contact": $('#edit_contact').val(),
                    "company": "{{$active_company->company_id}}",
                    "category": $('#edit_category').val(),
                    "price": $('#edit_price').val(),
                    "fee_structure": $('#edit_fee_structure').val(),
                    "est_size": $('#edit_est_size').val(),
                    "share_class": $('#edit_share_class').val(),
                    "structure": $('#edit_structure').val(),
                    "bo_comment": $('#edit_bo_comment').val(),
                },
                success: function (result) {
                    if (result.status) {
                        alert(result.message);
                        window.location.reload();
                    }
                }
            });
        });
    </script>
    @endpush
