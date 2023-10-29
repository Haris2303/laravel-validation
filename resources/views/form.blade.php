<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
</head>
<body>

@if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/form" method="POST">
    @csrf
    <label for="username">username : @error('username') {{ $message }} @enderror</label>
    <input type="text" id="username" name="username" value="{{ old('username') }}"> <br>
    <label for="password">Password : @error('password') {{ $message }} @enderror</label>
    <input type="text" id="password" name="password" value="{{ old('password') }}"> <br>
    <button type="submit">Login</button>
</form>

</body>
</html>
