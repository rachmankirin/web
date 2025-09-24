<?php
require 'data_store.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            background: linear-gradient(to bottom, gray);
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
    </style>
</head>
<body>

<h2>Form Biodata Mahasiswa</h2>

<?php if ($message): ?>
    <div class="message"><?= $message ?></div>
<?php endif; ?>

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

    <button type="submit">Kirim</button>
</form>

<a href="search_get.php">Cari data biodata</a>

</body>
</html>
