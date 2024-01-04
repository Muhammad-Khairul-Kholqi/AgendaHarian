<?php
session_start();
require '../db.php';

// Periksa jika pengguna tidak terautentikasi
if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

$ID_User = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calender Guru</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/dasboard.css">
</head>

<style>
    #calendar {
        width: 900px;
        height: 600px;
        margin: 0 auto;
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
                        <a href="calender_dashboard.php" class="active">
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
                <h1>Calender</h1>
                <br>
                <small>Jurnal Calender</small>
            </div>
            <div class="page-content">
                <div class="analytics">
                    <div class="modal fade" id="event-details-modal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventDetailsModalLabel">Detail Kegiatan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Judul Kegiatan:</strong> <span id="event-title-detail"></span></p>
                                    <p><strong>Tanggal Mulai:</strong> <span id="event-start-detail"></span></p>
                                    <p><strong>Tanggal Selesai:</strong> <span id="event-end-detail"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger" id="delete-event">delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="event-form-modal" tabindex="-1" aria-labelledby="eventFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventFormModalLabel">Tambahkan Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-event-form">
                                        <div class="form-group">
                                            <label for="event-title">Judul Kegiatan :</label>
                                            <input type="text" class="form-control" id="event-title" name="kegiatan" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="event-start">Tanggal Mulai :</label>
                                            <input type="datetime-local" class="form-control" id="event-start" name="mulai" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="event-end">Tanggal Selesai :</label>
                                            <input type="datetime-local" class="form-control" id="event-end" name="selesai" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="calendar"></div>
            </div>
    </div>
    </main>

    <?php

    $koneksi = mysqli_connect('localhost', 'root', '', 'db_agenda');

    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kegiatan = $_POST['judul_kegiatan'];
        $mulai = $_POST['tanggal_awal'];
        $selesai = $_POST['tanggal_akhir'];

        $sql = "INSERT INTO agenda (judul_agenda, tanggal_awal, tanggal_akhir) VALUES ('$kegiatan', '$mulai', '$selesai')";

        if (mysqli_query($koneksi, $sql)) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        }

        mysqli_close($koneksi);
    }

    // Fetch events from the database
    $query = "SELECT * FROM agenda WHERE id_user = $ID_User";
    $result = mysqli_query($koneksi, $query);

    // Create an array to store events
    $events = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $event = [
            'title' => $row['judul_agenda'],
            'start' => $row['tanggal_awal'],
            'end' => $row['tanggal_akhir']
        ];
        $events[] = $event;
    }

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] == 'delete') {
        // Retrieve the unique identifier of the event from the AJAX request
        $id = $_POST['id']; // Update the key to match your form input field name

        // Implement your SQL query to delete the event from the database using the unique identifier
        $query = "DELETE FROM agenda WHERE id = $id"; // Use the 'id' field as the unique identifier
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo 'success'; // Event deleted successfully
        } else {
            echo 'error'; // Error occurred while deleting the event
        }
    } else {
        echo 'error'; // Invalid request method
    }

    // // Close the database connection
    // mysqli_close($koneksi);

    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($events); ?>,
                dateClick: function(info) {
                    $('#event-details-modal').modal('show');
                    document.getElementById('event-start-detail').textContent = info.dateStr;
                    document.getElementById('event-end-detail').textContent = info.dateStr;
                },
                eventClick: function(info) {
                    $('#event-details-modal').modal('show');
                    document.getElementById('event-title-detail').textContent = info.event.title;
                    document.getElementById('event-start-detail').textContent = info.event.start.toLocaleString();
                    document.getElementById('event-end-detail').textContent = info.event.end.toLocaleString();
                }
            });

            $('#event-details-modal').on('hidden.bs.modal', function() {
                $('#event-title-detail').text('');
                $('#event-start-detail').text('');
                $('#event-end-detail').text('');
            });

            calendar.render();
        });
    </script>

</body>

</html>