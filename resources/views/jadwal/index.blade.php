@extends('layouts.app')

@section('title','Jadwal Petugas')

@section('css')

<style>



.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.page-title h2{
    font-size:30px;
    color:#1b5e20;
    margin:0;
}

.page-title p{
    color:#777;
    margin-top:6px;
}



.btn-add{
    background:#1b5e20;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:600;
}

.btn-add:hover{
    background:#14501b;
}

.btn-secondary{
    background:#e8f5e9;
    color:#1b5e20;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:600;
}

.btn-secondary:hover{
    background:#1b5e20;
    color:white;
}




.jadwal-filter{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    gap:20px;
}

.filter-form{
    display:flex;
    align-items:center;
    gap:10px;
}

.filter-form label{
    color:#1b5e20;
}

.filter-form input{
    height:45px;
    border:1px solid #ddd;
    border-radius:10px;
    padding:0 12px;
    font-size:15px;
}

.filter-form button{
    height:45px;
    background:#1b5e20;
    color:white;
    border:none;
    padding:0 20px;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
}

.filter-actions{
    display:flex;
    gap:10px;
}




.summary{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

.summary-card{
    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.summary-card h4{
    margin:0;
    color:#666;
    font-size:15px;
}

.summary-card h2{
    margin-top:10px;
    color:#1b5e20;
    font-size:32px;
}




.table-card{
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#1b5e20;
    color:white;
}

th{
    padding:15px;
    text-align:center;
    white-space:nowrap;
}

td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
    white-space:nowrap;
}

tbody tr:hover{
    background:#f5fff5;
}




.aman{
    background:#e8f5e9;
    color:#2e7d32;
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
}

.kurang{
    background:#ffebee;
    color:#c62828;
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
}




.btn-edit{
    background:#e8f5e9;
    color:#1b5e20;
    padding:6px 12px;
    border-radius:20px;
    text-decoration:none;
    font-weight:600;
}

.btn-edit:hover{
    background:#1b5e20;
    color:white;
}




.shift-info{
    margin-top:30px;
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.shift-title{
    font-size:18px;
    font-weight:700;
    color:#1b5e20;
    margin-bottom:20px;
}

.shift-grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:15px;
}

.shift-card{
    background:#f8faf8;
    border:1px solid #e1e5e1;
    border-radius:12px;
    padding:15px;
    text-align:center;
}

.badge-shift{
    display:inline-block;
    background:#1b5e20;
    color:white;
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
    margin-bottom:8px;
}

.badge-off{
    display:inline-block;
    background:#ffebee;
    color:#c62828;
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
    margin-bottom:8px;
}

.shift-card small{
    display:block;
    color:#6b7280;
    font-size:13px;
}




@media(max-width:1000px){

    .shift-grid{
        grid-template-columns:repeat(3,1fr);
    }

}

@media(max-width:700px){

    .page-header,
    .jadwal-filter{
        flex-direction:column;
        align-items:flex-start;
    }

    .summary{
        grid-template-columns:1fr;
    }

    .filter-actions{
        width:100%;
    }

    .shift-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

</style>

@endsection


@section('content')




<div class="page-header">

    <div class="page-title">

        <h2>Jadwal Petugas</h2>

        <p>
            Kelola jadwal kerja petugas laboratorium berdasarkan periode.
        </p>

    </div>

</div>




<div class="jadwal-filter">

    <form
        method="GET"
        action="/jadwal"
        class="filter-form"
    >

        <label>
            <b>Periode</b>
        </label>

        <input
            type="week"
            name="periode"
            value="{{ $periode }}"
        >

        <button type="submit">
            Tampilkan
        </button>

    </form>


    <div class="filter-actions">

        <a
            href="/jadwal/cetak/{{ $periode }}"
            class="btn-secondary"
        >

            <i class="fa-solid fa-print"></i>

            Cetak Jadwal

        </a>


        @if(session('role') == 'Koordinator Laboratorium')

            <a
                href="/jadwal/create?periode={{ $periode }}"
                class="btn-add"
            >

                <i class="fa-solid fa-plus"></i>

                Tambah Jadwal

            </a>

        @endif

    </div>

</div>



<div class="summary">

    <div class="summary-card">

        <h4>Total Petugas</h4>

        <h2>
            {{ $totalPetugas }}
        </h2>

    </div>


    <div class="summary-card">

        <h4>Kurang 48 Jam</h4>

        <h2>
            {{ $kurangJam ?? 0 }}
        </h2>

    </div>


    <div class="summary-card">

        <h4>Sudah 48 Jam</h4>

        <h2>
            {{ $cukupJam ?? 0 }}
        </h2>

    </div>

</div>




<div class="table-card">

<table>

    <thead>

        <tr>

            <th>Petugas</th>

            <th>Senin</th>

            <th>Selasa</th>

            <th>Rabu</th>

            <th>Kamis</th>

            <th>Jumat</th>

            <th>Sabtu</th>

            <th>Minggu</th>

            <th>Total Jam</th>

            @if(session('role') == 'Koordinator Laboratorium')

                <th>Aksi</th>

            @endif

        </tr>

    </thead>


    <tbody>

        @forelse($jadwal as $data)

        <tr>

            <td>
                <b>{{ $data['nama'] }}</b>
            </td>


            <td>
                {{ $data['Senin'] }}
            </td>


            <td>
                {{ $data['Selasa'] }}
            </td>


            <td>
                {{ $data['Rabu'] }}
            </td>


            <td>
                {{ $data['Kamis'] }}
            </td>


            <td>
                {{ $data['Jumat'] }}
            </td>


            <td>
                {{ $data['Sabtu'] }}
            </td>


            <td>
                {{ $data['Minggu'] }}
            </td>


            <td>

                @if($data['total_jam'] >= 48)

                    <span class="aman">
                        {{ $data['total_jam'] }} Jam
                    </span>

                @else

                    <span class="kurang">
                        {{ $data['total_jam'] }} Jam
                    </span>

                @endif

            </td>


            @if(session('role') == 'Koordinator Laboratorium')

            <td>

                <a
                    href="/jadwal/{{ $data['id_petugas'] }}/{{ $periode }}/edit"
                    class="btn-edit"
                >

                    Edit

                </a>

            </td>

            @endif

        </tr>

        @empty

        <tr>

            <td
                colspan="{{ session('role') == 'Koordinator Laboratorium' ? 10 : 9 }}"
                style="text-align:center;padding:30px;"
            >

                Belum ada data jadwal untuk periode ini.

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>



<div class="shift-info">

    <div class="shift-title">

        <i class="fa-solid fa-circle-info"></i>

        Keterangan Shift

    </div>


    <div class="shift-grid">


        <div class="shift-card">

            <span class="badge-shift">
                Pagi
            </span>

            <small>
                07.00 - 15.00
            </small>

        </div>


        <div class="shift-card">

            <span class="badge-shift">
                Siang
            </span>

            <small>
                15.00 - 23.00
            </small>

        </div>


        <div class="shift-card">

            <span class="badge-shift">
                Malam
            </span>

            <small>
                23.00 - 07.00
            </small>

        </div>


        <div class="shift-card">

            <span class="badge-shift">
                MD9
            </span>

            <small>
                09.00 - 15.00
            </small>

        </div>


        <div class="shift-card">

            <span class="badge-shift">
                MD10
            </span>

            <small>
                10.00 - 15.00
            </small>

        </div>


        <div class="shift-card">

            <span class="badge-off">
                OFF
            </span>

            <small>
                Libur
            </small>

        </div>


    </div>

</div>


@endsection