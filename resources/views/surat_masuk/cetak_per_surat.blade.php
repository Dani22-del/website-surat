<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Keluar {{ $surat->no_surat }}</title>
    <style>
        @page { margin: 2cm; }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
        }
        .kop {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop h2 {
            margin: 0;
            font-size: 16pt;
        }
        .kop p {
            margin: 2px 0;
            font-size: 10pt;
        }
        .header-surat {
            margin-bottom: 20px;
        }
        .header-surat p {
            margin: 4px 0;
        }
        .perihal {
            margin: 20px 0 10px;
            font-weight: bold;
            text-decoration: underline;
        }
        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 20px 0;
        }
        .isi {
            text-align: justify;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>

    

    {{-- Header Surat --}}
    <div class="header-surat">
        <p><strong>Nomor:</strong> {{ $surat->nomor_surat }}</p>
        <p><strong>Tanggal Diterima:</strong> {{ $surat->tanggal_surat }}</p>
        <p><strong>Pengirim:</strong> {{ $surat->tujuan }}</p>
        <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
        <p><strong>Penerima:</strong> {{ $surat->user->name }}</p>
        
    </div>

    {{-- Garis Pembatas --}}
    <hr>

    {{-- Isi Surat --}}
    <div class="isi">
        {!! nl2br(e($surat->isi)) !!}
    </div>
<script>
        window.print();
    </script>

</body>
</html>
