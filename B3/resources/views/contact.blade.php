<!DOCTYPE html>
<html>
<head>
    <title>Contact</title>
</head>
<body>

<h2>Contact Form</h2>

<form method="POST" action="{{ route('contact.submit') }}">
    @csrf

    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <button type="submit">Send</button>
</form>

</body>
</html>
