@extends('layouts.app')

@section('title','Paired Orders')

@section('content')
    <style>
        td { white-space:pre !important; }
    </style>
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                         <h5>{{ __('Paired Orders') }}</h5>
                    <a href="#"  id="buy_order" class="btn btn-secondary"  onclick="exportTableToCSV('paired_orders {{now()->format('Y-d-m')}}')">
                        Export
                    </a>
                </div>

                <div class="card-body">

                    <table class="table table-bordered" id="paired_orders_table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="mr-4" id="checkAll"/>ID</th>
                            <th>Contact</th>
                            <th>EST Size</th>
                            <th>PPS</th>
                            <th>Valuation</th>
                            <th>Share Class</th>
                            <th>Structure</th>
                            @if(auth()->user()->hasRole('Admin'))
                            <th>Fee Structure</th>
                            <th>Comment</th>
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
    <script>
        var table=null;
        $(function () {
            table =  $('#paired_orders_table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [
                    [20,40,100, 500, 1000, 1500],
                    [20,40,100, 500, 1000, 1500],
                ],
                ajax: {
                    url:"{{ route('getPairOrders') }}",
                },
                columns: [
                    {data: 'dt_id', name: 'dt_id',orderable: false},
                    {data: 'dt_contacts', name: 'dt_contacts'},
                    {data: 'dt_est_size', name: 'dt_est_size'},
                    {data: 'dt_pps', name: 'dt_pps'},
                    {data: 'dt_valuation', name: 'dt_valuation'},
                    {data: 'dt_share_class', name: 'dt_share_class'},
                    {data: 'dt_structure', name: 'dt_structure'},
                    @if(auth()->user()->hasRole('Admin'))
                    {data: 'dt_fee_structure', name: 'dt_fee_structure'},
                    {data: 'dt_comments', name: 'dt_comments'}
                    @endif
                ]
            });

        });

        function deletePair(id) {
            $.ajax({
                type: "POST",
                url: "{{url('delete-matching')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    'match_id':id
                },
                success: function (result) {
                    table.draw();
                }
            });
        }
        $('#checkAll').on('click',function () {
            const sub_check_boxes = document.querySelectorAll(".sub_check_boxes");
            if($(this).is(":checked")){
                $('#paired_orders_table tr').addClass('export_row');
                $('.sub_check_boxes').prop('checked',true);
            }else{
                $('#paired_orders_table tr').removeClass('export_row');
                $('.sub_check_boxes').prop('checked',false);
            }
        });
        function checkOneBox(id) {
            if($('#sub_check_box'+id).is(":checked")) {
                let gr_p = $('#sub_check_box'+id).parent();
                gr_p.parent().addClass('export_row');
            }else{
                let gr_p = $('#sub_check_box'+id).parent();
                gr_p.parent().removeClass('export_row');
            }
        }

    </script>
    <script>
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll(".export_row");

            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");
                for (var j = 0; j < cols.length-1 ; j++)
                    row.push(cols[j].innerText.replace('\n','    --   '));
console.log(cols[j].innerText+" r "+j);
                console.log(row + " row"+1);
                csv.push(row.join(","));
            }
            // let newCSV =[];
            // csv.forEach(item=>{
            //     newCSV.push(item.replace('\n',' ').join(','));
            //
            // })
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
