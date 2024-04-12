<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'JIA';
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
        $sql = "INSERT INTO inscriptions (nom, contact, courriel, poste, societe, theme, date_inscription) VALUES (:nom, :contact, :courriel, :poste, :societe, :theme, :date_inscription)";
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
        echo "<script>alert('Inscription réussie');</script>";
    }

} catch (PDOException $e) {
    $erreur = "Erreur de connexion : " . $e->getMessage();
    echo "<script>alert('$erreur');</script>";
} catch (Exception $e) {
    $erreur = "Erreur de requête : " . $e->getMessage();
    echo "<script>alert('$erreur');</script>";
}

// Fermeture de la connexion
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>TheEvent - Bootstrap Event Template</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">   
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/venobox/venobox.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
  
  <script src="https://smtpjs.com/v3/smtp.js"></script>


</head>

<body>

  <!--==========================
    Header
  ============================-->


    <!--==========================
      About Section
    ============================-->
    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6"> <!-- Header -->

          
            
          <nav id="nav-menu-container">
  <h2>Inscription</h2>
  <ul class="nav-menu">
    <li class="buy-tickets"><a href="index.html">Acceuil</a></li>
  </ul>
  <div class="col-12 text-center">
  <button type="button" class="btn btn-primary" id="admin-login-btn">Espace Admin</button>
</div>

<!-- Modal -->
<div class="modal fade" id="adminLoginModal" tabindex="-1" role="dialog" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminLoginModalLabel">Connexion Administrateur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="admin-login-form">
          <div class="form-group">
            <label for="admin-username" style="color: black;">Nom d'utilisateur</label>
            <input type="text" id="admin-username" name="username" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="admin-password" style="color: black;">Mot de passe</label>
            <input type="password" id="admin-password" name="password" class="form-control" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Connexion</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Ajout : Modal pour afficher le message de connexion réussie et le bouton de téléchargement -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Connexion réussie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Connexion validée !</p>
        <a id="download-excel-button" class="btn btn-success" href="#" role="button">Télécharger le fichier Excel</a>
      </div>
    </div>
  </div>
</div>

</nav>


        </div>
        <section class="inscription-section section-with-bg">
          <div class="container">
            <div class="section-header">
              <h2>S'inscrire maintenant</h2>
              <p>Remplissez le formulaire ci-dessous pour vous inscrire à notre conférence.</p>
            </div>
            <form id="inscription-form" class="row" action="" method="post">
              <div class="col-md-6 form-group">
                <label for="sendername">Nom et Prénoms:</label>
                <input type="text" id="sendername" name="nom" class="form-control" required>
              </div>
              <div class="col-md-6 form-group">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" class="form-control" required>
              </div>
              <div class="col-md-6 form-group">
                <label for="replyto">Courriel:</label>
                <input type="email" id="replyto" name="courriel" class="form-control" required>
              </div>
              <div class="col-md-6 form-group">
                <label for="message">Titre du poste:</label>
                <input type="text" id="message" name="poste" class="form-control" required>
              </div>
              <div class="col-md-6 form-group">
                <label for="societe">Société/Organisation:</label>
                <input type="text" id="societe" name="societe" class="form-control" required>
              </div>
              <div class="col-md-6 form-group">
                <div>
                  <label for="theme">Par quel thème êtes-vous intéressé ?</label><br>
                  <input type="checkbox" id="conference" name="theme[]" value="conference">
                  <label for="conference">Conférence inaugurale</label><br>
                  <input type="checkbox" id="panel1" name="theme[]" value="panel1">
                  <label for="panel1">Panel 1</label><br>
                  <input type="checkbox" id="panel2" name="theme[]" value="panel2">
                  <label for="panel2">Panel 2</label><br>
                </div>
                
              </div>
              <div class="col-12 text-center">
                <button  type="submit" class="btn btn-primary">Valider Mon Inscription</button
              >
              </div>
            </form>
          </div>
        </section>
        </div>
        </div>
        </section>
  
  <!--==========================
    Intro Section
  ============================-->
  <!-- Navbar -->
 
 

  <!-- Inscription Form -->
  

      <script>
      // Assurez-vous d'inclure la bibliothèque Axios avant ce code

document.getElementById('open-admin-login-btn').addEventListener('click', function() {
    $('#adminLoginModal').modal('show');
});

document.getElementById('admin-login-form').addEventListener('submit', async (event) => {
  event.preventDefault();

  const username = document.getElementById('admin-username').value;
  const password = document.getElementById('admin-password').value;

  try {
    const response = await axios.post('/api/admin-login.php', {
      username,
      password,
    });

    if (response.data.success) {
      // Si la connexion est réussie, affichez le popup de succès
      $('#adminLoginModal').modal('hide');
      $('#successModal').modal('show');

      // Ajoutez un gestionnaire d'événements pour le bouton de téléchargement du fichier Excel
      document.getElementById('download-excel-button').addEventListener('click', () => {
        // Générez et téléchargez le fichier Excel contenant la liste des utilisateurs
        window.location.href = '/api/download-excel.php';
      });
    } else {
      // Si la connexion échoue, affichez un message d'erreur
      alert(response.data.message);
    }
  } catch (error) {
    console.error(error);
    alert('Une erreur s\'est produite lors de la connexion. Veuillez réessayer.');
  }
});

// Assurez-vous d'inclure la bibliothèque jQuery après ce code

  </script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>

</html>
