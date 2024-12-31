<?php
require_once '../classes/Reservation.php';
require_once '../config/db.php'; // Database connection

// Create a new database connection
$db = (new Database())->connect();

// Fetch all reservations, passing the database connection
$reservations = Reservation::getAll($db);

echo "<h2>All Reservations</h2>";
foreach ($reservations as $reservation) {
    echo "<div>";
    echo "<p>ID: " . $reservation->getId() . "</p>";
    echo "<p>Date: " . $reservation->getDate() . "</p>";
    echo "<p>Heure: " . $reservation->getHeure() . "</p>";
    echo "<p>Ligne: " . $reservation->getLigne() . "</p>";
    echo "<p>Status: " . $reservation->getStatus() . "</p>";
    echo "<a href='update_reservation.php?id=" . $reservation->getId() . "'>Edit</a> | ";
    echo "<a href='delete_reservation.php?id=" . $reservation->getId() . "'>Delete</a>";
    echo "</div>";
}
?>
