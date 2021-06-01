<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Validate.
  if(trim($request->nom_prenom) === '' || (int)$request->tel1 < 0)
  {
    return http_response_code(400);
  }

  // Sanitize.
  $nom_prenom = mysqli_real_escape_string($con, trim($request->nom_prenom));
  $tel1 = mysqli_real_escape_string($con, (int)$request->tel1);
  $tel2 = mysqli_real_escape_string($con, (int)$request->tel2);
  $email = mysqli_real_escape_string($con, trim($request->email));
  $remarques = mysqli_real_escape_string($con, trim($request->remarques));


  // Create.
  $sql = "INSERT INTO `client`(`id`,`nom_prenom`,`tel1`,`tel2`,`email`,`remarques`) VALUES (null,'{$nom_prenom}','{$tel1}','{$tel2}','{$email}','{$remarques}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $client = [
      'nom_prenom' => $nom_prenom,
      'tel1' => $tel1,
      'tel2' => $tel2,
      'email' => $email,
      'remarques' => $remarques,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($client);
  }
  else
  {
    http_response_code(422);
  }
}
?>
