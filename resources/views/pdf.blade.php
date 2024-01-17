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
</style>
</head>
<body>

    <div class="container top">
        <h2>Item Data Table</h2>

        <form id="filter-form">
            <div class="form-group">
                <label for="category">Filter by Category:</label>
                <select class="form-control" name="category" id="category">
                    <option value="">All Categories</option>
                    @foreach($country as $d)
                    <option value="{{ $d->country }}"> {{ $d->country}} </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <br>

        <table class="table" id="item-table">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Name</th>
                    <th>Course</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Action</th>A
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal for Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your edit form goes here -->
                    <form id="editForm">
                        <!-- Edit form fields go here -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<!-- Add these lines within the <head> section -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Include necessary DataTables libraries -->

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<script>



$(document).ready(function () {
        // Initialize DataTable
        var table = $('#item-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getData') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'country', name: 'country' },
                { data: 'action', name: 'action', orderable: false, searchable: false }, // New column for action buttons
                // Add more columns as needed
            ]
        });


        // Handle form submission for filtering
        $('#filter-form').on('submit', function (e) {
        e.preventDefault();
        table.ajax.url("{{ url('getData') }}?category=" + $('#category').val()).load();
    });



         $('#category').on('change', function () {
            var selectedCategory = $(this).val();
            console.log(selectedCategory);
            var table = $('#item-table').find('tbody');
            // Show or hide rows based on the selected category
          table.find('tr').each(function () {
                var rowText = $(this).text();
                console.log(rowText);
                $(this).toggle(rowText.indexOf(selectedCategory) > -1);


          });
        });

    });


    $(document).ready(function () {
        // Edit and Delete button logic
        $('#item-table').on('click', '.edit', function(){
        var itemId = $(this).data('id');
        console.log(itemId);
        // You can use the itemId to fetch the item details from the server or open your edit form here
        // For demonstration purposes, let's open the modal
        // $('#editModal').modal('show');
        var url = "{{ url('edit', ['id' => '']) }}/"+itemId;
                document.location.href=url;


        });



    $('#item-table').on('click', '.delete', (e) => {

        let itemsid = $(e.currentTarget).data('id');
                        $.ajax({
                            method: 'POST',
                            url: '{{ url('remove') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: itemsid
                            },

                            success: (res) => {
                                let data = JSON.parse(res);
                                if(data.status == true){
                                    swal({
                                        title: 'Success',
                                        text: 'Item Deleted Successfully!',
                                        type: 'success'
                                    }, () => {
                                        location.reload();
                                    });
                                }
                            }
                        });


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



                    // jQuery('#createform')['0'].reset();



            });
          });


    </script>
