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
    <?php
    $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "second_CRUD");



    $query = "SELECT * FROM pb_batiment";


    $result = mysqli_query($conn, $query);
    ?>

    <div class="container">
        <a href="./index.php">Retour</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Nature du problème</th>
                    <th scope="col">Etage du batiments</th>
                    <th scope="col">Numéro de la salle</th>
                    <th scope="col">Etat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "
                     <tr>
                         <th scope='row'> " . $row["id"] . "<td/>
                         <td> " . $row["Prenom"] . "<td/>
                         <td> " . $row["Nom"] . "<td/>
                         <td> " . $row["Naturepb"] . "<td/>
                         <td> " . $row["EtageBatiment"] . "<td/>
                         <td> " . $row["numSalle"] . "<td/>
                         <td>En cours de traitement ...<td/>
                         <button type='button' class='btn btn-danger' disabled>Déclaré</button>
                         <button type='button' class='btn btn-warning' disabled>Traitement</button>
                         <button type='button' class='btn btn-success' disabled>Traité</button>
                     <tr/>
                     ";
                }
                ?>
            </tbody>
        </table>


        <!-- <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Prénom</span>
            </div>
            <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Prénom</span>
            </div>
            <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Prénom</span>
            </div>
            <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div> -->
    </div>
</body>

</html>