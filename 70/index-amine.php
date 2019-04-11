<?php
function displaycontact(){
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
    echo '<tr>';
    foreach ($item as $key => $val) {
      switch($key){
        case 'per_id': case 'soc_id': case 'soc_tel': case 'soc_tva':  case 'soc_pays': break;
        default :
          echo '<td>'.$val.'</td>';
      }
    }
    echo '</tr>';
  }
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

    <div class="contain">
      <table>
        <tr>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Mail</th>
          <th>Numéro</th>
          <th>Companie</th>
        </tr>
        <tr>
          <form action="envois-amine.php" method="post">
            <td><input type="text" name="per_nom"></td>
            <td><input type="text" name="per_prenom"></td>
            <td><input type="email" name="per_mail"></td>
            <td><input type="text" name="per_tel"></td>
            <td>
              <select name="soc_id">
                <option value="1">COGIP</option>
                <option value="2">APPLE</option>
                <option value="3">MICROSOFT</option>
              </select>
            </td>
            <td>
              <button>
                <img src="https://img.icons8.com/carbon-copy/22/000000/plus-2-math.png">
              </button>
            </td>
          </form>
        </tr>
          <?php displaycontact() ?>
		  

		
	
		  
        </tr>
      </table>
    </div>

</body>
</html>