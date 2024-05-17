
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Player</title>
    <link rel="stylesheet" href="../app/css/playerForm.css">
</head>
<body>
    <a href="/logout">logout</a>
    <h2>Add New Player</h2>
    <form method="post" action="./app/Player.php" >
        <label for="player_id">Player ID:</label>
        <input type="number" id="player_id" name="player_id" required><br><br>

        <label for="player_name">Player Name:</label>
        <input type="text" id="player_name" name="player_name" required><br><br>

        <label for="player_type">Player Type:</label>
        <select id="player_type" name="player_type" required>
            <option value="batsman">Batsman</option>
            <option value="bowler">Bowler</option>
            <option value="allrounder">Allrounder</option>
        </select><br><br>

        <label for="points">Points:</label>
        <input type="number" id="points" name="points" min="2" max="10" required><br><br>

        <button type="submit">Add Player</button>
    </form>
</body>
</html>
