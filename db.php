<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'inscriptions';
$user = 'postgres';
$password = '09774245';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des valeurs du formulaire
        $nom = $_POST["nom"];
        $contact = $_POST["contact"];
        $courriel = $_POST["courriel"];
        $poste = $_POST["poste"];
        $societe = $_POST["societe"];
        $theme = implode(",", $_POST["theme"]);
        $date_inscription = date("Y-m-d H:i:s");

        // Requête SQL d'insertion
        $sql = "INSERT INTO votre_table (nom, contact, courriel, poste, societe, theme, date_inscription) VALUES (:nom, :contact, :courriel, :poste, :societe, :theme, :date_inscription)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':courriel', $courriel);
        $stmt->bindParam(':poste', $poste);
        $stmt->bindParam(':societe', $societe);
        $stmt->bindParam(':theme', $theme);
        $stmt->bindParam(':date_inscription', $date_inscription);

        // Exécution de la requête SQL
        $stmt->execute();
        echo "Inscription réussie";
    }

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur de requête : " . $e->getMessage();
}

// Fermeture de la connexion
$conn = null;
