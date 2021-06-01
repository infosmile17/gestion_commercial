<?php
require '../database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
return $request;
  // Validate.
  if ((int)$request->id < 1 || trim($request->nom_prenom) === '' || (int)$request->tel1 < 0 ) {
    return http_response_code(400);
  }

  // Sanitize.
   $id = mysqli_real_escape_string($con, (int)$request->id);
   $nom_prenom = mysqli_real_escape_string($con, trim($request->nom_prenom));
   $tel1 = mysqli_real_escape_string($con, (int)$request->tel1);
   $tel2 = mysqli_real_escape_string($con, (int)$request->tel2);
   $email = mysqli_real_escape_string($con, trim($request->email));
   $remarques = mysqli_real_escape_string($con, trim($request->remarques));

  // Update.
  $sql = "UPDATE `client` SET `$nom_prenom`='$nom_prenom',`tel1`='$tel1',`tel2`='$tel2',`email`='$email',`remarques`='$remarques' WHERE `id` = '{$id}' LIMIT 1";
var_dump($sql);
  if(mysqli_query($con, $sql))
  {
    http_response_code(204);
  }
  else
  {
    return http_response_code(422);
  }  
}
?>
