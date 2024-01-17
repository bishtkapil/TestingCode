
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
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
<body>
    <div class="container card p-5 top">
        <form id="dataForm">

            <div class="modal-body">
                <div class="form-group">
                <label for="usr">Name:</label>
                <input type="text" class="form-control name" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="usr">Email:</label>
                <input type="text" class="form-control email" id="email" name="email">
            </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary add" id="saveData" onclick="submitForm()">Save</button>
            </div>
        </form>
</div>

<div class="container card p-5 top">


      <table class="table" id="dataTable">
        <thead class="thead-light">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

    <button type="button" onclick="saveToDatabase()">Save to Database</button>
</div>
    <script>
        var formData = [];

        function submitForm() {
            var name = $('#name').val();
            var email = $('#email').val();
            formData.push({ name: name, email: email });
            var row = '<tr>' +
                          '<td>' + name + '</td>' +
                          '<td>' + email + '</td>' +
                          '<td>' +
                              '<button type="button" onclick="editRow(this)">Edit</button>' +
                              '<button type="button" onclick="deleteRow(this)">Delete</button>' +
                          '</td>' +
                      '</tr>';

            $('#dataTable tbody').append(row);
            $('#dataForm')[0].reset();
        }

            // Function to edit a row
            function editRow(button) {
            // Get the selected row
            var row = $(button).closest('tr');

            // Get data from the row
            var name = row.find('td:eq(0)').text();
            var email = row.find('td:eq(1)').text();

            // Set data in the form
            $('#name').val(name);
            $('#email').val(email);

            // Remove the edited row from the table
            row.remove();
        }

        // Function to delete a row
        function deleteRow(button) {
            // Get the selected row and remove it
            $(button).closest('tr').remove();
        }


        function saveToDatabase() {
            $.ajax({
                type: 'POST',
                url: '/save-to-database',
                data: { formData: formData, _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    console.log(response.message);
                    $('#dataTable tbody').empty();
                    formData = [];
                },


                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
    </script>

</body>
</html>
