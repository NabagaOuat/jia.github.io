<?php
$host = 'localhost';
$dbname = 'JIA';
$user = 'postgres';
$password = '09774245';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionner toutes les inscriptions dans la base de données
    $sql = "SELECT * FROM inscriptions";
    $stmt = $conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Définir les en-têtes de réponse pour télécharger un fichier CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="inscriptions.csv"');

    // Écrire les données dans le fichier CSV
    $output = fopen('php://output', 'w');
    fputcsv($output, array_keys($rows[0]));
    foreach ($rows as $row) {
        fputcsv($output, $row);
    }
    fclose($output);

} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}

$conn = null;
