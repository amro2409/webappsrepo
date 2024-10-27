<?php
class Database {
    private $host = "localhost";  // اسم الخادم
    private $db_name = "training_db";  // اسم قاعدة البيانات
    private $username = "root";  // اسم المستخدم لقاعدة البيانات
    private $password = "";  // كلمة المرور لقاعدة البيانات
    public $conn;

    // دالة الاتصال بقاعدة البيانات
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo "Database Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
