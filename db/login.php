<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/classes/Users.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Overenie údajov
if (empty($email) || empty($password)) {
    die('Chyba: Všetky polia sú povinné!');
}
// Uloženie správy do databázy
try {
    $user = new Users();
    $user->login($email, $password);
    return header('Location: http://localhost/cvicnasablona/index.php');
}catch (Exception $e){
    http_response_code(404);
    echo("Chyba: " . $e->getMessage());
}

