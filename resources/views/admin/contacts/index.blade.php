@extends('layouts.app')

@section('title','Contacts')

@section('search')
    <div class="gull-brand mt-3 p-2">
        <hr style="margin-top:0 !important;">
        <input type="search" class="form-control live-search-box" name="search" id="search" placeholder="Search" >
        <!--  <span class=" item-name text-20 text-primary font-weight-700">GULL</span> -->
    </div>
@endsection

@section('side-bar-links')
    <div class="main-menu">
        <ul class="metismenu live-search-list" id="menu">
            @foreach($users as $user)
                <li class="Ul_li--hover">
                    <!-- User Name -->
                    <a href="{{url('contacts?search=').$user->id}}">
                        <span class="item-name text-15 text-muted">{{$user->name}}</span>
                    </a>
                </li>
            @endforeach
            <div class="Ul_li--hover text-center">
                <button type="button" class="text-muted btn btn-muted" data-toggle="modal"
                        data-target="#addUserModal">
                    +
                </button>
            </div>
        </ul>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>User Details</p>
                    <button type="button" id="editButton" class="text-muted btn btn-muted" data-toggle="modal"
                            data-target="#editUserModal">
                        Edit
                    </button>
                </div>

                <div class="card-body">
                    <div class="row">
                        <p class="font-weight-bold col-md-2">User Name:</p>
                        <span class="col-md-4">{{ strtoupper($active_user->name) }}</span>
                        <p class="font-weight-bold col-md-2">Email:</p>
                        <span class="col-md-4">{{ $active_user->email }}</span>
                    </div>
                    <div class="row">
                        <p class="font-weight-bold col-md-2">Phone:</p>
                        <span class="col-md-4">{{ $active_user->phone }}</span>
                        <p class="font-weight-bold col-md-2">Location:</p>
                        <span class="col-md-4">{{ $active_user->Location ? $active_user->Location->geogarea : 'N/A'}}</span>
                    </div>
                    <div class="row">
                        <p class="font-weight-bold col-md-2">Sector:</p>
                        <span class="col-md-4">{{ $active_user->Sector ? $active_user->Sector->sectorname : 'N/A'}}</span>
                        <p class="font-weight-bold col-md-2">Address:</p>
                        <span class="col-md-4">{{ $active_user->street_address }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Sale Orders</p>
                    <button type="button" id="buy_order" class="text-muted btn btn-muted" data-toggle="modal"
                            data-target="#addSellModal">
                        New Sale Order
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered sell-orders">
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
    <!--Add Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog"
         aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="user_name">User Name</label>
                            <input type="text" class="form-control" id="user_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="location">location</label>
                            <select name="location" id="location" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{$location->geog_id}}">{{$location->geogarea}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sectors">Sectors</label>
                            <select name="sectors" id="sectors" class="form-control">
                                @foreach($sectors as $sector)
                                    <option value="{{$sector->sector_id}}">{{$sector->sectorname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="street_address">Street Address</label>
                            <textarea name="street_address" class="form-control" id="street_address"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="comments">Comments</label>
                            <textarea name="comments" class="form-control" id="comment"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>

     <!--Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog"
         aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="user_name">User Name</label>
                            <input type="text" class="form-control" id="edit_user_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="location">location</label>
                            <select name="location" id="edit_location" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{$location->geog_id}}">{{$location->geogarea}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sectors">Sectors</label>
                            <select name="sectors" id="edit_sectors" class="form-control">
                                @foreach($sectors as $sector)
                                    <option value="{{$sector->sector_id}}">{{$sector->sectorname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="edit_email" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="edit_phone">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="edit_password" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="street_address">Street Address</label>
                            <textarea name="street_address" class="form-control" id="edit_street_address"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="comments">Comments</label>
                            <textarea name="comments" class="form-control" id="edit_comment"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateButton">Update changes</button>
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
                            <label for="company">Company</label>
                            <select name="company" id="company" class="form-control">
                                @foreach($companies as $company)
                                    <option value="{{$company->company_id}}">{{$company->comp_name}}</option>
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
                        <div class="col-md-6 form-group">
                            <label for="bo_comment">Comments</label>
                            <textarea name="bo_comment" class="form-control" id="bo_comment"></textarea>
                        </div>
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
                            <label for="company">companys</label>
                            <select name="company" id="edit_company" class="form-control">
                                @foreach($companies as $company)
                                    <option value="{{$company->company_id}}">{{$company->comp_name}}</option>
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
                        <div class="col-md-6 form-group">
                            <label for="bo_comment">Comments</label>
                            <textarea name="bo_comment" class="form-control" id="edit_bo_comment"></textarea>
                        </div>
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
                            <label for="so_company">companys</label>
                            <select name="company" id="so_company" class="form-control">
                                @foreach($companies as $company)
                                    <option value="{{$company->company_id}}">{{$company->comp_name}}</option>
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
                        <div class="col-md-6 form-group">
                            <label for="so_comment">Comments</label>
                            <textarea name="so_comment" class="form-control" id="so_comment"></textarea>
                        </div>
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
                            <label for="so_company">company</label>
                            <select name="so_company" id="edit_so_company" class="form-control">
                                @foreach($companies as $company)
                                    <option value="{{$company->company_id}}">{{$company->comp_name}}</option>
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
                            <label for="so_valuation">Valuation (mn)</label>
                            <input type="number" class="form-control" id="edit_so_valuation">
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
                        <div class="col-md-6 form-group">
                            <label for="so_comment">Comments</label>
                            <textarea name="so_comment" class="form-control" id="edit_so_comment"></textarea>
                        </div>
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
@endsection
@push('js')
    <script type="text/javascript">

        $(function () {
            var table = $('.buy-orders').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [
                    [20,40,100, 500, 1000, 1500],
                    [20,40,100, 500, 1000, 1500],
                ],
                ajax: {
                    url:"{{ route('buyOrders') }}",
                    data: function (d) {
                        d.id = "{{$active_user->id}}";
                        d.filter_orders_of = "contacts";
                    }
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

        $(function () {
            $('.sell-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('sellOrders') }}",
                    data: function (d) {
                        d.id = "{{$active_user->id}}";
                        d.filter_orders_of = "contacts";
                    }
                },
                columns: [
                    {data: 'sell_id', name: 'sell_id'},
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

    <script>
        $("#saveButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-user')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "user_name": $('#user_name').val(),
                    "location": $('#location').val(),
                    "email": $('#email').val(),
                    "phone": $('#phone').val(),
                    "sectors": $('#sectors').val(),
                    "password": $('#password').val(),
                    "street_address": $('#street_address').val(),
                    "comment": $('#comment').val(),
                },
                success: function (result) {
                    if (result.status) {
                        alert(result.message);
                        window.location.reload();
                    }
                }
            });
        });
        $("#editButton").click(function () {
            $('#edit_user_name').val('{{$active_user->name}}')
            $("#edit_location option[value=" + {{$active_user->geog_id}} + "]").prop("selected", true);
            $("#edit_sectors option[value='{{$active_user->sector_id}}']").prop("selected", true);
            $('#edit_email').val('{{$active_user->email}}');
            $('#edit_phone').val('{{$active_user->phone}}');
            $('#edit_street_address').val('{{$active_user->street_address}}');
            $('#edit_comment').val('{{$active_user->comments}}');
        });
        $("#updateButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('update-user')}}"+"/"+{{$active_user->id}},
                data: {
                    "_token": "{{csrf_token()}}",
                    "user_name": $('#edit_user_name').val(),
                    "location": $("#edit_location").val(),
                    "sectors": $("#edit_sectors").val(),
                    "email": $('#edit_email').val(),
                    "phone": $('#edit_phone').val(),
                    "street_address": $('#edit_street_address').val(),
                    "comment": $('#edit_comment').val(),
                    "password": $('#edit_password').val(),
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


{{--buy--}}
    <script>
        let BuyOrderID = '';
        $("#saveBuyButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-buy-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "company": $('#company').val(),
                    "contact": "{{$active_user->id}}",
                    "category": $('#category').val(),
                    "price": $('#price').val(),
                    "valuation": $('#valuation').val(),
                    "est_size": $('#est_size').val(),
                    "share_class": $('#share_class').val(),
                    "structure": $('#structure').val(),
                    "bo_comment": $('#bo_comment').val(),
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
                    $('#edit_valuation').val(result.valuation);
                    $('#edit_est_size').val(result.estsize);
                    $('#edit_bo_comment').val(result.comments);
                    $("#edit_company option[value=" + result.user_id + "]").prop("selected", true);
                    $("#edit_category option[value="+result.category_id+"]").prop("selected", true);
                    $("#edit_share_class option[value="+result.shareclass+"]").prop("selected", true);
                    $("#edit_structure option[value='"+result.structure+"']").prop("selected", true);
                }
            });
        }
        $("#updateBuyButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('update-buy-order')}}"+"/"+BuyOrderID,
                data: {
                    "_token": "{{csrf_token()}}",
                    "company": $('#edit_company').val(),
                    "contact": "{{$active_user->id}}",
                    "category": $('#edit_category').val(),
                    "price": $('#edit_price').val(),
                    "valuation": $('#edit_valuation').val(),
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
        function pairOrder(id) {
            BuyOrderID=id;
            console.log(id);
            $('.make-so-pair tbody').html('');
            $('.make-so-pair').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    url:"{{ route('forPairSellOrders') }}",
                    data: function (d) {
                        d.id = "{{$active_user->id}}";
                        d.filter_orders_of = "company";
                    }
                },
                columns: [
                    {data: 'sell_checkbox', name: 'sell_checkbox'},
                    {data: 'company', name: 'company'},
                    {data: 'estsize', name: 'estsize'},
                    {data: 'pps', name: 'pps'},
                    {data: 'valuation', name: 'valuation'},
                ]
            });
        }
        let so_arr=[];
        function selectSO(id){
            if(!so_arr.includes(id)){          //checking weather array contain the id
                so_arr.push(id);               //adding to array because value doesnt exists
            }else{
                so_arr.splice(arr.indexOf(id), 1);  //deleting
            }
            // arr.push(id);
            console.log(so_arr);
        }
    </script>
{{--  SO  --}}
    <script>
        let SOOrderID = '';
        $("#saveSOButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-sale-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "company": $('#so_company').val(),
                    "contact": "{{$active_user->id}}",
                    "category": $('#so_category').val(),
                    "price": $('#so_price').val(),
                    "valuation": $('#so_valuation').val(),
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
                    $("#edit_so_company option[value=" + result.user_id + "]").prop("selected", true);
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
                    "company": $('#edit_so_company').val(),
                    "contact": "{{$active_user->id}}",
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
{{--Pair--}}
    <script>

        $("#pairBuyOrder").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('pair-buy-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "sell_orders":so_arr,
                    "buy_order":BuyOrderID,
                    "company_id":"{{$active_user->id}}",
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

    </script>
    <!-- Search code -->
    <script>
        $(document).ready(function ($) {
            $('.live-search-list li a span').each(function () {
                $(this).attr('data-search-term', $(this).text().toLowerCase());
            });

            $('.live-search-box').on('keyup', function () {

                var searchTerm = $(this).val().toLowerCase();
                $('.live-search-list li ').each(function () {
                    if ($(this).find('a span').filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

@endpush
