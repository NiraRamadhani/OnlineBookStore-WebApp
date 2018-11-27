<?php
  $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl");
  $response = $client->__soapCall("searchBook", array("Harry"));
  $books = json_encode($response);
  echo($books);
?>