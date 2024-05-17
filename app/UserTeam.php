<?php
session_start();
require_once 'Database.php';
class UserTeam {
  // database connection object
  protected $db;
  // user ID obtained from session
  protected $user_id;
  // Result of the database query
  protected $result;

  /**
   * Constructor for the UserTeam class.
   */
  public function __construct() {
    // Initialize database connection
    $this->db = new Database();
    // Get user ID from session, or set to null if not available
    $this->user_id = $_SESSION['user_id'] ?? NULL;

    // Check if user ID is available
    if ($this->user_id) {
      $conn = $this->db->getConnection();
      $query = "SELECT players.player_id, players.player_name, players.player_type, players.points FROM team  INNER JOIN players ON team.player_id = players.player_id  WHERE team.user_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $this->user_id);
      $stmt->execute();
      $this->result = $stmt->get_result();
    }
  }
  public function getUserTeam() {
    return $this->result;
  }
}
?>

