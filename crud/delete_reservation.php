<?php
require_once '../classes/Reservation.php';
require_once '../config/db.php'; // Database connection

// Create a new database connection
$db = (new Database())->connect();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    $reservation = new Reservation($reservationId);
    if ($reservation->delete($db)) {
        echo "Reservation deleted successfully!";
    } else {
        echo "Failed to delete reservation!";
    }
}
?>
