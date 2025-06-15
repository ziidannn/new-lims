<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - DIL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(-45deg, #A4DD00, #ffffff, #e0e0e0, #A4DD00);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25),
                        0 10px 10px rgba(0,0,0,0.22);
            position: relative;
            overflow: hidden;
            width: 800px;
            max-width: 100%;
            min-height: 500px;
            display: flex;
        }

        .form-container {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container h1 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #222;
        }

        .form-container input {
            background-color: #f0f0f0;
            border: none;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 5px;
        }

        .form-container button {
            border-radius: 20px;
            border: none;
            background-color: #B6F500;
            color: #000;
            font-size: 14px;
            font-weight: bold;
            padding: 12px 45px;
            margin-top: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-container button:hover {
            background-color: #a0dc00;
        }

        .form-container .social-container {
            margin: 20px 0;
        }

        .form-container .social-container a {
            border: 1px solid #A4DD00;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
            color: #000;
            text-decoration: none;
        }

        .form-container a {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
            text-decoration: none;
        }

        .overlay-container {
            background: #A4DD00;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            flex-direction: column;
            text-align: center;
            padding: 40px;
        }

        .overlay-container h1 {
            font-size: 26px;
            font-weight: bold;
        }

        .overlay-container p {
            font-size: 15px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .ghost {
            background-color: transparent;
            border: 2px solid #000;
            padding: 10px 25px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            color: #000;
        }

        .ghost:hover {
            background-color: #000;
            color: #fff;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: -5px;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
                min-height: auto;
            }

            .overlay-container {
                padding: 30px 20px;
            }
        }

        .dot {
            height: 14px;
            width: 14px;
            border-radius: 50%;
            display: inline-block;
            margin: 0 6px;
        }

        .red {
            background-color: #ff4d4d;
        }

        .yellow {
            background-color: #ffcc00;
        }

        .green {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Sign In</h1>
            <div class="social-container">
                <span class="dot red"></span>
                <span class="dot yellow"></span>
                <span class="dot green"></span>
            </div>
            <span>or use your account</span>

            <input type="text" name="login_account" placeholder="Email or Username" value="{{ old('login_account') }}" />
            @if($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
            @if($errors->has('username'))
                <div class="error">{{ $errors->first('username') }}</div>
            @endif

            <input type="password" name="password" placeholder="Password" />
            @if($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif

            <a href="{{ route('password.request') }}">Forgot your password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>

    <div class="overlay-container">
        <h1>Welcome to DIL</h1>
        <p>Enter your credentials to access your dashboard</p>
    </div>
</div>

</body>
</html>
