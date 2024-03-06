<?php
$dosya = $_GET["myfile"];

/*
    kullanıcı burada dosya parametresine ../../../../../etc/passwd gibi bir değer gönderirse
    /etc/passwd dosyasının içeriğini görebilir. Bundan kaçınmak için dosya adını kontrol etmeliyiz.
    Şunları kulanabiliriz: realpath(), pathinfo(), basename(), is_file(), file_exists(), is_readable()

    Örneğin:  $dosya = realpath($_GET["myfile"]);
*/


if (file_exists($dosya)) {
  echo "file content: " . file_get_contents($dosya);
} else {
  echo "file not found!";
}
?>

