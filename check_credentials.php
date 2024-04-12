<?php
$host = 'localhost';
$dbname = 'JIA';
$user = 'postgres';
$password = '09774245';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier les informations d'identification de l'utilisateur dans la base de données
    $sql = "SELECT * FROM administrateur WHERE username = :username AND mot_de_passe = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo 'success';
    } else {
        echo 'error';
    }

} catch (PDOException $e) {
    echo 'error';
}

$conn = null;
