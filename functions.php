<?php
function getNameModel($id, $con)
{
  $sql = "select nom FROM `model` WHERE `id` ='{$id}' LIMIT 1";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['nom'];
  } else {
    return ' ';
  }
}
function getNomArticle($id, $con)
{
  $sql = "select reference FROM `articles` WHERE `id` ='{$id}' LIMIT 1";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['reference'];
  } else {
    return ' ';
  }
}
function getNomFourni($id, $con)
{
  $sql = "select nomprenom FROM `fournis` WHERE `id` ='{$id}' LIMIT 1";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['nomprenom'];
  } else {
    return ' ';
  }
}
function getNomTransp($id, $con)
{
  $sql = "select nomprenom FROM `transp` WHERE `id` ='{$id}' LIMIT 1";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['nomprenom'];
  } else {
    return ' ';
  }
}
function get_insert_cmd($con)
{
  $sql = "INSERT INTO `cmd_achat`() VALUES ()";
  $con->query($sql);
  return $con->insert_id;
}
function getinfocmd($id_cmd, $con)
{
  $sql = "SELECT id_fourni,total FROM cmd_achat where id=" . $id_cmd;
  $result = $con->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return [$row['id_fourni'], $row['total']];
  } else {
    return [0, 0];
  }
}
function getinfocmdtransp($id_cmd, $con)
{
  $sql = "SELECT id_transp,transport FROM cmd_achat where id=" . $id_cmd;
  $result = $con->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return [$row['id_transp'], $row['transport']];
  } else {
    return [0, 0];
  }
}
function getArticleModelQte($id_article, $con)
{
  $sql = "select * FROM `articles_model` WHERE `id_article` ='{$id_article}'";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    return $result;
  } else {
    return false;
  }
}
function get_product($id_article, $con)
{
  $sql = "select reference,titre FROM `articles` where id='" . $id_article . "'";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return  $row["reference"] . " : " . $row["titre"];
  }
  return "";
}
function get_model($id_model, $con)
{
  $sql = "select nom FROM `model` where id='" . $id_model . "'";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return  $row["nom"];
  }
  return "";
}
