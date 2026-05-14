<?php
// データベース接続の関数を定義
function connectionDB(){
  $dsn = 'mysql:dbname=mentor_reservation;host=localhost;charset=utf8';
  $user = 'root'; 
  $password = '';
  
  try {
  $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
  echo "DB access ERROR: " . $e->getMessage() . "\n";
  exit();
  }
return $dbh;
}
?>