@extends('layouts.app')

@section('title','Contacts')

@section('search')
    <div class="gull-brand mt-3 p-2">
        <hr style="margin-top:0 !important;">
        <input type="search" class="form-control live-search-box" name="search" id="search" placeholder="Search">
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
                        <span class="col-md-4">{{ $active_user->geog_id }}</span>
                    </div>
                    <div class="row">
                        <p class="font-weight-bold col-md-2">Sector:</p>
                        <span class="col-md-4">{{ $active_user->sector_id }}</span>
                        <p class="font-weight-bold col-md-2">Address:</p>
                        <span class="col-md-4">{{ $active_user->street_address }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Buy Orders</p>
                </div>

                <div class="card-body">
                    <table class="table table-bordered buy-orders">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th width="100px">Action</th>
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


@endsection
@push('js')
    <script type="text/javascript">
        $(function () {
            var table = $('.buy-orders').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('buyOrders') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
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
