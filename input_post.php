<?php
session_start();
require 'data_store.php';

$message = "";
$keyword = "";

// Handle form submit untuk tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_form'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $nim = htmlspecialchars($_POST['nim']);
    $prodi = htmlspecialchars($_POST['prodi']);
    $jk = htmlspecialchars($_POST['jk']);
    $hobi = isset($_POST['hobi']) ? array_map('htmlspecialchars', $_POST['hobi']) : [];
    $alamat = htmlspecialchars($_POST['alamat']);

    $new_biodata = [
        'nama' => $nama,
        'nim' => $nim,
        'prodi' => $prodi,
        'jk' => $jk,
        'hobi' => $hobi,
        'alamat' => $alamat
    ];

    add_biodata($new_biodata);
    $message = "Data berhasil disimpan!";
}

// Ambil semua data biodata
$all_biodata = get_all_biodata();

// Handle pencarian
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_btn'])) {
    $keyword = strtolower(trim($_POST['keyword']));
    if ($keyword !== "") {
        $all_biodata = array_filter($all_biodata, function($b) use ($keyword) {
            return strpos(strtolower($b['nama']), $keyword) !== false
                || strpos(strtolower($b['nim']), $keyword) !== false
                || strpos(strtolower($b['prodi']), $keyword) !== false
                || strpos(strtolower($b['jk']), $keyword) !== false
                || strpos(strtolower(implode(", ", $b['hobi'])), $keyword) !== false
                || strpos(strtolower($b['alamat']), $keyword) !== false;
        });
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Form Biodata Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background: linear-gradient(to bottom, #444, #222);
            color: white; 
        }
        form {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid white;
            border-radius: 10px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-left: auto;
            margin-right: auto;
            text-align: left;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            border-radius: 5px;
            border: none;
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 6px;
            cursor: pointer;
        }
        .hobi-group, .jk-group {
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px 15px;
            border: none;
            border-radius: 7px;
            background-color: #2e8b57;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #3cb371;
        }
        .message {
            width: 400px;
            margin: 0 auto 20px;
            padding: 10px;
            background-color: #4caf50;
            border-radius: 8px;
            font-weight: bold;
            color: white;
        }
        a {
            color: #a0c8f0;
            text-decoration: none;
            display: block;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: rgba(255,255,255,0.05);
        }
        th, td {
            border: 1px solid white;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: rgba(255,255,255,0.2);
        }
        tr:hover {
            background-color: rgba(255,255,255,0.1);
        }
        .search-form {
            margin: 20px auto;
            text-align: center;
        }
        .search-form input[type="text"] {
            width: 250px;
            padding: 6px;
            border-radius: 6px;
            border: none;
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
    </style>
</head>
<body>

<h2>Form Biodata Mahasiswa</h2>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

<!-- Form input biodata -->
<form method="POST" action="">
    <label for="nama">Nama Lengkap:</label>
    <input type="text" id="nama" name="nama" required>

    <label for="nim">NIM:</label>
    <input type="text" id="nim" name="nim" required>

    <label for="prodi">Program Studi:</label>
    <select id="prodi" name="prodi" required>
        <option value="">-- Pilih Program Studi --</option>
        <option value="Informatika">Informatika</option>
        <option value="Sistem Informasi">Sistem Informasi</option>
        <option value="Teknik Elektro">Teknik Elektro</option>
    </select>

    <label>Jenis Kelamin:</label>
    <div class="jk-group">
        <label><input type="radio" name="jk" value="Laki-laki" required> Laki-laki</label>
        <label><input type="radio" name="jk" value="Perempuan" required> Perempuan</label>
    </div>

    <label>Hobi:</label>
    <div class="hobi-group">
        <label><input type="checkbox" name="hobi[]" value="Membaca"> Membaca</label>
        <label><input type="checkbox" name="hobi[]" value="Olahraga"> Olahraga</label>
        <label><input type="checkbox" name="hobi[]" value="Musik"> Musik</label>
        <label><input type="checkbox" name="hobi[]" value="Gaming"> Gaming</label>
        <label><input type="checkbox" name="hobi[]" value="Traveling"> Traveling</label>
    </div>

    <label for="alamat">Alamat:</label>
    <textarea id="alamat" name="alamat" rows="3" required></textarea>

    <button type="submit" name="submit_form">Kirim</button>
</form>

<?php if (!empty($all_biodata)): ?>
    <h3>Daftar Biodata Mahasiswa</h3>

    <table>
        <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Jenis Kelamin</th>
            <th>Hobi</th>
            <th>Alamat</th>
        </tr>
        <?php foreach ($all_biodata as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['nama']) ?></td>
                <td><?= htmlspecialchars($b['nim']) ?></td>
                <td><?= htmlspecialchars($b['prodi']) ?></td>
                <td><?= htmlspecialchars($b['jk']) ?></td>
                <td><?= htmlspecialchars(implode(", ", $b['hobi'])) ?></td>
                <td><?= htmlspecialchars($b['alamat']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Search bar di bawah tabel -->
    <form method="POST" class="search-form">
        <input type="text" name="keyword" placeholder="Masukkan kata kunci..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" name="search_btn">Cari</button>
    </form>
<?php endif; ?>


</body>
</html>
