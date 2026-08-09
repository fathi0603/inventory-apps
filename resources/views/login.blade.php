<!DOCTYPE html>
<html>
<head>
    <title>Login Inventory Laboratorium</title>
    <style>
        body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f5fff5;
    position:relative;
}

body::before{
    content:'';
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);

    width:500px;
    height:500px;

    background:url('/images/logo-rs.png') no-repeat center;
    background-size:contain;

    opacity:0.08;
    z-index:0;
}

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position:relative;
            z-index:1;
        }

        .login-box {
            width: 420px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .header {
            background: #1b5e20;
            color: white;
            text-align: center;
            padding: 28px 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 30px;
        }

        .header p {
            margin: 8px 0 0;
            font-size: 16px;
        }

        .form-box {
            padding: 35px;
        }

        .form-box h2 {
            text-align: center;
            color: #1b5e20;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-bottom: 18px;
            border: 1px solid #a5d6a7;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #1b5e20;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1b5e20;
        }

        .error {
            background: #ffcdd2;
            color: #b71c1c;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-box">
        <div class="header">
            <img src="/images/logo-rs.png" width="120">
            <h1>Laboratorium</h1>
            <p>RS Ridhoka Salma</p>
        </div>

        <div class="form-box">
            <h2>Login Sistem Inventory</h2>

            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            <form action="/login" method="POST">
                @csrf

                <input type="text" name="username" placeholder="Masukkan Username">

                <input type="password" name="password" placeholder="Masukkan Password">

                <button type="submit">Masuk</button>
            </form>

            <div class="footer">
                Inventory Reagen & BMHP Laboratorium

            </div>
        </div>
    </div>
</div>

</body>
</html>