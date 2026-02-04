<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

@if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
@endif

<form method="POST" action="/login">
    @csrf

    <label>Role</label><br>
    <select name="role">
        <option value="admin">Admin</option>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
    </select>
    <br><br>

    <label>Username / NIS / Kode Guru</label><br>
    <input type="text" name="username">
    <br><br>

    <label>Password</label><br>
    <input type="password" name="password">
    <br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
