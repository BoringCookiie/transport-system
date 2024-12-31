<?php
require_once '../classes/Reservation.php';
require_once '../config/db.php'; // Database connection

$db = (new Database())->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $ligne = $_POST['ligne'];
    $utilisateurId = $_POST['utilisateurId'];
    $status = $_POST['status'];

    $reservation = new Reservation(null, $date, $heure, $ligne, $utilisateurId, $status);
    if ($reservation->create($db)) {
        echo "Reservation added successfully!";
    } else {
        echo "Failed to add reservation!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reservation</title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="add_reservation.css">
</head>
<body>
    <form method="POST" action="">
        <h2>Add a New Reservation</h2>
        
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>
        
        <label for="heure">Heure:</label>
        <input type="time" name="heure" required><br>
        
        <label for="ligne">Ligne:</label>
        <input type="text" name="ligne" required><br>
        
        <label for="utilisateurId">Utilisateur ID:</label>
        <input type="number" name="utilisateurId" required><br>
        
        <label for="status">Status:</label>
        <input type="text" name="status" required><br>
        
        <button type="submit">Add Reservation</button>
    </form>
</body>
</html>
