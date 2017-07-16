<?php
setlocale(LC_MONETARY, 'es_CL.UTF-8');

$servername = "internal-db.s215013.gridserver.com";
$username = "db215013_bci";
$password = "+#9*vXSudq4";
$dbname = "db215013_bci";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('[{"text":"Conexión fallida}]');
} 


$chatfuel_user_id = $_POST["chatfuel_user_id"];
$messenger_user_id = $_POST["chatfuel_user_id"];

$url_image_carnet = $_POST["url_image_carnet"];
$url_image_carnet_back = $_POST["url_image_carnet_back"];
$sueldo_promedio  = $_POST["sueldo_promedio"];
$liquidacion = $_POST["liquidacion"];


//$sql = "INSERT INTO bci_credito (id, chatfuel_user_id, messenger_user_id, acepta_credito, url_image_carnet, url_image_carnet_back) VALUES ('' , '$chatfuel_user_id' , '$messenger_user_id' , '$acepta_credito' , '$url_image_carnet' , '$url_image_carnet_back' )";


$sql = "UPDATE bci_credito SET url_image_carnet='$url_image_carnet', url_image_carnet_back='$url_image_carnet_back', sueldo_promedio='$sueldo_promedio', liquidacion='$liquidacion' WHERE chatfuel_user_id='$chatfuel_user_id'";


if ($conn->query($sql) === TRUE) {
    echo "true";
} else {
    echo "error";
}




?>