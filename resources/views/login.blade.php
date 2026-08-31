<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div style="max-width: 400px; margin: 50px auto;">
        <h1>Admin Login</h1>

        @if ($errors->any())
            <div>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div>
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div>
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    required
                >
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>