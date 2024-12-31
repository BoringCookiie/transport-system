<?php
require_once '../config/db.php';

session_start();

// Check if the user is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Connect to the database
$db = (new Database())->connect();

// Fetch total users
$query = $db->prepare("SELECT COUNT(*) AS total_users FROM utilisateur");
$query->execute();
$totalUsers = $query->fetch()['total_users'];

// Fetch total reservations
$query2 = $db->prepare("SELECT COUNT(*) AS total_reservations FROM reservation");
$query2->execute();
$totalReservations = $query2->fetch()['total_reservations'];

// Fetch active reservations
$query3 = $db->prepare("SELECT COUNT(*) AS active_reservations FROM reservation WHERE status = 'active'");
$query3->execute();
$totalActiveReservations = $query3->fetch()['active_reservations'];

// Fetch reservation details
$query4 = $db->prepare("
    SELECT 
        r.id AS reservation_id,
        r.date,
        r.heure,
        r.status,
        l.nom AS ligne_nom,
        u.id AS utilisateur_id,
        u.nom AS utilisateur_nom
    FROM reservation r
    INNER JOIN ligne l ON r.ligne = l.id
    INNER JOIN utilisateur u ON r.idutilisateur = u.id
");
$query4->execute();
$reservations = $query4->fetchAll(PDO::FETCH_ASSOC);

// Fetch client details
$query5 = $db->prepare("
    SELECT 
        u.id AS client_id,
        u.nom AS client_name,
        u.email AS client_email
    FROM utilisateur u
    INNER JOIN client c ON u.id = c.idutilisateur
");
$query5->execute();
$clients = $query5->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../views/admin_dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Navigation Buttons -->
        <div class="button-container">
            <button onclick="showSection('reservations-section')">Reservations</button>
            <button onclick="showSection('clients-section')">Clients</button>
        </div>

        <!-- Dashboard Stats -->
        <div class="card-container">
            <div class="dashboard-card">
                <h2>Total Users</h2>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="dashboard-card">
                <h2>Total Reservations</h2>
                <p><?php echo $totalReservations; ?></p>
            </div>
            <div class="dashboard-card">
                <h2>Active Reservations</h2>
                <p><?php echo $totalActiveReservations; ?></p>
            </div>
        </div>

        <!-- Reservations Section -->
        <div id="reservations-section" class="content-section">
            <h2>Reservations</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Line</th>
                        <th>Status</th>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['reservation_id']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['heure']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['ligne_nom']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['utilisateur_id']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['utilisateur_nom']); ?></td>
                            <td>
                                <a href="../crud/update_reservation.php?id=<?php echo $reservation['reservation_id']; ?>">Update</a>
                                <a href="../crud/delete_reservation.php?id=<?php echo $reservation['reservation_id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="../crud/add_reservation.php" class="btn">Add New Reservation</a>
        </div>

        <!-- Clients Section -->
        <div id="clients-section" class="content-section" style="display: none;">
            <h2>Clients</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($client['client_id']); ?></td>
                            <td><?php echo htmlspecialchars($client['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($client['client_email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>
