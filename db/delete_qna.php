<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/classes/QnA.php');
use otazkyodpovede\QnA;
session_start();

if (!isset($_SESSION['rola']) || !$_SESSION['user_id']) {
    header('Location: db/login.php');
    exit;
}
$id = $_GET['id']; // Získanie ID z URL
$qna = new QnA();
$admin = new Users();
if (!$admin->isAdmin()) {
    echo 'Nemáte oprávnenie na mazanie otázky a odpovede.';
    exit;
}
$row = $qna->getQnAById($id);
if (!$row) {
    echo 'Otázka s daným ID nebola nájdená.';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qna->deleteQnA($id);
    header('Location: ../qna.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja stránka</title>
    <link rel='stylesheet' href='../css/style.css'>
    <link rel='stylesheet' href='../css/banner.css'>
    <link rel='stylesheet' href='../css/form.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<main>
    <section class="banner">
        <div class="container text-white">
            <h1>Vymazanie otázky a odpovede</h1>
        </div>
    </section>
    <div class="row">
        <p>Ste si istí, že chcete vymazať túto otázku a odpoveď?</p>
        <p><?php echo $row['otazka']; ?></p>
        <p><?php echo $row['odpoved']; ?></p>
        <form action="delete_qna.php?id=<?php echo $id; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"
            <div class="row">
            <input type="submit" value="Vymazať">
            <button type="button" onClick="location.href='../qna.php'">Zrušiť</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
