<?php
$conn = mysqli_connect('localhost','root','','db_agenda');
if(!$conn){
	echo 'gagal terhubung ke database';
}
?>