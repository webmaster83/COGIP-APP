<?php
function areParamsEmpty(){
  foreach(func_get_args() as $para){
    if(empty($_GET[$para])){
      return true;
    }else{
      continue;
    }
    return false;
  }
}
if(isset($_GET['submit'])){
  if(!areParamsEmpty('nom','prenom','mail','tel','soc')){
    $server = "mysql:dbname=compta;host=localhost";
    $user = "root";
    $pwd = "";
    $pdo = new pdo($server, $user, $pwd);
    $req = $pdo -> prepare("
      INSERT INTO personne(
        per_nom, per_prenom, per_mail, per_tel, soc_id
      )
      VALUES (?,?,?,?,?)
    ");
    $req -> execute([
      $_GET['nom'],$_GET['prenom'],$_GET['mail'],$_GET['tel'],$_GET['soc']
    ]);
    header('Location: index.php');
  }
}
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
function displaysoc(){
  $server = "mysql:dbname=compta;host=localhost";
  $user = "root";
  $pwd = "";
  $pdo = new pdo($server, $user, $pwd);
  $req = $pdo -> prepare("
    SELECT soc_id, soc_nom FROM societe
  ");
  $req -> execute();
  $resp = $req -> fetchAll(PDO::FETCH_ASSOC);
  foreach ($resp as $item){
    var_dump($item);
    echo '<option value="'.$item['soc_id'].'">'.$item['soc_nom'].'</option>';
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
    <form action="http://localhost/hl/70/index.php">
      <table>
        <tr>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Mail</th>
          <th>Numéro</th>
          <th>Société</th>
        </tr>
        <tr>
          <td><input name="nom" type="text"></td>
          <td><input name="prenom" type="text"></td>
          <td><input name="mail" type="email"></td>
          <td><input name="tel" type="text"></td>
          <td>
            <select name="soc">
              <?php displaysoc() ?>
            </select>
          </td>
          <td>
            <button name="submit" type="submit" formmethod="get">
              <img src="https://img.icons8.com/carbon-copy/22/000000/plus-2-math.png">
            </button>
          </td>
        </tr>
        <tr>
          <?php displaycontact() ?>
        </tr>
      </table>
    </form>
  </div>

</body>
</html>