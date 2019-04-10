<?php

  $server = "mysql:dbname=compta;host=localhost";
  $user = "root";
  $pwd = "";

  $pdo = new pdo($server, $user, $pwd);

  $req = $pdo -> prepare("
    SELECT * FROM personne
    LEFT JOIN societe
    ON personne.soc_id = societe.soc_id
  ");

  $req -> execute();

  $resp = $req -> fetchAll(PDO::FETCH_ASSOC);

  foreach ($resp as $item){
    var_dump($item);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GOCIPapp</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<h1 class="bor">HELLO</h1>
</body>
</html>