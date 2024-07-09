<form method="POST" action="/login">
    <input type="text" name="email" placeholder="Email">
    <p>{{ $errors['email'] }}</p>
    <input type="password" name="password" placeholder="Password">
    <p>{{ $errors['password'] }}</p>
    <button type="submit">Login</button>
</form>