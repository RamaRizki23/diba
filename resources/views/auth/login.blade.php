<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DIBA</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f7f6;
        }

        .login-container {
            width: 900px;
            min-height: 520px;
            display: flex;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-left {
            width: 50%;
            background: #198754;
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-left h1 {
            font-size: 42px;
            margin-bottom: 15px;
        }

        .login-left p {
            font-size: 16px;
            line-height: 1.7;
            opacity: 0.9;
        }

        .login-right {
            width: 50%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 30px;
            color: #222;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            font-size: 15px;
        }

        .form-group input:focus {
            border-color: #198754;
        }

        .login-button {
            <title>Masuk | DIBA Console</title>
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #198754;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .login-button:hover {
            background: #157347;
        }

        .error {
            background: #f8d7da;
                :root{--ink:#152528;--muted:#718083;--teal:#087f75;--lime:#c7ee73;--line:#dce8e4}*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;background:#edf5f1;color:var(--ink);font-family:'DM Sans',sans-serif}.login{width:min(930px,calc(100% - 30px));min-height:570px;display:grid;grid-template-columns:43% 57%;background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 20px 60px #173d3620}.intro{padding:52px 44px;background:#103b38;color:#e8f4df;position:relative;overflow:hidden}.intro:after{content:'';position:absolute;width:220px;height:220px;border:38px solid #c7ee7330;border-radius:50%;right:-85px;bottom:-75px}.mark{display:inline-grid;place-items:center;width:40px;height:40px;border-radius:12px 12px 4px 12px;background:var(--lime);color:var(--ink);font:700 22px 'Space Grotesk'}.intro h1{font:700 46px 'Space Grotesk';margin:75px 0 14px;letter-spacing:-1px}.intro p{max-width:270px;line-height:1.7;color:#b9d4c8;font-size:15px}.intro-note{position:absolute;bottom:42px;color:#8eafa4;font-size:12px}.form{padding:58px 64px;display:flex;flex-direction:column;justify-content:center}.eyebrow{color:var(--teal);font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase}.form h2{font:700 32px 'Space Grotesk';margin:9px 0}.subtitle{color:var(--muted);margin:0 0 30px}.field{margin-bottom:19px}.field label{display:block;font-size:12px;font-weight:700;margin-bottom:8px}.field input{width:100%;padding:13px;border:1px solid var(--line);border-radius:8px;font:14px 'DM Sans';outline:0}.field input:focus{border-color:var(--teal);box-shadow:0 0 0 3px #dff2ee}.remember{display:flex;align-items:center;gap:8px;color:var(--muted);font-size:12px;margin:4px 0 24px}.remember input{accent-color:var(--teal)}button{width:100%;padding:14px;border:0;border-radius:8px;background:var(--teal);color:#fff;font:700 14px 'DM Sans';cursor:pointer}button:hover{background:#06675f}.error{background:#fce9e7;color:#9d4038;padding:12px;border-radius:8px;margin-bottom:18px;font-size:13px}@media(max-width:650px){.login{display:block}.intro{padding:30px;height:210px}.intro h1{margin:25px 0 5px;font-size:34px}.intro p{margin:0}.intro-note{display:none}.form{padding:35px 28px}}
                width: 90%;
                flex-direction: column;
            }

            .login-left,
            .login-right {
                width: 100%;
            }

            .login-left {
                padding: 40px;
            }

            .login-right {
                padding: 40px;
            }
                    <div class="error">{{ $errors->first() }}</div>

<body>

<div class="login-container">

    <div class="login-left">
        <h1>DIBA</h1>
        <p>
            Selamat datang di sistem DIBA.
            Silakan masuk untuk mengakses dashboard
            dan mengelola data.
        </p>
    </div>

    <div class="login-right">

        <h2>Login</h2>
        <p class="subtitle">Masuk ke akun DIBA kamu</p>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>