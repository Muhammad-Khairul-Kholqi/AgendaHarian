<?php
session_start();
require '../db.php';

// Periksa jika pengguna tidak terautentikasi
if (!isset($_SESSION['id'])) {
  header('Location: ../');
  exit();
}

$ID_User = $_SESSION['id'];

// Ambil data agenda dari database
$query = "SELECT * FROM agenda WHERE id_user = $ID_User";
$result = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan data
$agenda = [];

// Ambil data ke dalam array
while ($row = mysqli_fetch_assoc($result)) {
  $agenda[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <title>Agenda Daily</title>
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/dasboard.css">
  <style>
    .btn-submit {
      background-color: #007BFF;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .btn-submit:hover {
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
            <a href="" class="active">
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
        <h1>Dashboard</h1>
        <br>
        <small>Home / Dashboard</small>
      </div>
      <div class="page-content">
        <div class="analytics">
          <div class="card">
            <div class="card-head">
              <h2>Selamat Datang, <b> <?= $_SESSION['nama']; ?> </b></h2>
            </div>
          </div>
        </div>
        <div class="abouts">
          <div class="card">
            <div class="card-about">
              <p>Agenda ini diperuntukkan untuk para guru. Dengan memiliki agenda, akan lebih mudah dalam menyusun kegiatan secara lebih detail dan terstruktur agar kegiatan dapat berjalan dengan baik dan lancar.</p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>