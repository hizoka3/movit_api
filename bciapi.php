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


$first_name = $_POST["first_name"];
$cantidadCuotas = $_POST["cuotas"];
$montoCredito = $_POST["monto_credito_viaje"];
$chatfuel_user_id = $_POST["chatfuel_user_id"];
$messenger_user_id = $_POST["messenger_user_id"];
//$montoCredito = "1000000";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.us.apiconnect.ibmcloud.com/portal-api-developers-desarrollo/sandbox/creditos_consumo",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"rut\":\"13675361\",\"dv\":\"4\",\"montoCredito\":\"$montoCredito\",\"cantidadCuotas\":\"$cantidadCuotas\",\"fechaPrimerVencimiento\":\"26/07/2017\",\"canal\":\"110\",\"modalidad\":\"SG2\",\"tipoCredito\":\"UNI\",\"renta\":\"2000000\",\"codigoJournal\":\"1\",\"mesNoPago1\":0,\"mesNoPago2\":0}",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "content-type: application/json",
    "x-ibm-client-id: 2e6646e3-b372-477d-9fb2-f7c30323975d"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $credito = (array)json_decode($response);
  $aux = (array)json_decode($credito[0]);
    
  //echo '[{"text":"'. $first_name .', por tu crédito de '. money_format('%.0n', $credito["creditos_consumo"]->montoLiquido ) .' a '. $cantidadCuotas .' cuotas, pagarías '. money_format('%.0n', $credito["creditos_consumo"]->montoCuota ) .' en cada cuota. Al final del crédito habrás pagado '. money_format('%.0n', $credito["creditos_consumo"]->montoCredito ) . '."}]';
    
  echo '{
  "messages": [
    {
      "attachment": {
        "type": "template",
        "payload": {
          "template_type": "button",
          "text": "'. $first_name .', por tu crédito de '. money_format('%.0n', $credito["creditos_consumo"]->montoLiquido ) .' a '. $cantidadCuotas .' cuotas, pagarías '. money_format('%.0n', $credito["creditos_consumo"]->montoCuota ) .' en cada cuota. Al final del crédito habrás pagado '. money_format('%.0n', $credito["creditos_consumo"]->montoCredito ) .'.",
          "buttons": [
            {
              "type": "show_block",
              "block_name": "AceptaCredito",
              "title": "Tomar este crédito"
            },
            {
              "type": "show_block",
              "block_name": "Viaje",
              "title": "Volver"
            }
          ]
        }
      }
    }
  ]
}';    
    
    
}


$sql = "INSERT INTO bci_viaje (id, chatfuel_user_id, messenger_user_id, monto_credito, cuotas, rut) VALUES ('' , '$chatfuel_user_id' , '$messenger_user_id' , '$montoCredito' , '$cantidadCuotas', '')";

if ($conn->query($sql) === TRUE) {
    echo "true";
} else {
    echo "error";
}




?>