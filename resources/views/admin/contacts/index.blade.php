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
        <ul class="metismenu" id="menu">
            <li class="Ul_li--hover">
                <a href="">
                    <span class="item-name text-15 text-muted">Contact Name</span>
                </a>
            </li>
            <li class="Ul_li--hover">
                <a href="">
                    <span class="item-name text-15 text-muted">Contact Name 2</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Contacts') }}</div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
@endsection
