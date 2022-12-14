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
    Connexion à la base de données
    */
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "second_CRUD");

    if (mysqli_connect_errno()) {
      printf("Échec de la connexion : %s\n", mysqli_connect_error());
      exit();
    }


    /*
    Ajout d'un contact
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

    /*
    Suppression d'un contact
    */
    if (isset($_GET["action"]) && $_GET["action"] == "delete") {

      $stmt = $mysqli->prepare("DELETE FROM pb_batiment WHERE id = ?");
      $stmt->bind_param("i", $_GET["id"]);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        echo '<div class="alert alert-primary" role="alert">';
        echo "Ticket numéro " . $_GET["id"] . " supprimé avec succès !";
        echo "</div>";
      } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Un problème a eu lieu pendant la suppression du ticket !";
        echo "</div>";
      }
    }




    /*
    Modification d'un contact
    Cette étape se passe en deux étapes :
    1 - préchargement du formulaire de modification (prepareupdate)
    2 - enregistrement de la modification (update)
    */
    if (isset($_GET["action"]) && $_GET["action"] == "prepareupdate") {

      $stmt = $mysqli->prepare("SELECT * FROM pb_batiment WHERE id = ?");
      $stmt->bind_param("i", $_GET["id"]);
      $stmt->execute();

      $stmt->bind_result($id, $Prenom, $Nom, $Naturepb, $EtageBatiment, $numSalle);
      $stmt->fetch();

      echo '<div class="alert alert-primary" role="alert">';
      echo "Modification en cours ($id ; $Prenom; $Nom; $Naturepb; $EtageBatiment; $numSalle)";
      echo "</div>";

      $stmt->close();
    }



    /*
    Enregistrement de la modification
    */
    if (isset($_GET["action"]) && $_GET["action"] == "update") {

      $stmt = $mysqli->prepare("UPDATE user SET Prenom = ?, Nom = ?, Naturepb = ?, EtageBatiment = ?, numSalle = ? WHERE id = ?");
      $stmt->bind_param("sssssi", $_GET["Prenom"], $_GET["Nom"], $_GET["Naturepb"], $_GET["EtageBatiment"], $_GET["numSalle"], $_GET["id"]);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        echo '<div class="alert alert-primary" role="alert">';
        echo "Modification réalisée avec succès !";
        echo "</div>";
      } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Un problème a eu lieu pendant la modification du ticket !";
        echo "</div>";
      }

      $stmt->close();
    }




    /*
    Récupération de la liste complète des problèmes déclarés
    */

    $result = $mysqli->query("SELECT * FROM pb_batiment");

    ?>





    <h1>Les problèmes déclarés !</h1>

    <table class="table">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Prénom</th>
        <th scope="col">Nom</th>
        <th scope="col">Nature du problème</th>
        <th scope="col">Etage du batiments</th>
        <th scope="col">Numéro de la salle</th>
        <th scope="col">Etat</th>
      </tr>


      <?php

      while ($row = $result->fetch_assoc()) {

        $ligne = "
        <tr>
        <th scope='row'> " . $row["id"] . "<td/>
        <td> " . $row["Prenom"] . "<td/>
        <td> " . $row["Nom"] . "<td/>
        <td> " . $row["Naturepb"] . "<td/>
        <td> " . $row["EtageBatiment"] . "<td/>
        <td> " . $row["numSalle"] . "<td/>
        <td>En cours de traitement ...<td/>
          <td>
          <a href='?action=prepareupdate&id=" . $row["id"] . "'class='btn btn-success'>modifier</a>
          <a href='?action=delete&id=" . $row["id"] . "'class='btn btn-danger'>supprimer</a>
            
          </td>
        </tr>
      ";

        echo $ligne;
      }


      ?>


    </table>





    <div class="row">
      <div class="col">


        <h2>Ajouter un contact</h2>
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

      <div class="col">

        <?php if (isset($_GET["action"]) && $_GET["action"] == "prepareupdate"): ?>

        <h2>Modifier un contact existant</h2>



        <form action="index.php" method="get">

          <div class="form-group">
            <label for="Prenom">Prénom</label>
            <input type="text" name="Prenom" value="<?= $Prenom ?>" class="form-control" id="Prenom"
              aria-describedby="Prenom" placeholder="Entrez votre prénom">
          </div>

          <div class="form-group">
            <label for="Nom">Nom</label>
            <input type="text" name="Nom" value="<?= $Nom ?>" class="form-control" id="Nom"
              placeholder="Entrez votre nom">
          </div>

          <div class="form-group">
            <label for="EtageBatiment">Etage du batiment</label>
            <input type="text" name="EtageBatiment" value="<?= $EtageBatiment ?>" class="form-control"
              id="EtageBatiment" placeholder="Entrez le numéro de l'étage concerner ">
          </div>
          <div class="form-group">
            <label for="numSalle">Numéro de la salle</label>
            <input type="text" name="numSalle" value="<?= $numSalle ?>" class="form-control" id="numSalle"
              placeholder="Entrez le numéro de la salle concerner ">
          </div>
          <div class="form-group">
            <label for="Naturepb">Quel est votre problème ?</label>
            <textarea type="text" name="Naturepb" value="<?= $Naturepb ?>" class="form-control" id="Naturepb"
              placeholder=""></textarea>
          </div>

          <input type="hidden" name="action" value="<?= $id ?>" />

          <button type="submit" class="btn btn-primary">Ajouter !</button>
        </form>

        <?php endif ?>
      </div>


    </div>



</body>

</html>