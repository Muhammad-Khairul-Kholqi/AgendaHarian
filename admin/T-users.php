<?php
session_start();
require('../db.php');

if (!isset($_SESSION['id'])) {
    header('Location: ../'); // Redirect jika pengguna tidak terautentikasi
    exit();
}

if (isset($_POST['tambah_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jk = $_POST['jk'];
    $role = $_POST['role'];

    // Masukkan catatan ke dalam tabel
    $query = "INSERT INTO users (username, password, `jk`, role) VALUES ('$username', '$password', '$jk', '$role')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // berhasil ditambahkan, Anda dapat mengarahkan pengguna kembali ke halaman guru_dashboard.php atau melakukan tindakan lain yang sesuai.
        $_SESSION['success_message'] = "user berhasil ditambahkan!";
        header('Location: agenda_dashboard.php');
        exit();
    } else {
        echo "Gagal menambahkan user: " . mysqli_error($conn);
    }
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
        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
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
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            height: 50px;
        }

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
                        <a href="agenda_dashboard.php">
                            <span class="las la-book"></span>
                            <small>Data User</small>
                        </a>
                    </li>
                    <li>
                        <a href="T-users.php" class="active">
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
                <h1>Agenda</h1>
                <br>
                <small>Tambah Users Baru</small>
            </div>
            <div class="page-content">
                <div class="abouts">
                    <div class="card">
                        <div class="card-about">
                            <p>Tambah Users</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="abouts">
                    <div class="card">
                        <div class="card-about">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="username">username : </label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin :</label>
                                    <select name="jk" required>
                                        <option value="laki">Laki-Laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                    <div class="form-group">
                                        <label for="judul">password :</label> <br>
                                        <input type="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="role">status :</label>
                                        <select name="role" required>
                                            <option value="admin">Admin</option>
                                            <option value="guru">guru</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="tambah_user" class="btn-submit">Tambah User</button>
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