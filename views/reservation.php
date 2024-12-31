<?php
// Include database connection and CRUD operations
require_once '../crud/retrieve_reservation.php'; // Retrieves reservations from the database

// Check if the user is authorized to access the page
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<h2>Manage Reservations</h2>

<!-- Button to Add New Reservation -->
<a href="crud/add_reservation.php"><button>Add Reservation</button></a>

<?php
// Fetch all reservations from the previous included file
if (isset($reservations) && count($reservations) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Ligne</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $reservation->getId(); ?></td>
                    <td><?php echo $reservation->getDate(); ?></td>
                    <td><?php echo $reservation->getHeure(); ?></td>
                    <td><?php echo $reservation->getLigne(); ?></td>
                    <td><?php echo $reservation->getStatus(); ?></td>
                    <td>
                        <!-- Edit Link -->
                        <a href="crud/update_reservation.php?id=<?php echo $reservation->getId(); ?>">Edit</a> |
                        <!-- Delete Link -->
                        <a href="crud/delete_reservation.php?id=<?php echo $reservation->getId(); ?>" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No reservations found.</p>
<?php endif; ?>

</body>
</html>
