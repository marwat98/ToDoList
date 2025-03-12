<?php
namespace DataBaseFunction;
use DataBaseConnection\DataBase;
use MessageTwigFunction\MessageHandler;
require_once ('C:\xampp\htdocs\ToDoList\config.php');

class LoginToAcount{
    private $db;
    private $message;

    public function __construct(DataBase $db, MessageHandler $message){
        $this->db = $db;
        $this->message = $message;
    }
    public function login(string $login, string $password, string $template): bool {
        $conn = $this->db->connection();
        if ($conn->connect_errno) {
            $this->message->showMessage($template, "Połączenie z bazą danych nie powiodło się", false);
            return false;
        }
    
        $stmt = $conn->prepare('SELECT * FROM users WHERE login = ?');
        if (!$stmt) {
            $this->message->showMessage($template, "Błąd przygotowania zapytania SQL", false);
            return false;
        }
        $stmt->bind_param('s', $login);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $this->message->showMessage($template, "Pomyślnie zalogowano ✅", false);
                return true;
                // session_start();
                // $_SESSION['id'] = $row['id'];
                // $_SESSION['login'] = $row['login'];
                // header("Location: /ToDoList/add");
                // exit();
            } else {
                $this->message->showMessage($template, "Nieprawidłowe hasło ❌", false);
                return false;
            }
        } else {
            $this->message->showMessage($template, "Konto nie istnieje ❌", false);
            return false;
        }
    }     
}
?>