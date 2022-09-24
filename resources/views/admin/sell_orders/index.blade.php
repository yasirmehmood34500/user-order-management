@extends('layouts.app')

@section('title','Sell Orders')

@section('content')
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Sale Orders</p>
                    <div >
                        <a href="#"  id="buy_order" class="btn btn-secondary"  onclick="exportTableToCSV('sell_orders {{now()->format('Y-d-m')}}')">
                            Export
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered sell-orders">
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
    <!--Buy Order Modal -->
    <div class="modal fade" id="addBuyModal" tabindex="-1" role="dialog"
         aria-labelledby="addBuyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBuyLabel">Add Buy Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="contact">Contacts</label>
                            <select name="contact" id="contact" class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->categoryname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="valuation">Valuation (mn)</label>
                            <input type="number" class="form-control" id="valuation">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="est_size">Est Size (.000)</label>
                            <input type="number" class="form-control" id="est_size">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="share_class">Share Class</label>
                            <select name="share_class" id="share_class" class="form-control">
                                @foreach($share_classes as $share_class)
                                    <option value="{{$share_class->classname}}">{{$share_class->classname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="structure">Structures</label>
                            <select name="structure" id="structure" class="form-control">
                                @foreach($structures as $structure)
                                    <option value="{{$structure->structurename}}">{{$structure->structurename}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 form-group">
                                <label for="bo_comment">Comments</label>
                                <textarea name="bo_comment" class="form-control" id="bo_comment"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveBuyButton">Save Button</button>
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
                            <label for="valuation">Valuation (mn)</label>
                            <input type="number" class="form-control" id="edit_valuation">
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

    <!--Sell Order Modal -->
    <div class="modal fade" id="addSellModal" tabindex="-1" role="dialog"
         aria-labelledby="addSellModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSellLabel">Add Sell Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="so_contact">Contacts</label>
                            <select name="contact" id="so_contact" class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_category">Category</label>
                            <select name="so_category" id="so_category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->categoryname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_price">Price</label>
                            <input type="number" class="form-control" id="so_price">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_valuation">Valuation (mn)</label>
                            <input type="number" class="form-control" id="so_valuation">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_est_size">Est Size (.000)</label>
                            <input type="number" class="form-control" id="so_est_size">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_share_class">Share Class</label>
                            <select name="so_share_class" id="so_share_class" class="form-control">
                                @foreach($share_classes as $share_class)
                                    <option value="{{$share_class->classname}}">{{$share_class->classname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_structure">Structures</label>
                            <select name="so_structure" id="so_structure" class="form-control">
                                @foreach($structures as $structure)
                                    <option value="{{$structure->structurename}}">{{$structure->structurename}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 form-group">
                                <label for="so_comment">Comments</label>
                                <textarea name="so_comment" class="form-control" id="so_comment"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSOButton">Save Button</button>
                </div>
            </div>
        </div>
    </div>

    <!--Sell Order Modal -->
    <div class="modal fade" id="editSOModal" tabindex="-1" role="dialog"
         aria-labelledby="editSOModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSOModalLabel">Edit Sell Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="so_contact">Contacts</label>
                            <select name="contact" id="edit_so_contact" class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_category">Category</label>
                            <select name="so_category" id="edit_so_category" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->categoryname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_price">Price</label>
                            <input type="number" class="form-control" id="edit_so_price">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_est_size">Est Size (.000)</label>
                            <input type="number" class="form-control" id="edit_so_est_size">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_share_class">Share Class</label>
                            <select name="so_share_class" id="edit_so_share_class" class="form-control">
                                @foreach($share_classes as $share_class)
                                    <option value="{{$share_class->classname}}">{{$share_class->classname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="so_structure">Structures</label>
                            <select name="so_structure" id="edit_so_structure" class="form-control">
                                @foreach($structures as $structure)
                                    <option value="{{$structure->structurename}}">{{$structure->structurename}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 form-group">
                                <label for="so_comment">Comments</label>
                                <textarea name="so_comment" class="form-control" id="edit_so_comment"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateSOButton">Update Button</button>
                </div>
            </div>
        </div>
    </div>

    <!--Pair Order Modal -->
    <div class="modal fade" id="pairSOModal" tabindex="-1" role="dialog"
         aria-labelledby="pairSOModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pairSOModalLabel">Buy Orders</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered make-bo-pair">
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
                        <label for="pair_so_comment">Comments</label>
                        <textarea name="pair_so_comment" class="form-control" id="pair_so_comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="pairSellOrder">Pair Now</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">

        $(function () {
            $('.sell-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('sellOrders') }}",
                    {{--data: function (d) {--}}
                    {{--    d.id = "{{$active_user->id}}";--}}
                    {{--    d.filter_orders_of = "contacts";--}}
                    {{--}--}}
                },
                columns: [
                    {data: 'sell_id', name: 'sell_id'},
                    {data: 'company', name: 'company'},
                    {data: 'contact', name: 'contact'},
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
    <script>
        let SOOrderID = '';
        $("#saveSOButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-sale-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "contact": $('#so_contact').val(),
                    {{--"company": "{{$active_company->company_id}}",--}}
                    "category": $('#so_category').val(),
                    "price": $('#so_price').val(),
                    "est_size": $('#so_est_size').val(),
                    "share_class": $('#so_share_class').val(),
                    "structure": $('#so_structure').val(),
                    "bo_comment": $('#so_comment').val(),
                },
                success: function (result) {
                    if (result.status) {
                        alert(result.message);
                        window.location.reload();
                    }
                }
            });
        });

        function getSO_ID(id) {
            SOOrderID = id;
            $.ajax({
                type: "GET",
                url: "{{url('edit-sale-order')}}" + "/" + id,
                success: function (res) {
                    let result = res.data;
                    $('#edit_so_price').val(result.pps);
                    $('#edit_so_valuation').val(result.valuation);
                    $('#edit_so_est_size').val(result.estsize);
                    $('#edit_so_comment').val(result.comments);
                    $("#edit_so_contact option[value=" + result.user_id + "]").prop("selected", true);
                    $("#edit_so_category option[value="+result.category_id+"]").prop("selected", true);
                    $("#edit_so_share_class option[value="+result.shareclass+"]").prop("selected", true);
                    $("#edit_so_structure option[value='"+result.structure+"']").prop("selected", true);
                }
            });
        }

        $("#updateSOButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('update-sale-order')}}"+"/"+SOOrderID,
                data: {
                    "_token": "{{csrf_token()}}",
                    "contact": $('#edit_so_contact').val(),
                    {{--"company": "{{$active_company->company_id}}",--}}
                    "category": $('#edit_so_category').val(),
                    "price": $('#edit_so_price').val(),
                    "valuation": $('#edit_so_valuation').val(),
                    "est_size": $('#edit_so_est_size').val(),
                    "share_class": $('#edit_so_share_class').val(),
                    "structure": $('#edit_so_structure').val(),
                    "bo_comment": $('#edit_so_comment').val(),
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

    <script>

        let bo_arr=[];
        function selectBO(id){
            console.log(id)
            if(!bo_arr.includes(id)){          //checking weather array contain the id
                bo_arr.push(id);               //adding to array because value doesnt exists
            }else{
                bo_arr.splice(bo_arr.indexOf(id), 1);  //deleting
            }
            // arr.push(id);
            console.log(bo_arr , 'sdasd');
        }

        function pairSellOrder(id) {
            SOOrderID=id;

            console.log(id);
            $('.make-bo-pair tbody').html(' ');

            $('.make-bo-pair').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    url:"{{ route('forPairBuyOrders') }}",
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

        $("#pairSellOrder").click(function () {
            console.log(bo_arr)
            $.ajax({
                type: "POST",
                url: "{{url('pair-sell-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "buy_orders":bo_arr,
                    "sell_order":SOOrderID,
                    "company_id":"0",
                    "comment":$('#pair_so_comment').val()
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

    <script>
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll(".sell-orders tr");

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
@endpush
