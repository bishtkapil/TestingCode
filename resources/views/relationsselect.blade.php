<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<br />
         <div class="container box">
              <h3 align="center"> Dependent Dropdown in Laravel</h3><br />
                 <div class="form-group">
                  <select name="country" id="country" class="form-control input-lg dynamic" data-dependent="state">
                  <option value="">Select Country</option>
                  {{-- @foreach($country['state'] as $list)
                  <option value="">{{ $list['state']}}</option>
                  @endforeach --}}
                  @foreach($country as $list)
                  <option value="">{{ $list['country']}}</option>
                  @endforeach

                </select>
         </div>
    <br />

    <div class="form-group">
    <select name="state" id="state" class="form-control input-lg dynamic" data-dependent="city">
     <option value="">Select State</option>
    </select>
    </div>
   <br />

     <div class="form-group">
     <select name="city" id="city" class="form-control input-lg">
     <option value="">Select City</option>
    </select>
   </div>
   {{ csrf_field() }}
   <br />
   <br />
  </div>

</body>
</html>

<script>



</script>
