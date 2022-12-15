<!DOCTYPE html>
<html>
<head>
	<title>Edition</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

<div class="container">


	<form method="POST" action="admin.php">
		<div class="mb-3">
			<label for="statut">Nouveau statut</label>
		 <select name="statut" id="statut" class="form-select" aria-label="Default select example">
		  <option value="déclaré">Déclaré</option>
		  <option value="en cours">En cours</option>
		  <option value="traité">Traité</option>
		</select>
		<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
		</div>
		<div class="col-12">
	    <button class="btn btn-primary" type="submit">
	    	Enregistrer
	  	</button>
	  </div>
  </form>



</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>