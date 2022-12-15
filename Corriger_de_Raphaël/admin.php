<!DOCTYPE html>
<html>
<head>
	<title><?php echo 'Titre'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

<div class="container">

<?php

$servername = "127.0.0.1";
$username = "passpartout";
$password = "azerzer";
$db = "tickets";

// Connection à la base de données
$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);


// Je check si on doit changer le statut
if (isset($_POST["statut"])) {
	$requete = "UPDATE probleme SET statut = :statut WHERE id = :id";
	$query = $conn->prepare($requete);
	$query->bindParam(':statut', $_POST["statut"]);
	$query->bindParam(':id', $_POST["id"]);
	$result = $query->execute();

	if ($result) {
		echo "Le staut à bien été changé";
	}
	else {
		echo 'Erreur';
	}
}


// Je vérifie que le formulaire à bien été envoyé
if(isset($_POST['nom'])) {
	$nom = $_POST['nom'];
	$batiment = $_POST['batiment'];
	$pb = $_POST['probleme'];

	// Création de la requête
	$requete = "INSERT INTO `probleme` (`nom`, `batiment`, `probleme`) VALUES (:nom, :bat, :pb);";

	$query = $conn->prepare($requete);
	$query->bindParam(':nom', $nom);
	$query->bindParam(':bat', $batiment);
	$query->bindParam(':pb', $pb);
	$result = $query->execute();

	if($result) {
	?>
		<div class="toast show align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
		  <div class="d-flex">
		    <div class="toast-body">
			    Le ticket à bien été créé.
		    </div>
		    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
		  </div>
		</div>
		<?php
	} else {
		?>
			<div class="toast show align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
		  <div class="d-flex">
		    <div class="toast-body">
			    Une erreur est survenue
		    </div>
		    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
		  </div>
		</div>
		<?php
	}
} 

?>
	<h1>Liste des tickets</h1>

	<table class="table table-striped table-hover">
	  <thead>
	    <tr>
	      <th scope="col">ID</th>
	      <th scope="col">Nom</th>
	      <th scope="col">Batiment</th>
	      <th scope="col">Description</th>
	      <th scope="col">Statut</th>
	      <th scope="col"></th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php 
	 	$requete= "SELECT * from probleme";
		$data=$conn ->query($requete);
		foreach ($data as $row) {
				?>
	    <tr>
	      <th scope="row"><?php echo $row['id']?></th>
	      <td><?php echo $row['nom']?></td>
	      <td><?php echo $row['batiment']?></td>
	      <td><?php echo $row['probleme']?></td>
	      <td><?php echo $row['statut']?></td>
	      <td><a href="edit.php?id=<?php echo $row['id'] ?>">Modifier</a></td>
	    </tr>
				<?php
		}
	  	?>

	  </tbody>
	</table>
	

</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>