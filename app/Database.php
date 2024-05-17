<?php
require_once 'config.php';
class Database {
    /**
     * db
     *
     * @var mixed
     */
    protected $db;
    /**
     * constructor to connect to database
     */
    public function __construct() {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASS;
        $database = DB_NAME;
        $this->db = new \mysqli($host, $username, $password, $database);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    /**
     * used to get the database connection variable to check for successfull connection
     */
    public function getConnection() {
        return $this->db;
    }
}