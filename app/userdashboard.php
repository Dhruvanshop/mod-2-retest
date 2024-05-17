<?php
session_start();
require_once 'Database.php';

// Instantiate Database class
$db = new Database();
$conn = $db->getConnection();

// Fetch all players added by the admin
$query = "SELECT * FROM players";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../app/css/userdash.css"> <!-- Assuming you have a CSS file -->
    <script src="../app/js/script.js"></script>    
</head>
<body>
    <h1>User Dashboard</h1>
    <h2>Select Your Team</h2>
    <a href="/logout">logout</a>
    <form method="post" action="/save_team">
        <table>
            <tr>
                <th>Player ID</th>
                <th>Player Name</th>
                <th>Player Type</th>
                <th>Points</th>
                <th>Select</th>
            </tr>
            <?php
            // Display list of players
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['player_id'] . "</td>";
                    echo "<td>" . $row['player_name'] . "</td>";
                    echo "<td>" . $row['player_type'] . "</td>";
                    echo "<td>" . $row['points'] . "</td>";
                    echo "<td><input type='checkbox' name='selected_players[]' value='" . $row['player_id'] . "'></td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <button type="submit" name="submit">Save Team</button>
    </form>
</body>
</html>
