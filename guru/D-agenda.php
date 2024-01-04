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

// Hapus agenda berdasarkan ID agenda
$query_delete = "DELETE FROM agenda WHERE id_user = $ID_User AND id_agenda = $ID_Agenda";
$result_delete = mysqli_query($conn, $query_delete);

if ($result_delete) {
  // agenda berhasil dihapus, arahkan kembali ke guru_dashboard.php atau tampilkan pesan sukses.
  $_SESSION['success_message'] = "Agenda berhasil dihapus!";
  header('Location: agenda_dashboard.php');
  exit();
} else {
  echo "Gagal menghapus agenda: " . mysqli_error($conn);
}
