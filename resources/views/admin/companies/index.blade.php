@extends('layouts.app')

@section('title','Companies')
@section('side-bar')
    <div class="sidebar-panel">
        <div class="gull-brand mt-3 p-2">
            <input type="search" class="form-control live-search-box" name="search" id="search" placeholder="Search">
            <!--  <span class=" item-name text-20 text-primary font-weight-700">GULL</span> -->
        </div>
        <!--  user -->
        <div class="scroll-nav ps ps--active-y" data-perfect-scrollbar="data-perfect-scrollbar" data-suppress-scroll-x="true">
            <div class="side-nav">
                <div class="main-menu">
                    <ul class="metismenu live-search-list" id="menu">
                        <li class="Ul_li--hover">
                        <!-- company Name -->
                            <a href="">
                                <span class="item-name text-15 text-muted">company Name</span>
                            </a>
                        </li>
                        <li class="Ul_li--hover">
                        <!-- company Name 2 -->
                            <a href="">
                                <span class="item-name text-15 text-muted">company Name 2</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--  side-nav-close -->
    </div>
@endsection
@section('content')
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>

                <div class="card-body">
                   
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function($){
        $('.live-search-list li a span').each(function(){
            $(this).attr('data-search-term', $(this).text().toLowerCase());
        });

        $('.live-search-box').on('keyup', function(){

        var searchTerm = $(this).val().toLowerCase();
            $('.live-search-list li ').each(function(){
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
