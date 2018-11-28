<?php
  $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl");
  $judul = $_POST['judul'];
  $id = $_POST['id'];
  if (isset($judul)) {
    $params = array(
      "arg0" => $_POST['judul']
    );
    $response = $client->__soapCall("searchBook", $params);
  } elseif (isset($id)) {
    $params = array(
      "arg0" => $_POST['id']
    );
    $response = $client->__soapCall("getDetail", $params);
  }
  $books = json_encode($response);
  echo($books);
?>