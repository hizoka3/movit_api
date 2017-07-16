<?
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

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$messenger_user_id = $_POST["messenger_user_id"];
$profile_pic_url = $_POST["profile_pic_url"];
$chatfuel_user_id = $_POST["chatfuel_user_id"];




$sql = "INSERT INTO bci_perfil (id, first_name, last_name, messenger_user_id, profile_pic_url, chatfuel_user_id) VALUES ('', '$first_name' , '$last_name' , '$messenger_user_id' , '$profile_pic_url' , '$chatfuel_user_id')";

if ($conn->query($sql) === TRUE) {
    echo "true";
} else {
    echo "error";
}

$conn->close();
echo '[{"text":"Ok, lo tengo!"}]';
?>