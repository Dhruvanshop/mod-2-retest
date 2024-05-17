<?php
require 'Database.php';
class Team {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function saveTeam($selectedPlayers) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO team (player_id) VALUES (?)");
        if (!$stmt) {
            http_response_code(500);
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        foreach ($selectedPlayers as $playerId) {
            $stmt->bind_param("i", $playerId);
            if (!$stmt->execute()) {
                http_response_code(500);
                echo "Error executing statement: " . $stmt->error;
                exit();
            }
        }

        $stmt->close();
        $conn->close();
        return true;
    }
}
?>
