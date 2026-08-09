<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','Sistem Inventory Laboratorium')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Poppins',sans-serif;

    background:#f4f7f9;

}

.wrapper{

    display:flex;

    min-height:100vh;

}

.sidebar{

    width:300px;

    background:linear-gradient(180deg,#166b2d,#0d5b24);

    display:flex;

    flex-direction:column;

    color:white;

}

.brand{

    padding:30px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    border-bottom:1px solid rgba(255,255,255,.15);

}

.brand h2{

    font-size:24px;

    line-height:1.5;

    font-weight:600;

}

.brand i{

    font-size:55px;

}

.menu{

    padding:25px 15px;

    flex:1;

}

.menu a{

    display:flex;

    align-items:center;

    gap:15px;

    text-decoration:none;

    color:white;

    padding:16px 18px;

    border-radius:14px;

    margin-bottom:12px;

    transition:.25s;

    font-size:17px;

    font-weight:500;

}

.menu a i{

    width:25px;

    font-size:18px;

}

.menu a:hover{

    background:white;

    color:#166b2d;

}

.menu a.active{

    background:white;

    color:#166b2d;

    font-weight:600;

}

.logout{

    margin-top:auto;

    padding-top:20px;

    border-top:1px solid rgba(255,255,255,.15);

}

.logout a{

    color:white;

}

.logout a:hover{

    color:#166b2d;

}

.content{

    flex:1;

    background:#f7f8fa;

    padding:35px;

}

.top-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.top-header h1{

    color:#1b5e20;

    font-size:28px;

    font-weight:700;

}

.profile{

    display:flex;

    align-items:center;

    gap:15px;

}

.avatar{

    width:48px;

    height:48px;

    border-radius:50%;

    background:#166b2d;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:bold;

    font-size:18px;

}

.profile-info{

    display:flex;

    flex-direction:column;

}

.profile-info strong{

    color:#333;

}

.profile-info span{

    color:#777;

    font-size:13px;

}

.header-line{

    border:none;

    height:2px;

    background:#dbe5dc;

    margin:25px 0 35px;

}

.card{

    background:white;

    border-radius:16px;

    box-shadow:0 4px 12px rgba(0,0,0,.08);

}

.akun-btn{
    display:flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    background:#166b2d;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    transition:.3s;
}

.akun-btn:hover{
    background:#0d5b24;
}
</style>

@yield('css')

</head>

<body>

<div class="wrapper">

    <div class="sidebar">

        <div class="brand">

            <h2>
                Laboratorium
                <br>
                RS Ridhoka Salma
            </h2>

            <i class="fa-solid fa-flask-vial"></i>

        </div>

        <div class="menu">

            <a href="/dashboard"
            class="{{ request()->is('dashboard') ? 'active' : '' }}">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>

            @if(session('role') == 'Koordinator Laboratorium' || session('role') == 'Petugas Laboratorium')

            <a href="/pemeriksaan"
            class="{{ request()->is('pemeriksaan*') ? 'active' : '' }}">

                <i class="fa-solid fa-vials"></i>

                Pencatatan Aktivitas

            </a>

            @endif

            @if(session('role') == 'Koordinator Laboratorium' || session('role') == 'Petugas Laboratorium' || session('role') == 'Logistik')

            <a href="/form_order"
            class="{{ request()->is('form_order*') ? 'active' : '' }}">

                <i class="fa-solid fa-cart-shopping"></i>

                Pengadaan

            </a>

            @endif

            @if(session('role') == 'Koordinator Laboratorium' || session('role') == 'Petugas Laboratorium')

            <a href="/jadwal"
            class="{{ request()->is('jadwal*') ? 'active' : '' }}">

                <i class="fa-solid fa-calendar-days"></i>

                Jadwal Petugas

            </a>

            @endif

            @if(session('role') == 'Koordinator Laboratorium')

            <a href="/laporan"
            class="{{ request()->is('laporan*') ? 'active' : '' }}">

                <i class="fa-solid fa-chart-column"></i>

                Laporan Bulanan

            </a>

            @endif

            <div class="logout">

                <a href="/logout">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="content">

        <div class="top-header">

            <div>

                <h1>Sistem Inventory Laboratorium</h1>

                <p style="color:#777;margin-top:6px;font-size:15px;">
                Sistem Inventory Laboratorium RS Ridhoka Salma
                </p>

            </div>

            <div class="profile">

            <a href="/akun" class="akun-btn">
                <i class="fa-solid fa-user"></i>
                Akun Saya
            </a>

            <div class="avatar">
                {{ strtoupper(substr(session('role'),0,1)) }}
            </div>

            <div class="profile-info">
                <strong>{{ session('role') }}</strong>
                <span>{{ now()->format('d F Y') }}</span>
            </div>

            

        </div>
        
        </div>

        <hr class="header-line">

        @yield('content')

    </div>

</div>

</body>
</html>