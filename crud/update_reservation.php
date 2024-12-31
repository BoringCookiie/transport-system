<?php
require_once '../classes/Reservation.php';
require_once '../config/db.php'; // Database connection

// Create a new database connection
$db = (new Database())->connect();

if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];
    $reservation = Reservation::getById($reservationId, $db);

    if (!$reservation) {
        echo "Reservation not found!";
        exit;
    }

    // Process the form if it's submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $ligne = $_POST['ligne'];
        $status = $_POST['status'];

        // Update the reservation
        $reservation->setDate($date);
        $reservation->setHeure($heure);
        $reservation->setLigne($ligne);
        $reservation->setStatus($status);

        if ($reservation->update($db)) {
            echo "Reservation updated successfully!";
        } else {
            echo "Failed to update reservation!";
        }
    }
}
?>

<form method="POST" action="">
    <label>Date:</label>
    <input type="date" name="date" value="<?php echo $reservation->getDate(); ?>" required><br>
    <label>Heure:</label>
    <input type="time" name="heure" value="<?php echo $reservation->getHeure(); ?>" required><br>
    <label>Ligne:</label>
    <input type="text" name="ligne" value="<?php echo $reservation->getLigne(); ?>" required><br>
    <label>Status:</label>
    <input type="text" name="status" value="<?php echo $reservation->getStatus(); ?>" required><br>
    <button type="submit">Update Reservation</button>
</form>
