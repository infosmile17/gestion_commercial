<?php
/**
 * Returns the list of policies.
 */
require '../database.php';

$clients = [];
$sql = "SELECT * FROM client";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $clients[$i]['id']    = $row['id'];
    $clients[$i]['nom_prenom'] = $row['nom_prenom'];
    $clients[$i]['tel1'] = $row['tel1'];
    $clients[$i]['tel2'] = $row['tel2'];
    $clients[$i]['email'] = $row['email'];
    $clients[$i]['remarques'] = $row['remarques'];
    $clients[$i]['date_ajout'] = $row['date_ajout'];
    $i++;
  }

  echo json_encode($clients);
}
else
{
  http_response_code(404);
}
?>
