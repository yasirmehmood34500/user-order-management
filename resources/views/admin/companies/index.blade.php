@extends('layouts.app')

@section('title','Companies')

@section('search')
    <div class="gull-brand mt-3 p-2">
        <hr style="margin-top:0 !important;">
        <input type="search" class="form-control live-search-box" name="search" id="search" placeholder="Search">
        <!--  <span class=" item-name text-20 text-primary font-weight-700">GULL</span> -->
    </div>
@endsection

@section('side-bar-links')

    <div class="main-menu">
        <ul class="metismenu live-search-list" id="menu" style="height: 100vh!important; ">
            @foreach($all_companies as $company)
                <li class="Ul_li--hover">
                    <!-- company Name -->
                    <a href="{{url('companies?search=').$company->company_id}}">
                        <span class="item-name text-15 text-muted">{{$company->comp_name}}</span>
                    </a>
                </li>
            @endforeach
            <div class="Ul_li--hover text-center">
                <button type="button" class="text-muted btn btn-muted" data-toggle="modal"
                        data-target="#addCompanyModal">
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
                    <p>Company Details</p>
                    <button type="button" id="editButton" class="text-muted btn btn-muted" data-toggle="modal"
                            data-target="#editCompanyModal">
                        Edit
                    </button>
                </div>

                <div class="card-body">

                    <div class="row">
                        <p class="font-weight-bold col-md-2">Company Name:</p>
                        <span class="col-md-4">{{ strtoupper($active_company->comp_name) }}</span>
                        <p class="font-weight-bold col-md-2">Invest Stage:</p>
                        <span class="col-md-4">{{ $active_company->invest_stage }}</span>
                    </div>
                    <div class="row">
                        <p class="font-weight-bold col-md-2">Location:</p>
                        <span class="col-md-4">{{$active_company->Location ? $active_company->Location->geogarea : 'N/A'}}</span>
                        <p class="font-weight-bold col-md-2">Sector:</p>
                        <span class="col-md-4">{{$active_company->Sector ? $active_company->Sector->sectorname :'N/A' }}</span>
                    </div>
                    <div class="row">
                        <p class="font-weight-bold col-md-2">Business:</p>
                        <span class="col-md-4">{{ $active_company->business_id }}</span>
                        <p class="font-weight-bold col-md-2">Background:</p>
                        <span class="col-md-4">{{ $active_company->background }}</span>
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
                            <th>Company</th>
                            <th>User Profile</th>
                            <th>Est Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                            <th>Share Class</th>
                            <th>Structure</th>
                            @if(auth()->user()->hasRole('Admin'))
                            <th>comment</th>
                            <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
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
                            <th>Company</th>
                            <th>User Profile</th>
                            <th>Est Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                            <th>Share Class</th>
                            <th>Structure</th>
                            @if(auth()->user()->hasRole('Admin'))
                                <th>comment</th>
                                <th >Action</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->hasRole('Admin'))
    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div class="card">
        <div class="card-header d-flex justify-content-between">
            <p>{{ __('Paired Orders') }}</p>
            <form action="{{url('companies')}}" class="d-flex">
                <input type="search" name="search_pair" placeholder="search" class="form-control input-group-sm" value="{{request('search_pair')}}">
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
    @endif

    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Current Holdings</p>
                    <button type="button" id="buy_order" class="text-muted btn btn-muted" data-toggle="modal"
                            data-target="#addHoldModal">
                        Add New
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered holdings">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>User Profile</th>
                            <th>holding</th>
                            <th>target</th>
                            <th>PPS</th>
                            <th>shareclass</th>
                            @if(auth()->user()->hasRole('Admin'))
                                <th>comments</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Add  Hold Modal = -->
    <div class="modal fade" id="addHoldModal" tabindex="-1" role="dialog"
         aria-labelledby="addHoldModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHoldModalLabel">Add Holding</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="company_id" value="{{$active_company->company_id}}">
                        <div class="col-md-6 form-group">
                            <label for="hold_contact">Contacts</label>
                            <select name="hold_contact" id="hold_contact" class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="holding">Holding</label>
                            <input type="number" class="form-control" id="holding">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="hold_pps">PPS</label>
                            <input type="number" class="form-control" id="hold_pps">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="hold_target">Target</label>
                            <input type="number" class="form-control" id="hold_target">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="hold_share_class">Share Class</label>
                            <select name="hold_share_class" id="hold_share_class" class="form-control">
                                @foreach($share_classes as $share_class)
                                    <option value="{{$share_class->classname}}">{{$share_class->classname}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 form-group">
                                <label for="hold_comment">Comments</label>
                                <textarea name="hold_comment" class="form-control" id="hold_comment"></textarea>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveHold">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!--Add Company Modal -->
    <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog"
         aria-labelledby="addCompanyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompanyLabel">Add Company Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="company_id" value="{{$active_company->company_id}}">
                        <div class="col-md-6 form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name">
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
                            <label for="invest_stage">Investment stage</label>
                            <select name="invest_stage" id="invest_stage" class="form-control">
                                <option value="Early stage">Early stage</option>
                                <option value="Mid stage">Mid stage</option>
                                <option value="Late stage">Late stage</option>
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
                            <label for="deal_type">Deal Type</label>
                            <input type="text" class="form-control" id="deal_type">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="business_orient">Business Model Orientation</label>
                            <select name="business_orient" id="business_orient" class="form-control">
                                @foreach($business as $bus)
                                    <option value="{{$bus->business_id}}">{{$bus->business_orient}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="company_background">Background</label>
                            <input type="text" class="form-control" id="company_background">
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                        <div class="col-md-6 form-group">
                            <label for="comments">Comments</label>
                            <textarea name="comments" class="form-control" id="comment"></textarea>
                        </div>
                            @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!--Edit Company Modal -->
    <div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog"
         aria-labelledby="editCompanyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompanyModalLabel">Edit Company Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="edit_company_name">
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
                            <label for="invest_stage">Investment stage</label>
                            <select name="invest_stage" id="edit_invest_stage" class="form-control">
                                <option value="Early stage">Early stage</option>
                                <option value="Mid stage">Mid stage</option>
                                <option value="Late stage">Late stage</option>
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
                            <label for="deal_type">Deal Type</label>
                            <input type="text" class="form-control" id="edit_deal_type">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="business_orient">Business Model Orientation</label>
                            <select name="business_orient" id="edit_business_orient" class="form-control">
                                @foreach($business as $bus)
                                    <option value="{{$bus->business_id}}">{{$bus->business_orient}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="company_background">Background</label>
                            <input type="text" class="form-control" id="edit_company_background">
                        </div>
                        @if(auth()->user()->hasRole('Admin'))
                        <div class="col-md-6 form-group">
                            <label for="comment">Comments</label>
                            <textarea name="comment" class="form-control" id="edit_comment"></textarea>
                        </div>
                            @endif
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

    <!--Pair Buy Order Modal -->
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
    <!--Pair SO Order Modal -->
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
            var table = $('.buy-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('buyOrders') }}",
                    data: function (d) {
                        d.id = "{{$active_company->company_id}}";
                        d.filter_orders_of = "company";
                    }
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
                        d.id = "{{$active_company->company_id}}";
                        d.filter_orders_of = "company";
                    }
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
            $('.holdings').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('current-holdings.getHoldings') }}",
                    data: function (d) {
                        d.id = "{{$active_company->company_id}}";
                        d.filter_orders_of = "company";
                    }
                },
                columns: [
                    {data: 'holding_id', name: 'holding_id'},
                    {data: 'company', name: 'company'},
                    {data: 'contact', name: 'contact'},
                    {data: 'holding', name: 'holding'},
                    {data: 'target', name: 'target'},
                    {data: 'pps', name: 'pps'},
                    {data: 'shareclass', name: 'shareclass'},
                        @if(auth()->user()->hasRole('Admin'))
                    {data: 'comments', name: 'comments'}
                    @endif
                ]
            });
        });
    </script>
    <script>
{{--        Company--}}
        $("#saveButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-company')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "company_name": $('#company_name').val(),
                    "location": $('#location').val(),
                    "invest_stage": $('#invest_stage').val(),
                    "sectors": $('#sectors').val(),
                    "deal_type": $('#deal_type').val(),
                    "business_orient": $('#business_orient').val(),
                    "company_background": $('#company_background').val(),
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
            $('#edit_company_name').val('{{$active_company->comp_name}}')
            $("#edit_location option[value=" + {{$active_company->geog_id}} + "]").prop("selected", true);
            $("#edit_invest_stage option[value='{{$active_company->invest_stage}}']").prop("selected", true);
            $("#edit_sectors option[value='{{$active_company->sector_id}}']").prop("selected", true);
            $("#edit_business_orient option[value='{{$active_company->business_id}}']").prop("selected", true);
            $('#edit_deal_type').val('{{$active_company->deal_type}}');
            $('#edit_company_background').val('{{$active_company->background}}');
            $('#edit_comment').val('{{$active_company->comment}}');
        });
        $("#updateButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('update-company')}}"+"/"+{{$active_company->company_id}},
                data: {
                    "_token": "{{csrf_token()}}",
                    "company_name": $('#edit_company_name').val(),
                    "location": $("#edit_location").val(),
                    "invest_stage": $("#edit_invest_stage").val(),
                    "sectors": $('#edit_sectors').val(),
                    "deal_type": $('#edit_deal_type').val(),
                    "business_orient": $('#edit_business_orient').val(),
                    "company_background": $('#edit_company_background').val(),
                    "comment": $('#edit_comment').val(),
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
        let BuyOrderID = '';
        $("#saveBuyButton").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-buy-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "contact": $('#contact').val(),
                    "company": "{{$active_company->company_id}}",
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
                    $("#edit_contact option[value=" + result.user_id + "]").prop("selected", true);
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
                    "contact": $('#edit_contact').val(),
                    "company": "{{$active_company->company_id}}",
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
            $('.make-so-pair tbody').html(' ');

            $('.make-so-pair').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    url:"{{ route('forPairSellOrders') }}",
                    data: function (d) {
                        d.id = "{{$active_company->company_id}}";
                        d.filter_orders_of = "company";
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
                        d.id = "{{$active_company->company_id}}";
                        d.filter_orders_of = "company";
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
                    "company": "{{$active_company->company_id}}",
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
                    "company": "{{$active_company->company_id}}",
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

        $("#pairBuyOrder").click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('pair-buy-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "sell_orders":so_arr,
                    "buy_order":BuyOrderID,
                    "company_id":"{{$active_company->company_id}}",
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
        $("#pairSellOrder").click(function () {
        console.log(bo_arr)
            $.ajax({
                type: "POST",
                url: "{{url('pair-sell-order')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "buy_orders":bo_arr,
                    "sell_order":SOOrderID,
                    "company_id":"{{$active_company->company_id}}",
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

        $('#saveHold').click(function () {
            $.ajax({
                type: "POST",
                url: "{{url('save-holding')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "hold_contact":$('#hold_contact').val(),
                    "holding":$('#holding').val(),
                    "hold_pps":$('#hold_pps').val(),
                    "hold_target":$('#hold_target').val(),
                    "hold_share_class":$('#hold_share_class').val(),
                    "hold_comment":$('#hold_comment').val(),
                    "company_id":"{{$active_company->company_id}}"
                },
                success: function (result) {
                    if (result.status) {
                        alert(result.message);
                        window.location.reload();
                    }
                }
            });
        })
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
