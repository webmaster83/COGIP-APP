		  <?php
	  $server = "mysql:dbname=compta;host=localhost";
  $user = "root";
  $pwd = "";

  $pdo = new pdo($server, $user, $pwd);
	// préparation del a requête insert 
		  $pdostat =  $pdo -> prepare ('INSERT INTO personne VALUES (NULL, :nom,:prenom, :mail,:tel) ');
		  
		  // lier chaque marqueur à une valeur 
		  $pdostat-> bindValue(':nom', $_POST['per_nom'], PDO::PARAM_STR);
		  $pdostat-> bindValue(':prenom', $_POST["per_prenom"], PDO::PARAM_STR);
		  $pdostat-> bindValue(':mail', $_POST["per_mail"], PDO::PARAM_STR);
		  $pdostat-> bindValue(':tel', $_POST["per_tel"], PDO::PARAM_STR);
		  
		  // excution requête preparer
		  $pdostat->execute();
		  
		  ?>