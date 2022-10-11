<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{asset('dist-assets/css/themes/lite-purple.css')}}" rel="stylesheet" />
    <link href="{{asset('dist-assets/css/plugins/perfect-scrollbar.css')}}" rel="stylesheet" />
{{--    <link rel="stylesheet" href="{{asset('dist-assets/css/plugins/fontawesome-5.css')}}" />--}}
    <link href="{{asset('dist-assets/css/plugins/metisMenu.min.css')}}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .fa--customer-icon{
            font-size: 14px !important;
            background-color: #dde1e5;
            padding: 5px;
            margin-right: 10px !important;
            cursor: pointer;
            font-weight: bold;
        }
        .active{
            background: #865eaf;

        }
        .active a span{
            color: white !important;
        }
    </style>
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-vertical sidebar-full ">
        <div class="sidebar-panel position-fixed d-block">
            <div class="pt-4 pl-4">


                <a href="/contacts">
                    <i class="i-Add-UserStar mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Contacts"></i>
                </a>
                <a href="/companies">
                    <i class="nav-icon i-File-Clipboard-Text--Image mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Companies"></i>
                </a>
                @if(auth()->user()->hasRole('Admin'))
                <a href="/paired-order">
                    <i class="nav-icon i-Split-Vertical mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Paired Orders"></i>
                </a>
                @endif
                <a href="/sell-orders">
                    <i class="nav-icon i-Line-Chart-2 mr-3  text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sell Orders"></i>
                </a>
                <a href="/buy-orders">
                    <i class="nav-icon i-Add-Cart  mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Buy orders"></i>
                </a>

{{--                <a href="/acquistion-targets">--}}
{{--                    <i class="i-Circular-Point  mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Acquistion Targets"></i>--}}
{{--                </a>--}}
{{--                <a href="/current-holdings">--}}
{{--                    <i class="nav-icon i-Receipt-4 mr-3 text-20  cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Current Holdings"></i>--}}
{{--                </a>--}}
            </div>
            @yield('search')
            @yield('filter')
            <div class="scroll-nav ps ps--active-y" data-perfect-scrollbar="data-perfect-scrollbar" data-suppress-scroll-x="true">
                <div class="side-nav">
                    @yield('side-bar-links')
                </div>
            </div>
        </div>

        <div class="main-content-wrap mobile-menu-content bg-off-white m-0">
            <div class="text-right">
                <form action="{{url('logout')}}" method="post">
                    @csrf
                    <button class="btn btn-muted btn-sm badge-outline-dark text-right">
                        logout
                    </button>
                </form>
            </div>
            <div class="main-content pt-4">
                <div class="separator-breadcrumb border-top"></div>
            @yield('content')
            </div>
            <div class="sidebar-overlay open"></div><!-- Footer Start -->

        </div>
    </div>

    <script src="{{asset('dist-assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/tooltip.script.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/script.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/script_2.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/sidebar.large.script.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/plugins/feather.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/plugins/metisMenu.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/layout-sidebar-vertical.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/plugins/echarts.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/echart.options.min.js')}}"></script>
    <script src="{{asset('dist-assets/js/scripts/dashboard.v1.script.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function deleteFromGrid(id,ty) {
            let type = null;
            if (ty==1){
                type='buy_order';
            }else if (ty==2){
                type='sell_order';
            }else if (ty==3){
                type='holding';
            }else if (ty==4){
                type='target';
            }else if (ty==5){
                type='company';
            }else if (ty==6){
                type='contact';
            }

            var result = confirm("Are you sure you want to delete current item");
            console.log(id,type);

            if (result) {
                $.ajax({
                    type: "POST",
                    url: "{{url('delete-from-grid')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        'id':id,
                        'type':type
                    },
                    success: function (response) {
                        alert(response.message);
                        if (type=='contact'){
                            location.href= "{{url('contacts')}}";
                        } else if(type=='company'){
                            location.href= "{{url('companies')}}";

                        } else {
                            window.location.reload();
                        }

                    }
                });
            }

        }
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select2-class').select2();
        });
    </script>

    @stack('js')

</body>

</html>
