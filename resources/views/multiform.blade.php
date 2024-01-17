<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <div class="container card p-5">
        <form action="{{ url('/multiplestore') }}" method="post" id="mainForm">
            @csrf
            <div class="modal-body" id="formContainer">
                <!-- Original Form -->
                <div class="form-group">
                    <label for="usr">Name:</label>
                    <input type="text" class="form-control name" name="name[]">
                </div>

                <div class="form-group">
                    <label for="usr">Course:</label>
                    <input type="text" class="form-control course" name="course[]">
                </div>

                <div class="form-group">
                    <label for="usr">Email:</label>
                    <input type="text" class="form-control email" name="email[]">
                </div>

                <div class="form-group">
                    <label for="usr">Country:</label>
                    <select name="country[]" class="form-control country">
                        <option>select</option>
                        @foreach($country as $d)
                        <option value="{{ $d->id }}"> {{ $d->country}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="usr">Phone number:</label>
                    <input type="text" class="form-control phone" name="phone[]">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary add" id="saveData">Save</button>
                <a href="{{ url('/home') }}" class="btn btn-warning">Home Page</a>
                <button type="button" class="btn btn-success" id="addForm">Add Form</button>
            </div>
        </form>
    </div>

</body>
</html>
<script>
  $(document).ready(function () {
            // Counter to track the number of forms
            var formCounter = 1;

            // Function to add a new form
            function addNewForm() {
                var newForm = $('#formContainer').clone();
                 // Reset values of all input fields inside the cloned form
                newForm.find(':input').val('');
                  // Assign a new ID to the cloned form container
                newForm.attr('id', 'formContainer' + formCounter);
                  // Assign a new ID to the "Save Data" button within the cloned form
                newForm.find('.add').attr('id', 'saveData' + formCounter);
                newForm.find('#addForm').remove(); // Remove the "Add Form" button from the cloned form
                newForm.append('<button type="button" class="btn btn-danger closeForm" onclick="closeForm(' + formCounter + ')">Close</button>');

                // Prepend the new form above the "Add Form" button
                $('#formContainer').before(newForm);
                formCounter++;
            }

            // Function to close a form
            window.closeForm = function (formNumber) {
                $('#formContainer' + formNumber).remove();
            };

            // Event listener for the "Add Form" button
            $('#addForm').click(function () {
                addNewForm();
            });
        });














</script>
