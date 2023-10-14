<?php
class DatabaseConnection {
    private $conn;
    
    public function __construct($server, $user, $pass, $dbName) {
        $this->conn = new mysqli($server, $user, $pass, $dbName);
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function executeQuery($sql) {
        return $this->conn->query($sql);
    }
    
    public function closeConnection() {
        $this->conn->close();
    }
}

class DataDisplay {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function displayData() {
        $sql = "SELECT * FROM user";
        $result = $this->db->executeQuery($sql);

        if ($result->num_rows > 0) {
            echo "<h1>Database Records:</h1>";
            echo "<ul>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["user_id"] . " - " . $row["Fname"] . "</li>";
                // Replace "column1" and "column2" with your actual column names
            }
            
            echo "</ul>";
        } else {
            echo "No records found in the database.";
        }
        
        $this->db->closeConnection();
    }
}

$server = "localhost";
$user = "root";
$pass = "";
$dbName = "ksmdb";

$db = new DatabaseConnection($server, $user, $pass, $dbName);
$dataDisplay = new DataDisplay($db);
$dataDisplay->displayData();
?>

