<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "second_CRUD");
    $query = "SELECT * FROM pb_batiment";
    $result = mysqli_query($conn, $query);

    $stmt = mysqli_prepare($conn, "INSERT INTO pb_batiment VALUES (Prenom, Nom, Naturepb, EtageBatiment, numSalle)");
    ?>

    <div class="container">


        <form method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Prénom</label>
                <input type="text" name="Prenom" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nom</label>
                <input type="text" name="Nom" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Etage du batiment</label>
                <input type="text" name="EtageBatiment" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Numéro de la salle</label>
                <input type="text" name="numSalle" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Quel est votre problème ?</label>
                <textarea name="Naturepb" class="form-control" aria-label="With textarea"></textarea>
            </div>

            <button name="valider" type="submit" class="btn btn-primary">Envoyez</button>
        </form>

        <a href="./admin.php">Liste complète des problèmes déclarés</a>

        <?php
        //         $sql = "INSERT INTO pb_batiment (Prenom, Nom, Naturepb, EtageBatiment, numSalle)
// VALUES ('" . $Prenom . "','" . $Nom . "', '" . $Naturepb . "', '" . $numSalle . "', '" . $EtageBatiment . "')";
        
        //         if (isset($_POST['valider'])) {
//             $Prenom = $_POST['Prenom'];
//             $Nom = $_POST['Nom'];
//             $EtageBatiment = $_POST['EtageBatiment'];
//             $numSalle = $_POST['numSalle'];
//             $Naturepb = $_POST['Naturepb'];
//             $stmt = mysqli_prepare($conn, $sql);
//             mysqli_stmt_execute($stmt);
//             echo "Vôtre demande a bien était envoyez !";
//         } else {
//             echo "Il y à eu une erreur ... Veuillez réessayez !";
//         }
        



        // if ($conn->query($sql) === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }
        
        // $stmt = mysqli_prepare($conn, "INSERT INTO pb_batiment VALUES (Prenom, Nom, Naturepb, EtageBatiment, numSalle)");
        // mysqli_stmt_bind_param($stmt, 'sssd', $code, $language, $official, $percent);
        
        // $code = 'DEU';
        // $language = 'Bavarian';
        // $official = "F";
        // $percent = 11.2;
        
        // mysqli_stmt_execute($stmt);
        
        // printf("%d row inserted.\n", mysqli_stmt_affected_rows($stmt));
        

        // if () {
//     while (){
//     $stmt = mysqli_prepare($conn, "INSERT INTO pb_batiment VALUES (Prenom, Nom, Naturepb, EtageBatiment, numSalle)");
//     mysqli_stmt_execute($stmt);
        
        //     }
// }
        ?>
    </div>
</body>

</html>