@extends('frontend.layouts.app.main')

@section('page-title', 'DueList')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/css/yearpicker.css') }}">
    <style>
    .col-form-label{
        font-family: open sans,sans-serif;
        color:#333;
        font-size:13px;
        font-weight:bold;

    }
    table {
  counter-reset: rowNumber-1;
}

table tr {
  counter-increment: rowNumber;
}

table tr td:first-child::before {
  content: counter(rowNumber);
  min-width: 1em;
  margin-right: 0.5em;
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
                        <select class="form-control" name="Item_Size"  id="Item_Size">
                        @foreach($kit as $s)
                        <option value="{{ $s->id}}">{{ $s->name}}</option>
                        @endforeach
                        </select>
                     </div>
                    <div class="col-md-8 col-lg-3 form-group">
                        <input type="text" class="form-control" id="employee_name" required placeholder="Employee Name">
                        <!-- <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span>  -->
                    </div>
                    <div class="col-md-8 col-lg-3 form-group">
                        <input type="text" class="form-control" id="pf_no" required placeholder="Payslip Number">
                        <!-- <span class="icon-inside"><i class="fas fa-map-marker-alt"></i></span> -->
                     </div>
                    <div class="col-md-8 col-lg-3 form-group">
                        <!-- <button class="btn btn-primary btn-block btn-sm" type="submit">Search</button> -->
                    </div>
                    </div>

    </div>
    <br>
    <div id="DataTable">
  <div id="table_box_bootstrap "></div>
  <h3 class="box-title">Filter Results</h3>
  <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block custom-badge-div" id="customBadge2">
                    <div class="dt-responsive table-responsive">


<table class="table table-striped " id="table">

  <thead>
    <tr>
    <th>S.No.</th>
    <th>Employee Name</th>
    <th>Pay slip Number</th>
    <th>Rank</th>
    <th>Item Name</th>
    <th>System Assign Date</th>
    <th>Physically Assign Date</th>
    <th>Description</th>
    <th>Action</th>
    </tr>
  </thead>
  <tbody id="">
    @foreach($data as $d)
    {{-- {{ dd($d)}} --}}
    <tr>
      <td></td>
      <td> {{$d->employee_name }}</td>
      <td>{{$d->pay_slip_employee_no}}</td>
      <td>{{$d->name}}</td>
      <td>{{ $d->item_name}}</td>
      <td></td>
      <td></td>
      <td></td>
      <td><a href="{{url('due/'.$d->id)}}"><button type="button " class="btn btn-danger">Procedure</button></a><td>
    </tr>
    @endforeach


  </tbody>
</table>
<div class="row float-right mb-4  ">
<div class="col-12">
{{ $data->links()}}
 </div>

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

<!-- <script src="{{ asset('assets/js/vertical/vertical-layout.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script> -->


{{-- <script type="text/javascript" src="jquery.tablesorter.js"></script> --}}
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script type="text/javascript" src="jquery.tablesorter.js"></script>
 <script type="text/javascript" src="jquery-latest.js"></script>



 <!-- <script src="{{ asset('js/post.js')}}"></script> -->
 <script>

$(document).ready(() => {

$('#saveData').on('click', () => {

                        let createform = $('#createform').serialize();

                        var employee_name = $("#employee_name").val();

                        if( employee_name == ""){
                        swal({
                        title: "Employee Name is Menditory",
                        icon: "warning",
                        button: "Ok",
                        });

                        }else {

                        $.ajax({
                            type: 'post',
                            url: '{{ url('addduelist')}}',
                            data: createform,
                            success: (res) => {
                                swal({
                                    title: "Successfully Submitted",
                                    // text: "You clicked the button!",
                                    icon: "success",
                                    button: "Ok",
                                });
                            }
                        });
                    }
                    // location.href = "display"
                    jQuery('#createform')['0'].reset();

                });

            });

            // new filter for employee name js

            $("#employee_name").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(value);
            $("#table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            });

            // end

            //here is the custom JS we would like to add
                $("#Item_Size").change(function(){
                $("#table tbody tr").hide();
                $("#table tbody tr."+$(this).val()).show('fast');
                });

                //this JS calls the tablesorter plugin that we already use on our site
                $("#table").tablesorter( {sortList: [[0,0]]} );


            // end



            // new filter for pf number js

            $("#pf_no").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            });

            // end

            jQuery(document).ready(function () {

                jQuery('#Item_Size').change(function () {
                    let id = jQuery(this).val();
                    console.log(id);

                    jQuery.ajax({

                        url:"{{ url('DueEmpList')}}",
                        type:'post',
                        data:'id='+id+
                        '&_token={{ csrf_token()}}',
                        success:function(result){
                            // console.log(id);
                        }

                    });

                });
            });


</script>


@endsection
