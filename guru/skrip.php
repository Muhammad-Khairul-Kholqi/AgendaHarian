<?php
// Memulai sesi
session_start();

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Jika belum login, arahkan ke halaman login
    header("location: ../index.php");
    exit;
}

// Cek apakah variabel sesi "show_alert" telah diatur
if (isset($_SESSION["show_alert"]) && $_SESSION["show_alert"] === true) {
    // Hapus tanda pengguna baru saja login
    unset($_SESSION["show_alert"]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Halaman</title>
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  

<center>
    <script>
  
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Login Succes!",
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
      
        window.location.href = "guru_dashboard.php";
    });
</script>
</center>

</body>
</html>
