<?php
$id = $_GET["id"]; 

$kullanici = get_user_by_id($id);

/*
kullanıcı id değerinin nümerik olup olmadığını kontrol edersek IDOR saldırısını önlemiş oluruz.

if (is_numeric($id)) { 
  $kullanici = get_user_by_id($id);

  if ($kullanici) {
    echo "Kullanıcı adı: " . $kullanici["kullanici_adi"];
  } else {
    echo "Kullanıcı bulunamadı.";
  }
} else {
  echo "Geçersiz kullanıcı ID'si.";
}
*/

if ($kullanici) {
  echo "Kullanıcı adı: " . $kullanici["kullanici_adi"];
} else {
  echo "Kullanıcı bulunamadı.";
}
?>