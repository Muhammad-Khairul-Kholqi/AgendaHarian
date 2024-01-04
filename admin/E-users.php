<?php
session_start();
require('../db.php');

// Periksa jika pengguna tidak terautentikasi
if (!isset($_SESSION['id'])) {
  header('Location: ../');
  exit();
}

// Periksa apakah parameter ID ada dalam URL
if (!isset($_GET['id'])) {
  header('Location: admin_dashboard.php');
  exit();
}

$ID_User = $_SESSION['id'];
$ID_Agenda = $_GET['id'];

// Ambil data berdasarkan 
$query = "SELECT * FROM users WHERE id = $ID_Agenda";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) != 1) {
  // Jika agenda tidak ditemukan atau bukan milik pengguna ini, arahkan kembali ke admin_dashboard.php cuy
  header('Location: agenda_dashboard.php');
  exit();
}

$user = mysqli_fetch_assoc($result);

if (isset($_POST['update_user'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $jk = $_POST['jk'];
  $role = $_POST['role'];

  $query_update = "UPDATE users SET username = '$username', password = '$password', `jk` = '$jk', role = '$role' WHERE id = $ID_Agenda";
  $result_update = mysqli_query($conn, $query_update);

  if ($result_update) {
    // berhasil diperbarui, arahkan kembali ke admin_dashboard.php atau tampilkan pesan sukses.
    $_SESSION['success_message'] = "Data User berhasil diubah!";
    header('Location: agenda_dashboard.php');
    exit();
  } else {
    echo "Gagal mengupdate data: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data User</title>
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

    input {
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
            <a href="admin_dashboard.php">
              <span class="las la-home"></span>
              <small>Dashboard</small>
            </a>
          </li>
          <li>
            <a href="agenda_dashboard.php">
              <span class="las la-book"></span>
              <small>Data User</small>
            </a>
          </li>
          <li>
            <a href="T-users.php">
              <span class="las la-plus"></span>
              <small>Tambah User</small>
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
        <h1>Data User</h1>
        <br>
      </div>
      <div class="page-content">
        <div class="abouts">
          <div class="card">
            <div class="card-about">
              <p>Edit Data User</p>
            </div>
          </div>
        </div>
      </div>
      <div class="page-content">
        <div class="abouts">
          <div class="card">
            <div class="card-about">
              <form method="post" action="">
                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                <div class="form-group">
                  <label for="l">username :</label>
                  <input type="text" name="username" value="<?= $user['username']; ?>"></input>
                </div>
                <div class="form-group">
                  <label for="">Password :</label>
                  <input type="text" name="password" value="<?= $user['password']; ?>"></input>
                </div>
                <div class="form-group">
                  <label for="">Jenis Kelamin :</label>
                  <select name="jk" required>
                    <option value="laki" <?php if ($user['jk'] === 'laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="perempuan" <?php if ($user['jk'] === 'perempuan') echo 'selected'; ?>>Perempuan</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="">status :</label>
                  <select name="role" required>
                    <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="guru" <?php if ($user['role'] === 'guru') echo 'selected'; ?>>Guru</option>
                  </select>
                </div>
                <button type="submit" name="update_user">Update Data User</button>
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