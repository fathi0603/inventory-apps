<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        Laporan Penggunaan Barang
    </title>

    <style>

        body{
            font-family:Arial, sans-serif;
            color:#222;
            margin:30px;
        }

        .header{
            text-align:center;
            margin-bottom:25px;
        }

        .header h2{
            margin:0;
            font-size:22px;
        }

        .header h3{
            margin:8px 0;
            font-size:18px;
        }

        .header p{
            margin:0;
            color:#555;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th{
            background:#1b5e20;
            color:white;
            border:1px solid #333;
            padding:10px;
        }

        td{
            border:1px solid #333;
            padding:10px;
            text-align:center;
        }

        .text-left{
            text-align:left;
        }

        .footer{
            margin-top:40px;
            text-align:right;
        }

        @media print{

            body{
                margin:15px;
            }

            .no-print{
                display:none;
            }

        }

    </style>

</head>

<body>


<div class="header">

    <h2>
        RS RIDHOKA SALMA
    </h2>

    <h3>
        LAPORAN PENGGUNAAN BARANG LABORATORIUM
    </h3>

    <p>
        Periode:
        {{ \Carbon\Carbon::parse($bulan.'-01')->translatedFormat('F Y') }}
    </p>

</div>


<table>

    <thead>

        <tr>

            <th>No</th>

            <th>Tanggal</th>

            <th>Nama Barang</th>

            <th>Jenis Barang</th>

            <th>Barang Keluar</th>

        </tr>

    </thead>


    <tbody>

    @php
        $nomor = 1;
    @endphp


    @foreach($barang as $item)

        @php

            $penggunaanBulan = $item->penggunaanBarang->filter(function($penggunaan) use ($bulan){

                if (!$penggunaan->pemeriksaan) {
                    return false;
                }

                return \Carbon\Carbon::parse(
                    $penggunaan->pemeriksaan->tanggal_pemeriksaan
                )->format('Y-m') == $bulan;

            });

        @endphp


        @forelse($penggunaanBulan as $penggunaan)

            <tr>

                <td>
                    {{ $nomor++ }}
                </td>

                <td>

                    {{ \Carbon\Carbon::parse(
                        $penggunaan->pemeriksaan->tanggal_pemeriksaan
                    )->format('d-m-Y') }}

                </td>

                <td class="text-left">
                    {{ $item->nama_barang }}
                </td>

                <td>
                    {{ $item->jenis_barang }}
                </td>

                <td>
                    {{ $penggunaan->jumlah_penggunaan }} pcs
                </td>

            </tr>

        @empty

            <tr>

                <td>
                    {{ $nomor++ }}
                </td>

                <td>
                    -
                </td>

                <td class="text-left">
                    {{ $item->nama_barang }}
                </td>

                <td>
                    {{ $item->jenis_barang }}
                </td>

                <td>
                    0 pcs
                </td>

            </tr>

        @endforelse

    @endforeach

    </tbody>

</table>


<div class="footer">

    Dicetak pada:
    {{ now()->format('d-m-Y H:i') }}

</div>


<script>

    window.onload = function(){

        window.print();

    };

</script>


</body>
</html>