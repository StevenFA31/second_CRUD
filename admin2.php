<?php
include './connection.php'
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
    <div class="container">
        <a href="./index.php">Retour</a>
        <div class="row">
            <div class="col">
                <?php

                /*
                Récupération de la liste complète des problèmes déclarés
                */

                $result = $mysqli->query("SELECT * FROM pb_batiment");

                /*
                Suppression d'un ticket
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
                Ajout d'un ETAT sur le ticket
                */
                if (isset($_GET["actions"]) && $_GET["actions"] == "modif") {

                    // $sql = "UPDATE pb_batiment SET Etat='test' WHERE id= ?";
                

                    $stmt = $mysqli->prepare("UPDATE pb_batiment SET Etat='polo' WHERE id= ?");
                    $stmt->bind_param("i", $_GET["id"]);
                    $stmt->execute();

                    // $Etat = "Test";
                
                    if ($stmt->affected_rows > 0) {
                        echo '<div class="alert alert-primary" role="alert">';
                        echo "Etat inséré avec succès !";
                        echo "</div>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo "Un problème a eu lieu pendant l'ajout de l'etat !";
                        echo "</div>";
                    }
                }



                ?>
                <h1>Les problèmes déclarés !</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Nature du problème</th>
                            <th>Etage du batiments</th>
                            <th>Numéro de la salle</th>
                            <th>Etat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($row = $result->fetch_assoc()) {

                            $ligne = "
        <tr>
        <td> " . $row["id"] . "<td/>
        <td> " . $row["Prenom"] . "<td/>
        <td> " . $row["Nom"] . "<td/>
        <td> " . $row["Naturepb"] . "<td/>
        <td> " . $row["EtageBatiment"] . "<td/>
        <td> " . $row["numSalle"] . "<td/>
        <td> " . $row["Etat"] . "<td/>
          <td>

          <div class='dropdown'>
          <a class='btn btn-secondary dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-bs-toggle='dropdown' aria-expanded='false'>
            Etat
          </a>
        
          <ul class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
            <li><a class='dropdown-item' href='?actions=modif&id=" . $row["id"] . "'>Action</a></li>
            <li><a class='dropdown-item' href='?actionss=&id='>Another action</a></li>
            <li><a class='dropdown-item' href='?actionss=&id='>Something else here</a></li>
          </ul>
        </div>
          
          <a href='?action=delete&id=" . $row["id"] . "'class='btn btn-danger'>supprimer</a>

          </td>
        </tr>
      ";

                            echo $ligne;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
                crossorigin="anonymous"></script>

</body>

</html>