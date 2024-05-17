<?php
require 'Database.php';
class Player {
  /**
   * database connection variable
   *
   * @var mixed
   */
  private $db;
  /**
   * variable to store player id
   *
   * @var int
   */
  public $player_id;
  /**
   * variable to store player name
   *
   * @var string
   */
  public $player_name;
  /**
   * variable to store player type from batsman, bowler, all-rounder
   *
   * @var string
   */
  public $player_type;
  /**
   * variable to store points
   *
   * @var int
   */
  public $points;
  /**
   * constructor to set the database connection variable
   */
  public function __construct($db) {
    $this->db = $db;
  }
  /**
   * create function to create a new player into database
   *
   * @return bool
   */
  public function create() {
    // Check if player ID already exists and execute the commands
    $query_check = "SELECT player_id FROM players WHERE player_id = ?";
    $stmt_check = $this->db->prepare($query_check);
    $stmt_check->bind_param("i", $this->player_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    //check if result is returned empty or not
    if ($result->num_rows > 0) {
      // Player ID already exists, show alert
      echo "<script>alert('Player ID already exists. Please choose a different ID.'); window.location.href='/playerForm'</script>";
      return false;
    }
    // Insert new player record
    $query_insert = "INSERT INTO players (player_id, player_name, player_type, points) VALUES (?, ?, ?, ?)";
    $stmt_insert = $this->db->prepare($query_insert);
    $stmt_insert->bind_param("issi", $this->player_id, $this->player_name, $this->player_type, $this->points);
    if ($stmt_insert->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
// Create a database connection
$db = new Database();
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  //get values from post
  $player_id = $_POST['player_id'];
  $player_name = $_POST['player_name'];
  $player_type = $_POST['player_type'];
  $points = $_POST['points'];
  // Create a new Player instance
  $player = new Player($db->getConnection());
  $player->player_id = $player_id;
  $player->player_name = $player_name;
  $player->player_type = $player_type;
  $player->points = $points;
  // Attempt to create the player
  if ($player->create()) {
    echo "<script>alert('Player added successfully!'); window.location.href='/playerForm'</script>";
  } else {
    echo "<script>alert('Failed to add player. Please try again.'); window.location.href='/playerForm'</script>";
  }
}