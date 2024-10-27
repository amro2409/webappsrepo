
class UserModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
