<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Arsip Pengelolaan Surat</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; color: #222; background: #f9f9f9; }
    .sidebar {
      position: fixed;
      top: 0; left: 0;
      width: 240px;
      height: 100%;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 24px 16px;
    }
    .sidebar h2 { margin-bottom: 24px; font-size: 20px; }
    .sidebar ul { list-style: none; }
    .sidebar li { margin-bottom: 16px; }
    .sidebar a {
      text-decoration: none;
      color: #222;
      display: block;
      padding: 8px;
      border-radius: 4px;
    }
    .sidebar a.active { background: #e0e0e0; }

    .main {
      margin-left: 240px;
      padding: 24px;
    }
    .header {
      font-size: 24px;
      margin-bottom: 24px;
      display: flex;
      align-items: center;
    }
    .header .settings {
      margin-left: auto;
      width: 32px;
      height: 32px;
      border: 1px solid #bbb;
      border-radius: 4px;
    }
    .table-container {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 6px;
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px 16px;
      text-align: left;
      white-space: nowrap;
      border-bottom: 1px solid #eee;
    }
    th {
      background: #fafafa;
      font-weight: bold;
    }
    .controls {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px;
    }
    .controls select,
    .controls input {
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background: #fff;
    }
    .badge {
      display: inline-block;
      padding: 4px 8px;
      font-size: 12px;
      border-radius: 12px;
      background: #e0f7fa;
      color: #00796b;
    }
    .btn-check {
      padding: 6px 12px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      background: #6750a4;
      color: #fff;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
    }
    .btn-check .icon-eye {
      width: 16px;
      height: 16px;
      margin-right: 6px;
      background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEzLjI1IDcuODQ1QzExLjkyNSA1LjE3NSAxMC4wMjUgMy4yNSAxLjUgNi4xNjYgMCA1LjY0NyAwIDUuNDM3IDAgNC4wNzRDMC4wMjU5NDI2NyA1LjI4OSA0LjIyNSA4IDggOEMxMC43NzUgOCAxNC4wOTMgNi44ODMgMTMuMjUgNy44NDUiIGZpbGw9IiNmZmYiLz48L3N2Zz4=') no-repeat center;
      background-size: contain;
    }
  </style>
</head>
<body>
  <nav class="sidebar">
    <h2>Website Surat</h2>
    <ul>
      <li><a href="#">Dashboards</a></li>
      <li><a href="#">Surat Masuk</a></li>
      <li>
        <a href="#" class="active">Surat Keluar</a>
        <ul>
          <li><a href="#" class="active">Surat Kepala Arsip</a></li>
          <li><a href="#">Surat Disimpan</a></li>
          <li><a href="#">Laporan Surat Keluar</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <main class="main">
    <div class="header">
      <h1>Surat Keluar</h1>
      <div class="settings"></div>
    </div>
    <div class="table-container">
      <div class="controls">
        <select>
          <option>10 entries per page</option>
          <option>25 entries per page</option>
          <option>50 entries per page</option>
        </select>
        <input type="search" placeholder="Ketikan yang dicari" />
      </div>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Status</th>
            <th>Tgl. Surat</th>
            <th>No. Surat</th>
            <th>Perihal</th>
            <th>Tujuan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td><span class="badge"></span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><button class="btn-check"><span class="icon-eye"></span>Cek</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
