<?php

/**
 * @file
 * Contains Login_db class.
 */

require 'Database.php';

/**
 * Defines a class for user login functionality.
 */
class Login_db extends Database {

  /**
   * The database connection object.
   *
   * @var mysqli
   */
  protected $db;

  /**
   * Constructs a new Login_db object.
   *
   * @param \Database $database
   *   The database connection.
   */
  public function __construct($database) {
    $this->db = $database->getConnection(); // Get the mysqli connection object

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
      $email = $_POST["email"];
      $password = $_POST["password"];
      // Prepare SQL statement to prevent SQL injection
      $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
      $stmt = $this->db->prepare($sql);
      $stmt->bind_param("ss", $email, $password);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result && $result->num_rows > 0) {
        // Fetch user data including role
        $user = $result->fetch_assoc();
        $_SESSION["loggedin"] = TRUE;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $user['role'];
        $_SESSION['user-id'] = $user['id'];
        if ($user['role'] == 'admin') {
          header("Location: /playerForm");
        }
        else {
          header("Location: /userdashboard");
        }
        exit();
      }
      else {
        $this->setError("Invalid email or password.");
      }
    }
  }

  /**
   * Sets an error message and redirects to the login page.
   *
   * @param string $message
   *   The error message to display.
   */
  private function setError($message) {
    echo "<script>alert('$message'); window.location.href='/login'</script>";
  }

}

// Instantiate Database class
$db = new Database();

// Instantiate Login_db class with the database connection
$login = new Login_db($db);
