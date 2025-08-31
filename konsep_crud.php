<?php
// === Koneksi Database ===
$host = "localhost";
$user = "root";
$pass = "";
$db   = "akademik_db";
$koneksi = new mysqli($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// === Proses Tambah Data ===
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $koneksi->query("INSERT INTO mahasiswa (nim,nama,umur) VALUES ('$nim','$nama','$umur')");
    header("Location: konsep_crud.php");
    exit;
}

// === Proses Update Data ===
if (isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $koneksi->query("UPDATE mahasiswa SET nama='$nama', umur='$umur' WHERE nim='$nim'");
    header("Location: konsep_crud.php");
    exit;
}

// === Proses Hapus Data ===
if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];
    $koneksi->query("DELETE FROM mahasiswa WHERE nim='$nim'");
    header("Location: konsep_crud.php");
    exit;
}

// === Ambil Data untuk Edit ===
$editData = null;
if (isset($_GET['edit'])) {
    $nim = $_GET['edit'];
    $editData = $koneksi->query("SELECT * FROM mahasiswa WHERE nim='$nim'")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>konsep CRUD </title>
</head>
<body>
    <h2>Mahasiswa</h2>

    <!-- Form Tambah / Edit -->
    <form method="post">
        <label>NIM:</label><br>
        <input type="text" name="nim" value="<?= $editData['nim'] ?? '' ?>" <?= $editData ? 'readonly' : '' ?> required><br><br>

        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $editData['nama'] ?? '' ?>" required><br><br>

        <label>Umur:</label><br>
        <input type="number" name="umur" value="<?= $editData['umur'] ?? '' ?>" required><br><br>

        <?php if ($editData): ?>
            <button type="submit" name="update">Update</button>
            <a href="konsep_crud.php">Batal</a>
        <?php else: ?>
            <button type="submit" name="tambah">Tambah</button>
        <?php endif; ?>
    </form>

    <hr>

    <!-- Tabel Data -->
    <h3>Daftar Mahasiswa</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Aksi</th>
        </tr>
        <?php
        $result = $koneksi->query("SELECT * FROM mahasiswa ORDER BY nim ASC");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['nim'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['umur'] ?></td>
            <td>
                <a href="konsep_crud.php?edit=<?= $row['nim'] ?>">Edit</a> | 
                <a href="konsep_crud.php?hapus=<?= $row['nim'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
