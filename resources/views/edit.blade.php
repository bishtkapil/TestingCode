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
    
<div class="container mt-5 top">
@if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container card p-5">
            <form action="{{ url('/update/'.$data[0]->id )}}" method="post">  
                @csrf 
                <div class="modal-body">
                    <div class="form-group">
                    <label for="usr">Name:</label>
                    <input type="text" class="form-control name" id="name" name="name" value="{{ $data[0]->name}}">
                </div>
                <div class="form-group">
                    <label for="usr">Course:</label>
                    <input type="text" class="form-control course" id="course" name="course" value="{{ $data[0]->course}}">
                 </div>
            
                <div class="form-group">
                    <label for="usr">Email:</label>
                    <input type="text" class="form-control email" id="email" name="email" value="{{ $data[0]->email}}">
                </div>
                <div class="form-group">
                    <label for="usr">Phone number:</label>
                    <input type="text" class="form-control phone" id="phone" name="phone" value="{{ $data[0]->phone}}">
                </div>
                </div>
            <div class="modal-footer">
                <a href="{{ url('/testingform') }}"><button type="button" class="btn btn-danger">Back</button></a>
                <button type="submit" class="btn btn-primary add" id="saveData">Save</button>
                </div>
            </form>
    </div>
</div>

</body>
</html>