<?php
session_start();
require('../db.php');

// Periksa jika pengguna tidak terautentikasi
if (!isset($_SESSION['id'])) {
  header('Location: ../');
  exit();
}

// Periksa apakah parameter ID agenda ada dalam URL
if (!isset($_GET['id_agenda'])) {
  header('Location: guru_dashboard.php');
  exit();
}

$ID_User = $_SESSION['id'];
$ID_Agenda = $_GET['id_agenda'];

// Ambil data berdasarkan ID
$query = "SELECT * FROM agenda WHERE id_user = $ID_User AND id_agenda = $ID_Agenda";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) != 1) {
  // Jika agenda tidak ditemukan atau bukan milik pengguna ini, arahkan kembali ke guru_dashboard.php cuy
  header('Location: guru_dashboard.php');
  exit();
}

$agenda = mysqli_fetch_assoc($result);

if (isset($_POST['update_agenda'])) {
  $tanggal = $_POST['tanggal'];
  $judul = $_POST['judul'];
  $isi_agenda = $_POST['isi_agenda'];
  $status_agenda = $_POST['status_agenda'];

  $query_update = "UPDATE agenda SET tanggal_akhir = '$tanggal', judul_agenda = '$judul', isi_agenda = '$isi_agenda', status_agenda = '$status_agenda' WHERE id_user = $ID_User AND id_agenda = $ID_Agenda";
  $result_update = mysqli_query($conn, $query_update);

  if ($result_update) {
    // berhasil diperbarui, arahkan kembali ke guru_dashboard.php atau tampilkan pesan sukses.
    $_SESSION['success_message'] = "Agenda berhasil diubah!";
    header('Location: agenda_dashboard.php');
    exit();
  } else {
    echo "Gagal mengupdate Agenda: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Agenda</title>
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/dasboard.css">
  <style>
    h1 {
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      display: block;
    }

    input[type="text"],
    input[type="date"],
    textarea {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    button {
      background-color: #007BFF;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <input type="checkbox" id="menu-toggle">
  <div class="sidebar">
    <div class="side-header">
      <h3><span>Agenda</span></h3>
    </div>
    <div class="side-content">
      <div class="profile">
        <div class="profile-img bg-img" style="background-image: url(../assets/img/login-form/logo.png)"></div>
      </div>
      <div class="side-menu">
        <ul>
          <li>
            <a href="guru_dashboard.php">
              <span class="las la-home"></span>
              <small>Dashboard</small>
            </a>
          </li>
          <li>
            <a href="agenda_dashboard.php">
              <span class="las la-book"></span>
              <small>Agenda</small>
            </a>
          </li>
          <li>
            <a href="calender_dashboard.php">
              <span class="las la-calendar"></span>
              <small>Kalender</small>
            </a>
          </li>
          <li>
            <a href="T-agenda.php">
              <span class="las la-plus"></span>
              <small>Buat Agenda</small>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="main-content">

    <header>
      <div class="header-content">
        <label for="menu-toggle">
          <span class="las la-bars"></span>
        </label>
        <div class="header-menu">
          <div class="user">
            <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
            <a href="logout.php"><button class="btn-submit">Logout</button></a>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="page-header">
        <h1>Agenda</h1>
        <br>
        <small>Edit Agenda</small>
      </div>
      <div class="page-content">
        <div class="abouts">
          <div class="card">
            <div class="card-about">
              <p>Edit Agenda</p>
            </div>
          </div>
        </div>
      </div>
      <div class="page-content">
        <div class="abouts">
          <div class="card">
            <div class="card-about">
              <form method="post" action="">
                <input type="hidden" name="id_agenda" value="<?= $agenda['id_agenda']; ?>">
                <div class="form-group">
                  <label for="tanggal">Selesai :</label>
                  <input type="date" name="tanggal" value="<?= $agenda['tanggal_akhir']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="judul">Uraian Agenda :</label>
                  <input type="text" name="judul" value="<?= $agenda['judul_agenda']; ?>" required>
                </div>
                <div class="form-group">
                  <label for="isi_agenda">Ket Agenda :</label>
                  <textarea name="isi_agenda" rows="4"><?= $agenda['isi_agenda']; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="status_agenda">Status Agenda :</label>
                  <br>
                  <select name="status_agenda">
                    <option value="Selesai" <?= ($agenda['status_agenda'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                    <option value="Belum Selesai" <?= ($agenda['status_agenda'] == 'Belum Selesai') ? 'selected' : ''; ?>>Belum Selesai</option>
                  </select>
                </div>
                <button type="submit" name="update_agenda">Update Agenda</button>
              </form>
              <br>
              <a href="agenda_dashboard.php">
                <button class="btn-submit" style="background-color: red;">Kembali</button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>