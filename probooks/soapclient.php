<?php
  $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl");
  $params = array(
    "arg0" => $_POST['judul']
  );
  $response = $client->__soapCall("searchBook", $params);
  $books = json_encode($response);
  echo($books);
?>