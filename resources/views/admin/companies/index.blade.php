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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>{{$active_company->comp_name}}</p>
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
                        <p class="font-weight-bold col-md-2">Sector:</p>
                        <span class="col-md-4">{{ $active_company->sector_id }}</span>
                        <p class="font-weight-bold col-md-2">Location:</p>
                        <span class="col-md-4">{{ $active_company->geog_id }}</span>
                    </div>
                    <div class="row">
                        <p class="font-weight-bold col-md-2">Business:</p>
                        <span class="col-md-4">{{ $active_company->business_id }}</span>
                        <p class="font-weight-bold col-md-2">Background:</p>
                        <span class="col-md-4">{{ $active_company->background }}</span>
                    </div>
                </div>
            </div>
            <!--Add Modal -->
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
                                <div class="col-md-6 form-group">
                                    <label for="comment">Comments</label>
                                    <textarea name="comment" class="form-control" id="edit_comment"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
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
                    "company_background": $('company_background').val(),
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
