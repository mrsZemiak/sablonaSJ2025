<?php
//error_reporting(E_ALL); //zapnutie chybových hlásení
//ini_set("display_errors","On");
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/classes/Database.php');
class Users extends Database{
    private $rola;
    protected $connection;
    public function __construct() {
        $this->rola= "pouzivatel";
        $this->connect();
        $this->connection = $this->getConnection();
    }
    public function register($login, $email, $password){
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            //overenenie či sa používateľ nachádza v db
            $sql = "SELECT * FROM pouzivatelia WHERE (login = ? OR email = ?) LIMIT 1;";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $login);
            $statement->bindParam(2, $email);
            $statement->execute();
            $existingUser = $statement->fetch();
            if ($existingUser) {
                throw new Exception("Požívateľ už existuje.");
            }
            $sql = "INSERT INTO pouzivatelia (login, email, heslo, rola) VALUES (?, ?, ?, ?)";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $login);
            $statement->bindParam(2, $email);
            $statement->bindParam(3, $hashedPassword);
            $statement->bindParam(4, $this->rola);
            $statement->execute();
        }catch (Exception $e){
            echo "Chyba pri vkladaní dát do databázy: " . $e->getMessage();
        } finally {
            $this->connection=null;
        }
    }
    public function login($email, $password) {
        //Kontrola existencie používateľa
        $sql = "SELECT * FROM pouzivatelia WHERE email = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $email);
        $statement->execute();
        $user = $statement->fetch();
        if (!$user) {
            throw new Exception("Požívateľ s daným menom neexistuje.");
        }
        //Parameter heslo je názov stĺpca v db
        $storedPassword = $user['heslo'];
        // Overenie hesla
        if (!password_verify($password, $storedPassword)) {
            throw new Exception("Nesprávne heslo.");
        }
        // Spustenie session a uloženie informácií o používateľovi
        session_start();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['rola'] = $user['rola'];
    }
    public function logout() {
        session_start();
        session_unset(); // Vymazanie všetkých session premenných
        session_destroy();
        header('Location: http://localhost/cvicnasablona/index.php');
        exit();
    }
    public function isAdmin(){
        session_start();
        if (isset($_SESSION['rola']) && $_SESSION['user_id']) {
            if($_SESSION['rola'] == 'admin'){
                echo "admin je tu";
                return true;
            }else{
                echo "session sa spustil, ale nie je admin";
            }
        }else{
            echo "nenašiel sa session";
            return false;
        }
    }
}