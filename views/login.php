<?php
require_once '../config/db.php';
require_once '../classes/Utilisateur.php';

session_start();

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Role selection (admin or client)

    // Hardcode admin login credentials
    if ($email === 'admin@gmail.com' && $password === 'admin') {
        $_SESSION['user'] = ['email' => $email, 'role' => 'admin'];
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit;
    }

    // Database login check
    $db = (new Database())->connect();

    if ($role == 'admin') {
        $query = $db->prepare("SELECT * FROM utilisateur u 
                               JOIN administrateur a ON u.id = a.idutilisateur 
                               WHERE u.email = :email AND u.motDePasse = :password");
    } else {
        $query = $db->prepare("SELECT * FROM utilisateur u 
                               JOIN client c ON u.id = c.idutilisateur 
                               WHERE u.email = :email AND u.motDePasse = :password");
    }

    $query->execute(['email' => $email, 'password' => $password]);
    $user = $query->fetch();

    if ($user) {
        $_SESSION['user'] = $user; // Store user data in the session
        header("Location: " . ($role == 'admin' ? "admin_dashboard.php" : "client_dashboard.php"));
        exit;
    } else {
        $error_message = "Invalid email, password, or role!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form method="POST" action="">
        <h2>Login</h2>
        <?php if ($error_message): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required>
        
        <label for="role">Login as:</label>
        <div class="radio-group">
            <input type="radio" id="admin" name="role" value="admin" required>
            <label for="admin">Administrator</label>
            
            <input type="radio" id="client" name="role" value="client" required>
            <label for="client">Client</label>
        </div>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>
