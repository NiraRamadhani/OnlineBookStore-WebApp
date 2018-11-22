var express = require('express');
var app = express();
var mysql = require('mysql');
var connection = mysql.createConnection({
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'bank'
  }
)
var bodyParser = require('body-parser');
var jsonParser = bodyParser.json();
var urlencodedParser =bodyParser.urlencoded({extended: false});

connection.connect(function(err){
  if(err) throw err;
  console.log('connected to DB');
});

app.post('/validasi', urlencodedParser, function(req, res){
  if(!req.body) return res.sendStatus(400)
  num = req.body.cardnumber;
  connection.query('SELECT * FROM nasabah where nomor_kartu=' + num, function(err, rows, fields){
    if(err) throw err;
    res.send(rows);
    console.log('success post');
  })
});

app.post('/transfer', urlencodedParser, function(req, res){
  if(!req.body) return res.sendStatus(400)
  nomorPengirim = req.body.nomorPengirim;
  nomorPenerima = req.body.nomorPenerima;
  jumlah = req.body.jumlah;
  connection.query(`INSERT INTO transaksi(nomor_pengirim, nomor_penerima, jumlah) 
  VALUES(${nomorPengirim}, ${nomorPenerima}, ${jumlah})`, function(){
    console.log("insert success");
    res.send('insert success');
  });
})

app.listen(3000, function(){
  console.log('listen to port 3000');
});