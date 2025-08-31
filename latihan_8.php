<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "akademik_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal : " . $conn->connect_error); 
}

$sql = "SELECT nim, nama, umur FROM mahasiswa ORDER BY nim ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title> Daftar Mahasiswa </title>
</head>
<body>
    <h2> Daftar Mahasiswa </h2>

    <?php if ($result->num_rows > 0){ ?>
    <table border = "1" cellpadding="5" cellspacing="0">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Opsi</th> </tr>
        <?php while ($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?= $row['nim']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['umur']; ?></td>   
            <td><a href="display.php?nim=<?= urlencode($row['nim']); ?>"> View Details </a></td>
        </tr>
        <?php }; ?>
        <?php } else { ?>
            <p> Tidak ada data mahasiswa. </p>
        <?php }; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>