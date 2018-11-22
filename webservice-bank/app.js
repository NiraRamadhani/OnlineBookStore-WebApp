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
var fs = require('fs');

connection.connect(function(err){
  if(err) throw err;
  console.log('connected to DB');
});

app.get('/', function(req, res){
  res.sendfile('views/index.html');
});

app.get('/validasi',function(req, res){
  num = req.params.cardnumber;
  connection.query('SELECT * FROM nasabah where nomor_kartu=' + num, function(err, rows, fields){
    if(err) throw err;
    res.send(rows);
    console.log('success get');
  })
});

app.post('/transfer',function(req, res){

})

app.listen(3000, function(){
  console.log('listen to port 3000');
});