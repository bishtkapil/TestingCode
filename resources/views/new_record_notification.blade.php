<!-- resources/views/email_data.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Email Data</title>
</head>
<body>
    <h1>Email Data</h1>
    <p>Name: {{ $newRecord->name }}</p>
    <p>Course: {{ $newRecord->course }}</p>
    <p>Email: {{ $newRecord->email }}</p>
    <p>Phone: {{ $newRecord->phone }}</p>
</body>
</html>
