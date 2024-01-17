<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="card-header bg-white">

        <form id="createform" method="post"  action="{{url('distribution')}}">
        @csrf
        <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label" id="label">Item Purchased/Recevied From</label>
        <div class="col-sm-9">
        <select class="form-control select2 iitem_sizenput-sm kit_items " name="item_name" id="item_name">
                            <option value="">SELECT</option>
                            @foreach($item_name as $item)
                                <option value="{{$item->id}}"> {{$item->name}}</option>
                             @endforeach
                        </select>
        </div>
        </div>

        <div class="form-group row" >

        <label for="" class="col-sm-2 col-form-label">item Size</label>
        <div class="col-sm-4">
                            <select class="form-control" name="item_size" id="item_size">
                            <option val="">SELECT </option>
                            @foreach($item_size as $s)
                            <option value="{{ $s->id}}" val="{{ $s->kit_name_id}}">{{ $s->size}}</option>
                            @endforeach
                            </select>
        </div>
        <div class="col-sm-2">
        <input type="number" class="form-control" id="pwd" name="quantity" placeholder="Quantity">
        </div>
        <label for="" class="col-sm-1">Total Quantity</label>
        <div class="col-sm-1">
        <input type="number" class="form-control"  placeholder="Total Quantity" readonly>
        </div>
        </div>

        <!-- zone user -->
        <div class="form-group row" >
        @if(Auth::user()->role_id === 2)
        <label for="inputPassword" class="col-sm-2 col-form-label">Distribute To </label>
        <div class="col-sm-4">
        <select class="form-control" name="distribution_division" id="division_id">
        <option value="">SELECT DIVISION</option>
        @foreach($division as $p)
        <option value="{{ $p->id}}">{{ $p->name}}</option>

        @endforeach
        </select>
        </div>
        <div class="col-sm-4">
        <select class="form-control" name="distribution_post" id="post_id">
            <option value="" selected>SELECT POST</option>
            @foreach($post as $p)
        <option value="{{ $p->id}}" val="{{ $p->division_id}}">{{ $p->name}}</option>
        @endforeach
        </select>
        </div>
        <!-- 00 -->

        @endif
        </div>
        <!-- zone user end -->
        <!-- division user -->
        <div class="form-group row" >
        @if(Auth::user()->role_id === 3)
        <label for="inputPassword" class="col-sm-2 col-form-label">Distribute To </label>
        <div class="col-sm-4">
        <select class="form-control" name="distribution_post">
        <option value="">SELECT POST</option>
        @foreach($posts as $p)
        <option value="{{ $p->id}}">{{ $p->name}}</option>
        @endforeach
        </select>
        </div>
        @endif
        </div>
        <!-- end user -->
        <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Through</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="pwd" name="through" placeholder="Name,Rank,Posting,Mobile No.">
        </div>
        </div>

        <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Date</label>
        <div class="col-sm-9">
        <input type="date" class="form-control" name="date" >
        </div>
        </div>

        <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Justification/Remarks</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="pwd" name="remark" placeholder="Remark">
        </div>
        </div>


        <div class="card-footer mb-3">
        <div class="form-group">
        <div class="col-sm-9" style="margin-left: 250px;">
        <button type="submit" class="btn btn-primary float-right" id="saveData">Submit</button>
        </div>
        </div>
        </div>
        </form>

            </div>
                </div>
</body>
</html>

<div class="card-body">
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session ('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>

$(document).ready(function() {
    var $select1 = $('#item_name'),
        $select2 = $('#item_size'),
        $options = $select2.find('option');

    $select1.on('change', function() {
        var selectedValue = this.value;
        var filteredOptions = $options.filter('[val="' + selectedValue + '"]');

        $select2.html('<option value="">Select Size</option>');

        filteredOptions.each(function() {
            $select2.append($(this).clone());
        });
    }).trigger('change');
});
//

$(document).ready(function() {
    var $select1 = $('#division_id'),
        $select2 = $('#post_id'),
        $options = $select2.find('option');

    $select1.on('change', function() {
        var selectedValue = this.value;
        var filteredOptions = $options.filter('[val="' + selectedValue + '"]');

        $select2.empty();

        $select2.append('<option value="">Select Post</option>');

        // Append filtered options to the second dropdown
        filteredOptions.each(function() {
            $select2.append($(this).clone());
        });
    }).trigger('change');
});
//


jQuery(document).ready(function () {

jQuery('#item_size').change(function () {
    let id = jQuery(this).val();
    console.log(id);
    jQuery.ajax({

        url:"{{ url('kitdis')}}",
        type:'post',
        data:'id='+id+
        '&_token={{ csrf_token()}}',
        success:function(result){
            console.log(id);
        }

    });

});
});



// jQuery('#item_name').change(function () {
//     let itemSize = jQuery(this).val();
//     console.log(itemSize);

//     jQuery.ajax({
//         url: "{{ url('kitdis') }}/" + itemSize, // Append itemSize to the URL
//         type: 'get', // Set the request type to GET
//         success: function(result) {
//             console.log(result); // Handle the successful response here
//         }
//     });
// });


jQuery('#item_size').change(function () {
    let id = jQuery(this).val();
    console.log(id);
    jQuery.ajax({
        url: "{{ url('kitdis') }}",
        type: 'post',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(result) {
            console.log(result);
        }
    });
});


    </script>


