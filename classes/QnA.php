<?php
namespace otazkyodpovede;
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/classes/Database.php');
require_once(__ROOT__.'/classes/Users.php');
use Database;
use Users;
use PDO;
use Exception;
class QnA extends Database {
    protected $connection;
    public function __construct() {
        $this->connect();
        //Použitie gettera na získanie spojenia
        $this->connection = $this->getConnection();
    }
    public function getQnAById($id) {
        if (!is_numeric($id)) {
            echo 'ID otázky musí byť číslo.';
            exit;
        }
        $sql = "SELECT * FROM qna WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        // Získanie dát
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function updateQnA($id, $question, $answer) {
        if (!is_numeric($id)) {
            echo 'ID otázky musí byť číslo.';
            exit;
        }
        $sql = "UPDATE qna SET otazka = :question, odpoved = :answer WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->bindParam(':question', $question);
        $statement->bindParam(':answer', $answer);
        $statement->execute();
    }

    public function getQnA(){
        $sql = "SELECT * FROM qna";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        // Získanie dát
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $admin = new Users();
        if ($admin->isAdmin()) {
            // Zobrazenie tlačidiel na editáciu a vymazanie
            foreach ($data as $row) {
                echo '<div class="accordion">
                    <div class="question">' .
                    $row["otazka"] . '
                    <div class="buttons">
                        <a href="db/edit_qna.php?id=' . $row["ID"] . '">Editovať</a>
                        <a href="db/delete_qna.php?id=' . $row["ID"] . '">Vymazať</a>
                    </div>
                     </div>
                    <div class="answer">' .
                    $row["odpoved"] . '
                    </div>
            </div>';
            }
        } else {
            // Zobrazenie otázok a odpovedí
            if ($data) {
                echo '<section class="container">';
                foreach ($data as $row) {
                    echo '<div class="accordion">
                        <div class="question">' .
                        $row["otazka"] . '
                         </div>
                        <div class="answer">' .
                        $row["odpoved"] . '
                        </div>
                </div>';
                }
                echo '</section>';
            } else {
                echo "Neboli nájdené žiadne otázky a odpovede.";
            }
        }
    }
    public function deleteQnA($id) {
        if (!is_numeric($id)) {
            echo 'ID otázky musí byť číslo.';
            exit;
        }
        $sql = "DELETE FROM qna WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }
    public function insertQnA(){
        try {
            // Načítanie JSON súboru
            $data = json_decode(file_get_contents
            (__ROOT__.'/data/datas.json'), true);
            $otazky = $data["otazky"];
            $odpovede = $data["odpovede"];

            // Vloženie otázok a odpovedí v rámci transakcie
            $this->connection->beginTransaction();

            $sql = "INSERT IGNORE INTO qna (otazka, odpoved) VALUES (:otazka, :odpoved)";
            $statement = $this->connection->prepare($sql);

            for ($i = 0; $i < count($otazky); $i++) {
                $statement->bindParam(':otazka', $otazky[$i]);
                $statement->bindParam(':odpoved', $odpovede[$i]);
                $statement->execute();
            }
            $this->connection->commit();
            echo "Dáta boli vložené";
        } catch (Exception $e) {
            // Zobrazenie chybového hlásenia
            echo "Chyba pri vkladaní dát do databázy: " . $e->getMessage();
            $this->connection->rollback(); // Vrátenie späť zmien v prípade chyby
        } finally {
            // Uzatvorenie spojenia
            $this->connection = null;
        }
    }
}