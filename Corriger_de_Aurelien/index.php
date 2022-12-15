<?php
/*
Les docs qui m'ont aidé :
- https://www.php.net/manual/fr/mysqli-stmt.bind-param.php
- 
*/
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
  <link rel="stylesheet" href="style.css">
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
    $mysqli = new mysqli("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "docker");

    if (mysqli_connect_errno()) {
      printf("Échec de la connexion : %s\n", mysqli_connect_error());
      exit();
    }


    /*
    Ajout d'un contact
    */
    if (isset($_GET["action"]) && $_GET["action"] == "add") {

      $stmt = $mysqli->prepare("INSERT INTO user (firstname, lastname, phone) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $_GET["firstname"], $_GET["lastname"], $_GET["phone"]);
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

      $stmt = $mysqli->prepare("DELETE FROM user WHERE id = ?");
      $stmt->bind_param("i", $_GET["id"]);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        echo '<div class="alert alert-primary" role="alert">';
        echo "Contact numéro " . $_GET["id"] . " supprimé avec succès !";
        echo "</div>";
      } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Un problème a eu lieu pendant la suppression du contact !";
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

      $stmt = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
      $stmt->bind_param("i", $_GET["id"]);
      $stmt->execute();

      $stmt->bind_result($id, $firstname, $lastname, $phone);
      $stmt->fetch();

      echo '<div class="alert alert-primary" role="alert">';
      echo "Modification en cours ($id ; $firstname ; $lastname ; $phone)";
      echo "</div>";

      $stmt->close();
    }



    /*
    Enregistrement de la modification
    */
    if (isset($_GET["action"]) && $_GET["action"] == "update") {

      $stmt = $mysqli->prepare("UPDATE user SET firstname = ?, lastname = ?, phone = ? WHERE id = ?");
      $stmt->bind_param("sssi", $_GET["firstname"], $_GET["lastname"], $_GET["phone"], $_GET["id"]);
      $stmt->execute();

      if ($stmt->affected_rows > 0) {
        echo '<div class="alert alert-primary" role="alert">';
        echo "Modification réalisée avec succès !";
        echo "</div>";
      } else {
        echo '<div class="alert alert-danger" role="alert">';
        echo "Un problème a eu lieu pendant la modification du contact !";
        echo "</div>";
      }

      $stmt->close();
    }




    /*
    Récupération du carnet d'adresses
    */

    $result = $mysqli->query("SELECT * FROM user");

    ?>





    <h1>Mon carnet d'adresse !</h1>

    <table class="table">
      <tr>
        <th>ID</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Téléphone</th>
        <th>&nbsp;</th>
      </tr>


      <?php

      while ($row = $result->fetch_assoc()) {

        $ligne = "
        <tr>
          <td>" . $row["id"] . "</td>
          <td>" . $row["firstname"] . "</td>
          <td>" . $row["lastname"] . "</td>
          <td>" . $row["phone"] . "</td>
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
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" class="form-control" id="firstname" aria-describedby="firstName"
              placeholder="Entrez votre prénom">
          </div>

          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Entrez votre prénom">
          </div>

          <div class="form-group">
            <label for="phone">Téléphone</label>
            <input type="text" name="phone" class="form-control" id="phone"
              placeholder="Entrez votre numéro de téléphone">
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
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" value="<?= $firstname ?>" class="form-control" id="firstname"
              aria-describedby="firstName" placeholder="Entrez votre prénom">
          </div>

          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" value="<?= $lastname ?>" class="form-control" id="lastname"
              placeholder="Entrez votre prénom">
          </div>

          <div class="form-group">
            <label for="phone">Téléphone</label>
            <input type="text" name="phone" value="<?= $phone ?>" class="form-control" id="phone"
              placeholder="Entrez votre numéro de téléphone">
          </div>

          <input type="hidden" name="id" value="<?= $id ?>" />
          <input type="hidden" name="action" value="update" />

          <button type="submit" class="btn btn-primary">Modifier !</button>
        </form>

        <?php endif ?>
      </div>


    </div>



</body>

</html>