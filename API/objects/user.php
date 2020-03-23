<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $login;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                login = :login,
                password = :password";

        $stmt = $this->conn->prepare($query);

        $this->login = htmlspecialchars(strip_tags($this->login));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':login', $this->login);

        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function loginExists() {
        $query = "SELECT id, login, password FROM " . $this->table_name . "
            WHERE login = ?
            LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $this->login=htmlspecialchars(strip_tags($this->login));

        $stmt->bindParam(1, $this->login);

        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->login = $row['login'];
            $this->password = $row['password'];

            return true;
        }

        return false;
    }
}
?>