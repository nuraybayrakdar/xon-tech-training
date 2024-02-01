<?php

function openFile($fileName) {
    $file = fopen($fileName, "r");

    if (!$file) {
        throw new Exception("Dosya bulunamadı: $filename");
    }
    fclose($file);
    return $file;
}

try {
    $file = openFile("test.txt");
    echo "Dosya açıldı";
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();

}

?>