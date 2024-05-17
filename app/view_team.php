<?php
session_start();
require_once 'Database.php';
require_once 'UserTeam.php';

$userTeam = new UserTeam();
$result = $userTeam->getUserTeam();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Team</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a CSS file -->
</head>
<body>
    <h1>View Team</h1>
    <a href="/logout">logout</a>
    <?php if ($result && $result->num_rows > 0) : ?>
    <table>
        <tr>
            <th>Player ID</th>
            <th>Player Name</th>
            <th>Player Type</th>
            <th>Points</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['player_id']; ?></td>
            <td><?php echo $row['player_name']; ?></td>
            <td><?php echo $row['player_type']; ?></td>
            <td><?php echo $row['points']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else : ?>
    <p>No players found in your team.</p>
    <?php endif; ?>
</body>
</html>
