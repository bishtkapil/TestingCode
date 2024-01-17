
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="card-body">
        <div class="card-header bg-white">
                <form id="createform">
                @csrf
                <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label" id="label">Item Purchased/Recevied From*</label>
                <div class="col-sm-9">
                    <select class="form-control" name="Item_Purchased" placeholder="Select Store" id="Item_Purchased">
                       <option value="">Select Store</option>
                       @foreach($stores as $key => $val)
                         <option value="{{ $key }}">{{ $val }}</option>
                         @endforeach
                    </select>
                </div>
                </div>

                <div class="form-group row">
             <label for="" class="col-sm-2 col-form-label" id="label">Item Name*</label>
             <div class="col-sm-9">
                 <select class="form-control" name="Item_Name" id="Item_Name">
                 <option value="">Select</option>
                    @foreach($kit_item as $item)
                        <option value="{{ $item->id}}">{{ $item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
             <label for="" class="col-sm-2 col-form-label" id="label">Item Size*</label>
             <div class="col-sm-9">
                 <select class="form-control" name="Item_Size" id="Item_Size">
                 <option val="">Select</option>
                    @foreach($item_size as $s)
                        <option value="{{ $s->id}}" val="{{ $s->kit_name_id}}">{{ $s->size}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label" id="label">Quantity*</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="pwd" name="quantity" placeholder="Enter quantity">
                   </div>
                  </div>

            <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label" id="label">Vendar/Department Detail*</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" id="pwd" name="Vendor_Department_Details" placeholder="Selected Item">
                   </div>
                  </div>

            <div class="form-group row">
                     <label for="inputPassword" class="col-sm-2 col-form-label" id="label">Vendor Contact Number</label>
                     <div class="col-sm-9">
                     <input type="number" class="form-control" id="pwd" name="Vendor_Contact_No" placeholder="Vendor Number">
                     </div>
                    </div>

            <div class="form-group row">
           <label for="inputPassword" class="col-sm-2 col-form-label" id="label">P.O/W.O/indent/Regs.No*</label>
               <div class="col-sm-9">
               <input type="number" class="form-control" id="pwd" name="P.O_W.O_Regs_No" placeholder="Enter P.O/W.O/Regs.No">
               </div>
          </div>

                <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" id="label">P.O/W.O/indent/Regs.Date*</label>
                <div class="col-sm-9">
                <input type="date" class="form-control" name="P.O_W.O_Regs_Date" placeholder="P.O_W.O_Regs_Date" >
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" id="label">challan/Issued Note No*</label>
                <div class="col-sm-9">
                <input type="number" class="form-control" id="pwd" name="Challan_Issued_Note_No" placeholder="Enter Challan_Issued_Note_No">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" id="label">challan/Issued Note Date*</label>
                <div class="col-sm-9">
                <input type="date" class="form-control" name="Challan_Issued_Note_Date" >
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" id="label">Invoice/Bill Date*</label>
                <div class="col-sm-9">
                <input type="date" class="form-control" name="Ivoice_Bill_Date" >
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label" id="label">Inspection On</label>
                <div class="col-sm-9">
                <input type="date" class="form-control" name="Inspection_On">
                </div>
            </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label" id="label">Inspection By </label>
                    <div class="col-sm-9">
                    <input type="date" class="form-control" name="Inspection_By">
                    </div>
                </div>

            <div class="card-footer mb-3">
            <div class="form-group">
            <div class="col-sm-9" style="margin-left: 280px;">
            <button type="button" class="btn btn-primary float-right" id="saveData">Submit</button>
            </div>
                </div>
            </div>
            </form>
        </div>
            </div>
        </div>
</body>
</html>



 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 <script>

$(document).ready(() => {

$('#saveData').on('click', () => {

                        let createform = $('#createform').serialize();

                        var Item_Purchased = $("#Item_Purchased").val();

                        if( Item_Purchased == ""){
                        swal({
                        title: "Item Purchased must be filled out",
                        icon: "warning",
                        button: "Ok",
                        });

                        }else {

                        $.ajax({
                            type: 'post',
                            url: '{{ url('addstore')}}',
                            data: createform,
                            success: (res) => {
                                swal({
                                    title: "Successfully Submitted",
                                    // text: "You clicked the button!",
                                    icon: "success",
                                    button: "Ok",
                                });

                                // location.reload();
                            }
                        });
                    }

                    jQuery('#createform')['0'].reset();
                    // location.href = "display"
                    // location.reload();
                    // setTimeout(function(){
                    // window.location.reload();
                    // }, 2000);


                });

            });


// $(document).ready( function() {
//     var $select1 = $( '#Item_Name' ),
// 		$select2 = $( '#Item_Size' ),
//         $options = $select2.find( 'option' );

//     $select1.on( 'change', function() {
// 	$select2.html( $options.filter( '[val="' + this.value + '"]' ) );
//     } ).trigger( 'change' );

// });


$(document).ready(function() {
    var $select1 = $('#Item_Name'),
        $select2 = $('#Item_Size'),
        $options = $select2.find('option');

    $select1.on('change', function() {
        var selectedValue = this.value;
        var filteredOptions = $options.filter('[val="' + selectedValue + '"]');

        $select2.empty();

        $select2.append('<option value="">Select </option>');

        // Append filtered options to the second dropdown
        filteredOptions.each(function() {
            $select2.append($(this).clone());
        });
    }).trigger('change');
});

</script>


