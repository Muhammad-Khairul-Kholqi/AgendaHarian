<?php
session_start();
require '../db.php';

// Periksa jika pengguna tidak terautentikasi
if (!isset($_SESSION['id'])) {
  header('Location: ../');
  exit();
}

$id = $_SESSION['id'];

// Ambil data users dari database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan data
$user = [];

// Ambil data ke dalam array
while ($row = mysqli_fetch_assoc($result)) {
  $user[] = $row;
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
            <a href="admin_dashboard.php">
              <span class="las la-home"></span>
              <small>Dashboard</small>
            </a>
          </li>
          <li>
            <a href="" class="active">
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
        <?php if (isset($_SESSION['success_message'])) : ?>
          <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; width: 50%;">
            <?php echo $_SESSION['success_message']; ?>
          </div>
          <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
      </div>
      <div class="page-content">
        <div class="analytics">
          <div class="card">
            <div class="card-head">
              <p>Halaman Data Users.</p>
            </div>
          </div>
        </div>

        <div class="records table-responsive">
          <div class="record-header">
            <div class="add">
              <a href="T-users.php"><button>Tambah User</button></a>
            </div>

            <div class="browse">
              <input type="search" placeholder="Search" class="record-search">
            </div>
          </div>

          <div>
            <table width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>username</th>
                  <th>password</th>
                  <th>Jenis Kelamin</th>
                  <th>status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($user as $use) { ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td> <?= $use['username']; ?></td>
                    <td> <?= $use['password']; ?></td>
                    <td> <?= $use['jk']; ?></td>
                    <td> <?= $use['role']; ?></td>
                    <td>
                      <a href="E-users.php?id=<?= $use['id']; ?>"><button class="btn-submit" style="background-color: green;"><i class="las la-edit"></i></button></a>
                      <a href="D-users.php?id=<?= $use['id']; ?>"><button class="btn-submit" style="background-color: red;"><i class="las la-trash"></i></button></a>
                    </td>
                  </tr>
                  <?php $i++; ?>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>

      </div>

  </div>

  </main>

  </div>
</body>

</html>