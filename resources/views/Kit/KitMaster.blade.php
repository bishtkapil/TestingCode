
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .top{
            margin-top:50px;
        }
        .card{
            background: #ddd;
             border: 2px solid;
        }
        form{
            padding:10px;
        }
    </style>
</head>
<body>
    <div class="container card p-5 top">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="card-block">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="createform">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label block">Item Name</label>
                            <div class="col-sm-11">
                                    <input type="text" class="form-control" placeholder="Enter Item Name" name="Uniform_Item" id="Uniform_Item"  >
                            </div>
                        </div><br>
                        <div class="form-group row">
                        <div class="col-md-6">
                                <div class="row">
                                <label class="col-md-2  col-form-label block">Entitlement</label>
                                    <div class="col-md-10">
                                        <div class="input-group" id="">
                                        <select class="form-control" id="Entitlement" name="entitlement[]" multiple="multiple" >
                                            <option value=""></option>
                                            @foreach($entitlement as $et)

                                            <option value="{{ $et->id}}">{{ $et->name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                <label class="col-md-2  col-form-label block">Item Size</label>
                                    <div class="col-md-10">
                                        <div class="input-group" id="">
                                        <input type="text" class="form-control" placeholder="Enter Item Size"  name="item_size" id="item_size">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group row">
                        <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-2  col-form-label block">Codal Life</label>
                                    <div class="col-md-10">
                                        <div class="input-group" id="">
                                        <input type="text" class="form-control" placeholder="Enter Codal Life In Year" minlength="2" maxlength="2"  name="codal_life_years" id="codal_life_years">
                                            <span class="input-group-append" id="basic-addon3">
                                            <label class="input-group-text btn-primary">In Years</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-2  col-form-label block">Codal Life</label>
                                    <div class="col-md-10">
                                        <div class="input-group" id="">
                                        <input type="number" class="form-control" placeholder="Enter Codal Life In Months" name="codal_life_months" id="codal_life_months">
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text btn-primary">In Months</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group row">
                        <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-2  col-form-label block">Codal Life</label>
                                    <div class="col-md-10">
                                        <div class="input-group" id="">
                                        <input type="number" class="form-control" placeholder="Enter Codal Life In Days" name="codal_life_days" id="codal_life_days">
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text btn-primary">In Days</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                <label class="col-md-2  col-form-label block">Scale</label>
                                    <div class="col-md-10">
                                        <div class="input-group" id="item_scale">
                                        <input type="number" class="form-control" placeholder="Enter Item Quantity" name="item_scale" id="item_scale">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>

                        <div class="form-group row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                        <div class="form-group row">
                        <div class="col-sm-12">
                                <button class="btn-md btn-primary rounded-border pull-right" id="saveData" type="button">Submit</button>
                            </div>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

    <!-- ✅ Load CSS file for Select2 -->
    <link
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet"
    />
    <!-- ✅ load jQuery ✅ -->
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <!-- ✅ load JS for Select2 ✅ -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
      integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 <script>
    // insert data
    $(document).ready(() => {

    $('#saveData').on('click', () => {

                        let createform = $('#createform').serialize();

                        var Uniform_Item = $("#Uniform_Item").val();
                        var item_scale = $("#item_scale").val();
                        var codal_life_years = $("#codal_life_years").val();
                        var codal_life_months = $("#codal_life_months").val();
                        var codal_life_days = $("#codal_life_days").val();
                        var Entitlement = $("#Entitlement").val();

                        if( Uniform_Item == "" ){
                        swal({
                        title: "Uniform Item  must be filled out",
                        icon: "warning",
                        button: "Ok",
                        });

                        }else {

                        $.ajax({
                            type: 'post',
                            url: '{{ url('addmaster')}}',
                            data: createform,
                            success: function (response) {
                         if(response.status == "success"){
                                swal({
                                    title: "Successfully Submitted",
                                    // text: "You clicked the button!",
                                    icon: "success",
                                    button: "Ok",
                                });

                                jQuery('#createform')['0'].reset();
                                $("#Entitlement").val("");
                                $("#Entitlement").trigger("change");
                                $("#item_size").val("");
                                $("#item_size").trigger("change");

                       }else if(response.status == "false"){
                                 swal({
                                    title: "Already Submitted",
                                    // text: "You clicked the button!",
                                    icon: "warning",
                                    button: "Ok",
                                });
                            }
                       }

                        });
                    }
                    // location.href = "display"


                });

            });



            // end here

            //multi select option
     $(document).ready(function() {

        $('#Entitlement').select2();
    });


    $(document).ready(function() {
    $('#Entitlement').select2({
        placeholder: "Please Select Entitlement"
    });




});
</script>



