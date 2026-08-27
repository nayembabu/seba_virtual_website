<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'confiq.php';

// Handle search query
$searchEmail = '';
if (isset($_GET['email'])) {
    $searchEmail = $_GET['email'];
    $stmt = $conn->prepare('SELECT login_attempts.*, users.email FROM login_attempts LEFT JOIN users ON login_attempts.user_id = users.id WHERE users.email LIKE ? ORDER BY users.email, login_attempts.login_time DESC');
    $searchTerm = '%' . $searchEmail . '%';
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query('SELECT login_attempts.*, users.email FROM login_attempts LEFT JOIN users ON login_attempts.user_id = users.id ORDER BY users.email, login_attempts.login_time DESC');
}

$loginAttempts = [];
while ($row = $result->fetch_assoc()) {
    $email = $row['email'] ?? 'Unknown User';
    if (!isset($loginAttempts[$email])) {
        $loginAttempts[$email] = [];
    }
    $loginAttempts[$email][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login Attempts</title>
    <style>
        body {
            font-family: 'Orbitron', sans-serif;
            background-color: #000;
            color: #00ff00;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            text-shadow: 0 0 5px #00ff00, 0 0 10px #00ff00, 0 0 15px #00ff00;
        }
        .search-bar {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 10px;
            font-size: 1em;
            border: 2px solid #00ff00;
            background: none;
            color: #00ff00;
            outline: none;
        }
        .search-bar button {
            padding: 10px 20px;
            font-size: 1em;
            border: 2px solid #00ff00;
            background: none;
            color: #00ff00;
            cursor: pointer;
            outline: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #111;
            box-shadow: 0 2px 4px rgba(0, 255, 0, 0.2);
            animation: neon-glow 1.5s infinite alternate;
        }
        table, th, td {
            border: 1px solid #00ff00;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #111;
            color: #00ff00;
            text-shadow: 0 0 5px #00ff00;
        }
        tr:nth-child(even) {
            background-color: #1c1c1c;
        }
        tr:hover {
            background-color: #333;
        }
        .hidden {
            display: none;
        }

        @keyframes neon-glow {
            from {
                text-shadow: 0 0 10px #00ff00, 0 0 20px #00ff00, 0 0 30px #00ff00, 0 0 40px #00ff00;
            }
            to {
                text-shadow: 0 0 5px #00ff00, 0 0 15px #00ff00, 0 0 25px #00ff00, 0 0 35px #00ff00;
            }
        }
    </style>
    <script>
        function toggleDetails(email) {
            var rows = document.getElementsByClassName('details-' + email);
            for (var i = 0; i < rows.length; i++) {
                rows[i].classList.toggle('hidden');
            }
        }
    </script>
</head>
<body>
    <h1>Login Attempts</h1>
    <div class="search-bar">
        <form method="get" action="admin_login_attempts.php">
            <input type="text" name="email" placeholder="Search by email" value="<?php echo htmlspecialchars($searchEmail); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>IP Address</th>
                <th>Login Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loginAttempts as $email => $attempts): ?>
                <tr onclick="toggleDetails('<?php echo md5($email); ?>')" style="cursor: pointer;">
                    <td><?php echo htmlspecialchars($email); ?></td>
                    <td colspan="3"><strong><?php echo count($attempts); ?> login attempts</strong></td>
                </tr>
                <?php foreach ($attempts as $attempt): ?>
                    <tr class="details-<?php echo md5($email); ?> hidden">
                        <td></td>
                        <td><?php echo htmlspecialchars($attempt['ip_address']); ?></td>
                        <td><?php echo htmlspecialchars($attempt['login_time']); ?></td>
                        <td><?php echo $attempt['status'] ? 'Success' : 'Failed'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
