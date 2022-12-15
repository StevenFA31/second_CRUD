<?php
include './connection.php'
  ?>

<!DOCTYPE html>
<html lang="fr-FR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>


</head>

<body>

  <div class="container">
    <?php
    /*
    Ajout d'un ticket
    */
    if (isset($_GET["action"]) && $_GET["action"] == "add") {

      $stmt = $mysqli->prepare("INSERT INTO pb_batiment (Prenom, Nom, Naturepb, EtageBatiment, numSalle) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $_GET["Prenom"], $_GET["Nom"], $_GET["Naturepb"], $_GET["EtageBatiment"], $_GET["numSalle"]);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        echo '<div class="alert alert-primary" role="alert">';
        echo "Contact inséré avec succès !";
        echo "</div>";
      } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Un problème a eu lieu pendant l'ajout du contact !";
        echo "</div>";
      }
    }
    ?>


    <h2>Ajouter un ticket</h2>
    <form action="index.php" method="get">

      <div class="form-group">
        <label for="Prenom">Prénom</label>
        <input type="text" name="Prenom" class="form-control" id="Prenom" aria-describedby="Prenom"
          placeholder="Entrez votre prénom">
      </div>

      <div class="form-group">
        <label for="Nom">Nom</label>
        <input type="text" name="Nom" class="form-control" id="Nom" placeholder="Entrez votre nom">
      </div>

      <div class="form-group">
        <label for="EtageBatiment">Etage du batiment</label>
        <input type="text" name="EtageBatiment" class="form-control" id="EtageBatiment"
          placeholder="Entrez le numéro de l'étage concerner ">
      </div>
      <div class="form-group">
        <label for="numSalle">Numéro de la salle</label>
        <input type="text" name="numSalle" class="form-control" id="numSalle"
          placeholder="Entrez le numéro de la salle concerner ">
      </div>
      <div class="form-group">
        <label for="Naturepb">Quel est votre problème ?</label>
        <textarea type="text" name="Naturepb" class="form-control" id="Naturepb" placeholder=""></textarea>
      </div>

      <input type="hidden" name="action" value="add" />

      <button type="submit" class="btn btn-primary">Ajouter !</button>
    </form>

  </div>
  <a href="./admin2.php">Liste complète des problèmes déclarés</a>
  </div>

</body>

</html>