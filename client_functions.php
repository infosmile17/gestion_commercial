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
function getNomclient($id, $con)
{
  $sql = "select nomprenom FROM `clients` WHERE `id` ='{$id}' LIMIT 1";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['nomprenom'];
  } else {
    return false;
  }
}
function get_insert_cmd($con)
{
  $sql = "INSERT INTO `cmd_vente`() VALUES ()";
  $con->query($sql);
  return $con->insert_id;
}
function getinfocmd($id_cmd, $con)
{
  $sql_info = "SELECT id_client,total FROM cmd_vente where id=" . $id_cmd;
  $result_info = $con->query($sql_info);

  if ($result_info->num_rows > 0) {
    $row_info = $result_info->fetch_assoc();
    return [$row_info['id_client'], $row_info['total']];
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
