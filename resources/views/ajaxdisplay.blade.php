<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
    /* @import 'datatables.net-buttons-dt/css/buttons.dataTables.css'; */

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
    .hidden {
            display: none;
        }

        tr.india-row {
            background-color: red;
        }

        tr.us-row {
            background-color: blue;
        }

</style>
</head>
<body>

    <div class="container top">
        <h2>Item Data Table</h2>
        <form id="filter">
            @csrf
            <div class="form-group row">
                <div class="col-md-3">

                    <div class="row">
                        <label class="col-md-3 col-form-label block">Country</label>
                        <input type="text" class="form-control name" id="filterInput" name="filterInput" placeholder="Enter filter text">
                    </div>
                </div>
                <div class="col-md-3" style="margin-left: 20px;">
                    <div class="row">
                        <label class="col-md-3 col-form-label block">Email</label>
                        <input type="text" class="form-control name" id="filteremail" name="filteremail" placeholder="Enter filter text">
                    </div>
                </div>
                <div class="col-md-3" style="margin-left: 20px;">
                    <div class="row">
                        <label class="col-md-3 col-form-label block">Name</label>
                        <input type="text" class="form-control name" id="filtername" name="filtername" placeholder="Enter filter text">
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="row">
                        <label class="col-md-3 col-form-label block">country</label>
                        <select name="country" class=" country" id="country">
                            <option value=""> Filter By Country </option>
                            @foreach($country as $d)
                            <option value="{{ $d->country }}"> {{ $d->country}} </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

            </div><br>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button class="btn btn-success rounded-border m-r-25" id="applyFilter" type="button">Apply Filter</button>
                    <button type="button" class="btn btn-danger rounded-border m-r-25" id="resetFilterBtn" name ="resetFilterBtn">Reset Filter</button>
                </div>
            </div>

        </form>
        <br>
        <table class="table display" id="item-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Action</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
        </table>
    </div>

</div>
    <!-- Add this HTML code in your document for the modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Enter search value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="searchInput" placeholder="Enter search value" autocomplete="off">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!-- Add these lines within the <head> section -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
<!-- pdfmake -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>




<script>



$(document).ready(function () {

        var table = $('#item-table').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        processing: true,
        serverSide: true,
        searching: true,
        // dom: 'Bfrtip',
        dom: `
                        <'row'
                            <'col-sm-12 col-md-6'  l>
                        >
                        Bfrtip
                    `,
        buttons: [
            {
            extend: 'pdf',
            text: 'Export to PDF',
            title: 'Ajax DataTable',
            filename: 'pdf_name',

        },
            {
                extend: 'excel',
                text: 'Export to Excel',
                title: 'Your Excel Title',
                filename: 'your_file_name',
            },
            {
                extend: 'csv',
                text: 'Export to CSV',
                title: 'Your CSV Title',
                filename: 'your_file_name',
            },


        ],
            ajax: "{{ url('getDatas') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name',
                name: 'name', },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'country', name: 'country' },
                { data: 'action', name: 'action', orderable: false, searchable: false }, // New column for action buttons
                // Add more columns as needed

                // {
                //     data: null,
                //     orderable: false,
                //     searchable: false,
                //     render: function(data, type, row) {
                //         // Action buttons or links go here
                // return ' <button id="received" type="button" class="btn btn-danger bg-danger waves-effect waves-light btn-outline-success badge-button" data-target="customBadge2"><a href="due/' + row.id + '/' + row.item_id + '">Procedure</button></a>';
                //         return '<a href="/edit/' + row.id + '">Edit</a>' +
                //                ' | ' +
                //                '<a href="/delete/' + row.id + '">Delete</a>';
                //     }
                // },

            ],

            createdRow: function (row, data, dataIndex) {
            var country = data.country.toLowerCase();
            if (country === 'india') {
                $(row).addClass('india-row');
            } else if (country === 'us') {
                $(row).addClass('us-row');
            }
        },
    // });


        });
        $('#item-table thead th').each(function () {
        $(this).on('click', function () {
            var columnIndex = table.column($(this)).index();
            var columnName = table.column(columnIndex).header().innerHTML.trim();
            var searchText = table.column(columnIndex).search();

            // Show the modal
            $('#searchModal').modal('show');

            // Set the modal title
            $('#searchModalLabel').text('Enter search for ' + columnName);

            // Set the current search value in the modal input
            $('#searchInput').val(searchText);

            // Clear the input field on focus
            $('#searchInput').on('focus', function () {
                $(this).val('');
            });

            // Handle the search button click
            $('#searchBtn').on('click', function () {
                var newSearch = $('#searchInput').val();
                $('#searchModal').modal('hide');

                if (newSearch !== null) {
                    var searchRegex = '\\b' + newSearch + '\\b';
                    table.column(columnIndex).search(searchRegex, true, false).draw();
                }

                // Remove the event listener to prevent multiple bindings
                $('#searchBtn').off('click');
            });
        });
    });
    });


    // for edit form code only
    $(document).ready(function () {
        $('#item-table').on('click', '.edit', function(){
        var itemId = $(this).data('id');
        console.log(itemId);
        var url = "{{ url('edit', ['id' => '']) }}/"+itemId;
                document.location.href=url;


        });

});


    $(document).ready(() => {

        $('#item-table').on('click', '.delete', (e) => {

                        let itemsid = $(e.currentTarget).data('id');


                        $.ajax({
                            type: 'post',
                            url: '{{ url('remove')}}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: itemsid
                            },
                            success: (res) => {
                                    swal({
                                        title: 'Success',
                                        text: 'Submitted Successfully!',
                                        type: 'success'
                                   }). then(function (isConfirm) {
                           if (isConfirm == true) {
                            document.location.href="{{ url('ajaxdisplay') }}";
                           }
                    });

                            }
                        });
            });
          });



// for filter table code only

    $(document).ready(() => {
    $('#applyFilter').on('click', () => {
                 var yourVariable = $('#filterInput').val();
                 var filteremail = $('#filteremail').val();
                 var filtername = $('#filtername').val();
                //  console.log(yourVariable);
                 $('#item-table').DataTable().destroy();
                fetch_data(yourVariable,filteremail,filtername);

            });

        });


    // reset input field

     $(document).ready(function() {
      var table = $('#item-table').DataTable();
      $('#resetFilterBtn').on('click', function() {
        // table.page.len(1000);
        // table.search('').draw();
        // table.page('first').draw();
        document.getElementById("filter").reset();
        location.reload();

      });
    });


function fetch_data(yourVariable,filteremail,filtername){

    var table = $('#item-table').DataTable({
                 processing: true,
                serverSide: false,
                searching: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                 extend: 'pdf',
                text: 'Export to PDF',
                title: 'Ajax DataTable',
                filename: 'pdf_name',

                },
                             ],
                ajax: {
                        type: 'post',
                        url:"{{ url('getfilterData') }}",
                        data: {_token: '{{ csrf_token() }}',yourVariable:yourVariable,filteremail:filteremail,filtername:filtername}
                    },

                    columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'country', name: 'country' },
                { data: 'action', name: 'action', orderable: false, searchable: false },

                    ],

            });

        }

        function changeLocationType() {
            var locationType = document.getElementById("locationType").value;

            // Hide all input fields
            document.getElementById("cityInput").classList.add("hidden");
            document.getElementById("countryInput").classList.add("hidden");
            document.getElementById("stateInput").classList.add("hidden");

            // Show the selected input field
            document.getElementById(locationType + "Input").classList.remove("hidden");
        }
    </script>
