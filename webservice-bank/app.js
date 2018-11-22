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
  console.log(num);
  connection.query('SELECT * FROM nasabah where nomor_kartu=\"' + num + "\";", function(err, rows, fields){
    if(err) throw err;
    // console.log(rows);
    if (rows === "[]") {
      res.write('HAHAHAHAHA');
    } else {
      res.write('CACADD');
    }
    // res.send(rows);
    console.log('success get');
  })
});

app.post('/transfer',function(req, res){

})

app.listen(3000, function(){
  console.log('listen to port 3000');
});