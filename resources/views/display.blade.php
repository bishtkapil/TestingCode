<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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


<div class="container top">
    <input type="text" id="filter-input" placeholder="Filter by Name">
    <select name="country" class=" country" id="country">
        <option value=""> Filter By Country </option>
        {{-- <option value=""> Select All </option> --}}
        @foreach($country as $d)
        <option value="{{ $d->country }}"> {{ $d->country}} </option>
        @endforeach
    </select>
<table id="items-table" class="table">
        <thead>
             <tr>
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Country</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be displayed here -->

        </tbody>

        <tr>
            <td colspan="3" class="table-footer">
              <div class="table-pagination">
                <button type="button" class="btn-tablepage jTablePagePrev">&laquo;</button>
                <ul class="pagination"></ul>
                <button type="button" class="btn-tablepage jTablePageNext">&raquo;</button>
              </div>
              <div class="table-filter ">
                <input class="search " placeholder="Search ">
              </div>

            </td>
          </tr>
</table>

    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Fetch data using Ajax
        $.ajax({
            url: '{{ url("/display") }}',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Handle the retrieved data
                displayItems(data);
                console.log(data);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // Function to display items in the table
        function displayItems(items) {
            var table = $('#items-table').find('tbody');
            table.empty();
console.log(items);
            $.each(items, function (index, item) {
                table.append('<tr>' +
                    '<td>' + item.id + '</td>' +
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.email + '</td>' +
                    '<td>' + item.phone + '</td>' +
                    '<td>' + item.country + '</td>' +

                    // Add more columns as needed
                    '<td>' +
                        '<button class="btn edit" data-id="'+item.id+'">Edit</button>' +
                        '<button class="btn delete" data-id="'+item.id+'">Delete</button>' +
                        '<button class="btn home">Home Page</button>' +
                        '</td>' +
                    '</tr>');
            });
        }

                // Filter items based on input
        //     $('#filter-input').on('input', function () {
        //     var filterValue = $(this).val().toLowerCase();
        //     var table = $('#items-table').find('tbody');

        //     // Filter rows
        //     table.find('tr').each(function () {
        //         var rowText = $(this).text().toLowerCase();
        //         $(this).toggle(rowText.indexOf(filterValue) > -1);
        //     });
        // });





        $("#filter-input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(value);
            $("#items-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            });



              // Filter select change
              $('#country').on('change', function () {
            var selectedCategory = $(this).val();
            console.log(selectedCategory);
            var table = $('#items-table').find('tbody');
            // Show or hide rows based on the selected category
          table.find('tr').each(function () {
                var rowText = $(this).text();
                // console.log(rowText);
                $(this).toggle(rowText.indexOf(selectedCategory) > -1);

            });
        });

    $(document).ready(function () {
        // Edit and Delete button logic
        $('#items-table tbody').on('click', '.edit', function () {
            var itemId = $(this).data('id');
            // Make an Ajax request to fetch item details or redirect to the edit page
            console.log(itemId);
            var url = "{{ url('edit', ['id' => '']) }}/"+itemId;
                document.location.href=url;
        });

        $('#items-table tbody').on('click', '.delete', function () {
            var itemId = $(this).data('id');
            // Make an Ajax request to delete the item
            console.log(itemId);
            var url = "{{ url('delete', ['id' => '']) }}/"+itemId;
                document.location.href=url;
        });


        $('#items-table tbody').on('click', '.home', function () {
            var url = "{{ url('home')}}";
                document.location.href=url;
        });



    });

});


</script>
