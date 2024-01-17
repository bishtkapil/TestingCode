<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
    <form class="form-inline" id="form">
        <div class="form-group mx-sm-3 mb-2">
          <label for="inputPassword2" class="sr-only">Password</label>
          <input type="text" class="form-control" id="inputvalue" placeholder="">
        </div>
        <button type="button" class="btn btn-primary mb-2" id="add">Add Button</button>
      </form>
      <div class="inputfield"> </div>

      <table class="table display" id="item">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
    </div>

</body>
</html>

<script>


// $(document).ready(function (){
//     $('#add').click( function() {
//         var inputvalue = $('#inputvalue').val();
//         console.log(inputvalue);

//         $('.inputfield').append('<div class="item">  '+inputvalue+' <span class="del"> X</span></div>')

//         $(document).on('click','.item',remove);

//     });
// });

// function remove(){

//     $(this).remove();
// }

$(document).ready(function (){
    $('#add').click( function() {
        var inputvalue = $('#inputvalue').val();
        var row = '<tr>' +
            '<td>' + inputvalue + '</td>' +
            '<td>' +'<button type="button" onclick="edit(this)">  edit   </button>' +'</td>' +
            '<td>' +'<button type="button" onclick="deleterow(this)">  delete   </button>' +'</td>' +
            '</tr>';

    $('#item').append(row);
    $('#form')[0].reset();

    });
});

function edit(button){

    var row = $(button).closest('tr');
    // console.log(row);

    var name = row.find('td:eq(0)').text();

    $('#inputvalue').val(name);
    row.remove();


}
function deleterow(button){

    $(button).closest('tr').remove();
}
</script>
