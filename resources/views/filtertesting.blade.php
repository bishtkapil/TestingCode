


public function getDueList(Request $request)
{
//  $id = $request->post('Item_Size');
//     error_log($id);
// $selectedValue = $request->query('selectedValue');
// error_log($selectedValue);
// $numbers = [10, 5, 8, 20, 3];
// $maxNumber = $numbers[0];

    $ranks = DB::table('ranks')->select('*')->get();

    $kit = DB::table('kit_item_names')->select('*')->get();
    $codal_life = DB::table("kit_item_names")->select("codal_life_years", "codal_life_months", "codal_life_days")->where("id", 1)->get();
    $current_date = Carbon::now();
    $days=$codal_life[0]->codal_life_days;
    $year=$codal_life[0]->codal_life_years;
    $month=$codal_life[0]->codal_life_months;
    $newDateTime = Carbon::now()->subYear($codal_life[0]->codal_life_years)->subMonth($codal_life[0]->codal_life_months)->subDays($codal_life[0]->codal_life_days);
    // error_log($codal_life[0]->codal_life_years);
    $data = DB::connection("mysql")->table("kit_item_names as ktn")->select('emp.employee_name', "emp.pay_slip_employee_no", 'r.name as rank_name', 'r.id as rank_id', 'emp.id',"kts.size as item_size", "emp.ein as emp_id", "ktn.name as item_name", "ktn.id as item_id", "kt.physicaly_assign_date", "kt2.description",DB::raw("DATE_ADD(DATE_ADD(DATE_ADD(kt.physicaly_assign_date, INTERVAL  $year YEAR),INTERVAL $month MONTH),INTERVAL $days DAY ) as system_assign_date"))
        ->where("ktn.id", "=", 1)->leftjoin("testing.employee as emp", function ($join) {
            $join->whereRaw("find_in_set(emp.current_rank_id,ktn.entitlement)");
        })
        ->leftJoin('ranks as r', 'r.id', '=', 'testing.emp.current_rank_id')
        ->leftJoin('testing.kit_apparel_size as aps', 'emp.pay_slip_employee_no', '=', 'aps.pay_slip_employee_no')
        ->leftJoin('testing.kit_size as kts', 'aps.kit_size', '=', 'kts.id')
        ->leftJoin(DB::raw('(SELECT pay_slip_number ,MAX(physicaly_assign_date) as physicaly_assign_date FROM kit_transaction where item_name_id = 1 GROUP BY pay_slip_number) kt'),function($query){
            $query->on("kt.pay_slip_number","=","emp.pay_slip_employee_no");
        })
        ->leftJoin("kit_transaction as kt2","kt.physicaly_assign_date","=","kt2.physicaly_assign_date")
        ->whereNotIn("emp.pay_slip_employee_no", DB::table("kit_transaction as kt")->select("kt.pay_slip_number")->where("kt.item_name_id", "=", 1)->whereBetween("kt.physicaly_assign_date", [$newDateTime, $current_date]))
        ->orderby('system_assign_date','DSC')
        ->get();

    return DataTables::of($data)
    ->addIndexColumn()
   ->make(true);

}


public function DueEmpList(Request $request){

$kit = DB::table('kit_item_names')->select('*')->get();
error_log("testing");
$id = $request->input('yourVariable');
error_log($id);

// $data = fetchDataFromDatabase($yourVariable);
$codal_life = DB::table("kit_item_names")->select("codal_life_years", "codal_life_months", "codal_life_days")->where("id", $id)->get();
$current_date = Carbon::now();
$days=$codal_life[0]->codal_life_days;
$year=$codal_life[0]->codal_life_years;
$month=$codal_life[0]->codal_life_months;
$newDateTime = Carbon::now()->subYear($codal_life[0]->codal_life_years)->subMonth($codal_life[0]->codal_life_months)->subDays($codal_life[0]->codal_life_days);

$data = DB::connection("mysql")->table("kit_item_names as ktn")->select('emp.employee_name', 'emp.pay_slip_employee_no', 'r.name as rank_name', 'r.id as rank_id', 'emp.id',"kts.size as item_size", "emp.ein as emp_id", "ktn.name as item_name", "ktn.id as item_id", "kt.physicaly_assign_date", "kt2.description", DB::raw("DATE_ADD(DATE_ADD(DATE_ADD(kt.physicaly_assign_date, INTERVAL  $year YEAR),INTERVAL $month MONTH),INTERVAL $days DAY ) as system_assign_date"))
    ->where("ktn.id", "=", $id)->leftjoin("testing.employee as emp", function ($join) {
        $join->whereRaw("find_in_set(emp.current_rank_id,ktn.entitlement)");
    })
    ->leftJoin('ranks as r', 'r.id', '=', 'testing.emp.current_rank_id')
    ->leftJoin('testing.kit_apparel_size as aps', 'emp.pay_slip_employee_no', '=', 'aps.pay_slip_employee_no')
    ->leftJoin('testing.kit_size as kts', 'aps.kit_size', '=', 'kts.id')
    ->leftJoin(DB::raw("(SELECT pay_slip_number ,MAX(physicaly_assign_date) as physicaly_assign_date FROM kit_transaction  where item_name_id =  $id GROUP BY pay_slip_number ) kt"),function($query){
        $query->on("kt.pay_slip_number","=","emp.pay_slip_employee_no");
    })
    ->leftJoin("kit_transaction as kt2","kt.physicaly_assign_date","=","kt2.physicaly_assign_date")
    ->whereNotIn("emp.pay_slip_employee_no", DB::table("kit_transaction as kt")->select("kt.pay_slip_number")->where("kt.item_name_id", "=", $id)->whereBetween("kt.physicaly_assign_date", [$newDateTime, $current_date]))
    ->orderby('system_assign_date','DSC')
    ->get();


// $print_data=DataTables::of($data)
// ->addIndexColumn()
// ->make(true);
// error_log($print_data);

return DataTables::of($data)
->addIndexColumn()
->make(true);
}






@extends('frontend.layouts.app.main')

@section('page-title', 'DueList')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/css/yearpicker.css') }}">
    <style>
        .col-form-label {
            font-family: open sans, sans-serif;
            color: #333;
            font-size: 13px;
            font-weight: bold;

        }
    </style>
@endsection
@section('page-body')

    <div class="card-body">
        <div class="card-header bg-white">

            <div class="form-row">
                <div class="col-md-8 col-lg-3 form-group text-justify">
                    <!-- <input id="search" type="text" class="form-control " required placeholder="Item-Name "> -->
                    <!-- <span class="icon-inside"><i class="far fa-calendar-alt"></i></span> -->
                    <select class="form-control" name="Item_Size" id="Item_Size">
                        @foreach ($kit as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 col-lg-3 form-group">
                    <input type="text" class="form-control" id="name" required placeholder="Name">
                    <!-- <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span>  -->
                </div>
                <div class="col-md-8 col-lg-3 form-group">
                    <input type="text" class="form-control" id="password" required placeholder="Payslip Number">
                    <!-- <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span> -->
                </div>
                <div class="col-md-8 col-lg-3 form-group">
                    <!-- <button class="btn btn-primary btn-block btn-sm" type="submit">Search</button> -->
                </div>
            </div>

        </div>
        <br>
        <div id="DataTables">
            <div id="table_box_bootstrap "></div>
            <h3 class="box-title">Filter Results</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-block custom-badge-div" id="customBadge2">
                            <div class="dt-responsive table-responsive">


                                <table class="table table-striped " id="table-id">

                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Employee Name</th>
                                            <th>Pay slip Number</th>
                                            <th>Rank</th>
                                            <th>Item_Name</th>
                                            <th>Item Size</th>
                                            <th>System Assign Date</th>
                                            <th>Previous Assign Date</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                <div class="row float-right mb-4  ">


                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script src="{{ asset('bower_components/jquery.steps/js/jquery.steps.js') }}"></script>
    <script src="{{ asset('bower_components/jquery-validation/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/pages/form-validation/validate.js') }}"></script>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#table-id').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    'pdf'
                    // 'excelHtml5',
                    // 'csvHtml5',
                    // 'pdfHtml5',
                    // {
                    //     extend: 'pdf',
                    //     exportOptions: {
                    //         columns: ':visible',
                    //         // pages: 'all', // Use lowercase 'all'
                    //         scrollX:true,

                    //     }
                    // }

                ],

                ajax: "{{ url('getDueList') }}",
                columns: [{
                        data: 'DT_Row_Index',
                        name: 'DT_Row_Index'
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                    // { data: 'employee_name', name: 'employee_name' },
                    {
                        data: 'pay_slip_employee_no',
                        name: 'pay_slip_employee_no'
                    },
                    {
                        data: 'rank_name',
                        name: 'rank_name'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'item_size',
                        name: 'item_size'
                    },
                    {
                        data: 'system_assign_date',
                        name: 'system_assign_date'
                    },
                    {
                        data: 'physicaly_assign_date',
                        name: 'physicaly_assign_date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // console.log(type);
                            // Action buttons or links go here
                            return ' <button id="received" type="button" class="btn btn-danger bg-danger waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2"><a href="due/' +
                                row.id + '/' + row.item_id + '">Procedure</button></a>';
                        }
                    },

                ],

            });


        });



    $(document).ready(() => {
    $('#Item_Size').on('click', () => {
                 var yourVariable = $('#Item_Size').val();
                 console.log(yourVariable);
                 $('#table-id').DataTable().destroy();
                fetch_data(yourVariable);

            });

        });

function fetch_data(yourVariable){
    var table = $('#table-id').DataTable({
        processing: true,
                serverSide: true,
                searching: true,
                    dom: 'Bfrtip',
                    buttons: [
                    'pdf'
                             ],
                ajax: {
                        type: 'POST',
                        url:"{{ url('DueEmpList') }}",
                        data: {_token: '{{ csrf_token() }}',yourVariable:yourVariable}
                    },
                    columns: [{
                        data: 'DT_Row_Index',
                        name: 'DT_Row_Index'
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                    {
                        data: 'pay_slip_employee_no',
                        name: 'pay_slip_employee_no'
                    },
                    {
                        data: 'rank_name',
                        name: 'rank_name'
                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'item_size',
                        name: 'item_size'
                    },
                    {
                        data: 'system_assign_date',
                        name: 'system_assign_date'
                    },
                    {
                        data: 'physicaly_assign_date',
                        name: 'physicaly_assign_date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // console.log(type);
                            // Action buttons or links go here
                            return ' <button id="received" type="button" class="btn btn-danger bg-danger waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2"><a href="due/' +
                                row.id + '/' + row.item_id + '">Procedure</button></a>';
                        }
                    },

                ],
                });

            }
    </script>



@endsection
