@extends('frontend.layouts.app.main')

@section('page-title', 'due list')

@section('custom-styles')
    <link rel="stylesheet" href="{{ asset('assets/css/yearpicker.css') }}">
    <style>
    .col-form-label{
        font-family: open sans,sans-serif;
        color:#333;
        font-size:13px;
        font-weight:bold;

    }
    </style>
@endsection
@section('page-body')
<div class="card-body">
    <div class="card-header bg-white">
            <form id="createform">
            @csrf
            @foreach($Stock as $d)

            <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label">Employee Name</label>
                 <div class="col-sm-9">

                 <input type="text" class="form-control" id="emp" name="employee_name" value="{{$d->employee_name}}" placeholder="Employee Name">
                 </div>
                </div>


                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label">Pay slip Number	</label>
                 <div class="col-sm-9">
                 <input type="number" class="form-control" id="pwd" name="pay_slip_number" value="{{$d->pay_slip_employee_no}}" placeholder="Pay slip Number	">
                 </div>
                </div>

                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label">Rank</label>
                 <div class="col-sm-9">
                 <input type="text" class="form-control" id="pwd" name="rank" value="{{$d->name}}" placeholder="Rank">
                 </div>
                </div>

                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label"> Item Name </label>
                 <div class="col-sm-9">
                 <input type="text" class="form-control" id="pwd" name="item_name" placeholder="Item Name">
                 </div>
                </div>

                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label"> Scale </label>
                 <div class="col-sm-9">
                 <input type="number" class="form-control" id="pwd" name="scale" placeholder="Scale">
                 </div>
                </div>

                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label">System Assign Date	</label>
                 <div class="col-sm-9">
                 <input type="date" class="form-control" id="pwd" name="system_assign_date" placeholder="System Assign Date">
                 </div>
                </div>

                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label"> Physically Assign Date</label>
                 <div class="col-sm-9">
                 <input type="date" class="form-control" id="pwd" name="physicaly_assign_date" placeholder="Item Physically Assign Date">
                 </div>
                </div>



                <div class="form-group row">
                 <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                 <div class="col-sm-9">
                 <input type="text" class="form-control" id="pwd" name="description	" placeholder="Description">
                 </div>
                </div>
                <div class="card-footer mb-3">
        <div class="form-group">
        <div class="col-sm-9" style="margin-left: 250px;">
        <button type="button" class="btn btn-primary float-right" id="saveData">Submit</button>
        </div>
            </div>
        </div>
        @endforeach
        </form>
    </div>
        </div>
        </form>
    </div>
        </div>
@endsection
@section('custom-scripts')
<script src="{{ asset('bower_components/jquery.steps/js/jquery.steps.js') }}"></script>
<script src="{{ asset('bower_components/jquery-validation/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/pages/form-validation/validate.js') }}"></script>

 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 <script>

$(document).ready(() => {

$('#saveData').on('click', () => {

                        let createform = $('#createform').serialize();

                        $.ajax({
                            type: 'post',
                            url: '{{ url('duesubmit')}}',

                            data: createform,
                            success: (res) => {
                                swal({
                                    title: "Successfully Submitted",
                                    icon: "success",
                                    button: "Ok",
                                });
                            }
                        });
                    jQuery('#createform')['0'].reset();

                });

            });

            // update




</script>

@endsection
