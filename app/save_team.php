<?php
session_start();
require_once 'Database.php';
require_once 'Team.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
  // Validate selected players
  if (isset($_POST['selected_players']) && count($_POST['selected_players']) === 11) {
    // Calculate total points of selected players
    $totalPoints = 0;
    foreach ($_POST['selected_players'] as $playerId) {
      // Retrieve points from the database or other source
      $points = getPlayerPoints($playerId); // Implement this function to get player points
      $totalPoints += $points;
    }
    // Check if total points exceed 100
    if ($totalPoints <= 100) {
      // Process selected players
      $selectedPlayers = $_POST['selected_players'];
      // Add code to store selected players in the team table
      $db = new Database();
      $team = new Team($db);
      if ($team->saveTeam($selectedPlayers)) {
        // Team saved successfully
        echo "Team saved successfully.";
        header("Location: /view_team");
      } else {
        // Error saving team
        http_response_code(500);
        echo "Error saving team.";
      }
    } else {
      // Return error message if total points exceed 100
      http_response_code(400);
      echo "Error: Total points exceed 100.";
    }
  } else {
    // Return error message if conditions are not met
    http_response_code(400);
    echo "Error: Please select exactly 11 players.";
  }
} else {
  // Return error message if form is not submitted
  http_response_code(400);
  echo "Error: Form submission error.";
}

function getPlayerPoints($playerId)
{
  $db = new Database();
  $conn = $db->getConnection();
  $stmt = $conn->prepare("SELECT points FROM players WHERE player_id = ?");
  if (!$stmt) {
    // Handle error
    return false;
  }

  // Bind parameters and execute statement
  $stmt->bind_param("i", $playerId);
  if (!$stmt->execute()) {
    // Handle error
    $stmt->close();
    $conn->close();
    return false;
  }

  // Get result
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    // Fetch points
    $row = $result->fetch_assoc();
    $points = $row['points'];
  } else {
    // Player not found
    $points = false;
  }

  // Close statement and database connection
  $stmt->close();
  $conn->close();

  return $points;
}
?>