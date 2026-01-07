<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Information</title>
</head>
<body>

    @if($user)
        <h1>Information</h1>
        <p><strong>ID:</strong> {{ $user['id'] }}</p>
        <p><strong>Tên:</strong> {{ $user['name'] }}</p>
        <p><strong>Giới tính:</strong> {{ $user['gender'] }}</p>
    @else
        <h1>Người dùng không tồn tại</h1>
    @endif

</body>
</html>
