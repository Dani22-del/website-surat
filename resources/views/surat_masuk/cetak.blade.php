<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 16px; /* Ukuran font lebih besar untuk keterbacaan */
        }
        h1 {
            text-align: center;
            font-size: 24px; /* Judul lebih menonjol */
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        td {
            font-size: 14px; /* Font sel tabel lebih besar */
        }
        /* Penyesuaian lebar kolom agar proporsional */
        th:nth-child(1), td:nth-child(1) { width: 5%; }
        th:nth-child(2), td:nth-child(2) { width: 15%; }
        th:nth-child(3), td:nth-child(3) { width: 20%; }
        th:nth-child(4), td:nth-child(4) { width: 30%; }
        th:nth-child(5), td:nth-child(5) { width: 30%; }
    </style>
</head>
<body>
    <h1>Laporan Surat Masuk</h1>
    <table>
        <thead>
            <tr>
              <th>No</th>
                            <th>Tgl. Surat Diterima</th>
                            <th>No. Surat</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Penerima</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->tanggal_surat }}</td>
                    <td>{{ $row->nomor_surat }}</td>                 
                    <td>{{ $row->tujuan }}</td>
                    <td>{{ $row->perihal }}</td>
                    <td>{{ $row->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>
</html>