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
            <form action="{{ url('/formstore') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                    <label for="usr">Name:</label>
                    <input type="text" class="form-control name" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="usr">Course:</label>
                    <input type="text" class="form-control course" id="course" name="course">
                 </div>

                <div class="form-group">
                    <label for="usr">Email:</label>
                    <input type="text" class="form-control email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="usr">Country:</label>
                    <select name="country" class="form-control country" id="country">
                        <option> select </option>
                        @foreach($country as $d)
                        <option value="{{ $d->id }}"> {{ $d->country}} </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="usr">Phone number:</label>
                    <input type="text" class="form-control phone" id="phone" name="phone">
                </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">Close</button>
                <button type="submit" class="btn btn-primary add" id="saveData">Save</button>
                <a href="{{ url('/home')}}"><button type="button" class="btn btn-warning add">Home Page </a></button>
                </div>
            </form>
    </div>
</div>


{{-- <div class="container top">

<table class="table table-striped">
        <thead>
             <tr>
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($data as $d)
              <tr>
                <th>{{$d->name}}</th>
                <td>{{$d->course}}</td>
                <td>{{$d->email}}</td>
                <td>{{$d->phone}}</td>
                <td>
                <a href="{{ url('/edit/'.$d->id) }}"><button type="button" class="btn btn-primary add">Edit</button></a>
                <a href="{{ url('/delete/'.$d->id) }}"><button type="button" class="btn btn-danger">Delete</button></td></a>
    </tr>
   @endforeach
  </tbody>
</table>

    </div> --}}

<script>




</script>




{{-- kapl --}}







</body>
</html>
