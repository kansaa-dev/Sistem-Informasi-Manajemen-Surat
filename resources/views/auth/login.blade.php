
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIM Surat</title>
</head>
<body>

    <h1>Login SIM-Surat</h1>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <p>
            <label>Email:</label>
        </p>
        <p>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </p>

        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <p>
            <label>Password:</label>
        </p>
        <p>
            <input
                type="password"
                name="password"
                required
            >
        </p>

        @error('password')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <button type="submit">Masuk</button>

    </form>

</body>
</html>
