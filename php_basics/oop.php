<?php

class Book {
   
    public $title;
    public $author;
    public $date;
    public $price;
    public $stock;

    public function __construct($title, $author, $date, $price, $stock) {
        $this->title = $title;
        $this->author = $author;
        $this->date = $date;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function get_price() {
        return $this->price;
    }

    public function setPrice($newPrice) {
        $this->price = $newPrice;
        echo "Fiyat Güncellendi: $this->price\n";
    }

    public function purchase($quantity) {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            echo "Satın alma başarılı. Kalan Stok: $this->stock\n";
        } else {
            echo "Stok yetersiz!!!\n";
        }
    }
    
    public function displayDetails() {
        echo "Title: $this->title\n";
        echo "Author: $this->author\n";
        echo "Publish Date: $this->date\n";
        echo "Price: $this->price\n";
        echo "Stock: $this->stock\n";
    }



    
}

class Ebook extends Book {
    public $fileSize;
    public function __construct($title, $author, $date, $price, $stock,$fileSize) {
        parent::__construct($title, $author, $date, $price, $stock);
        $this->fileSize = $fileSize;
    }

    public function displayDetails() {
        parent::displayDetails(); 
        echo "File Size: $this->fileSize\n";
    }
}

$book1 = new Book("Altinci Kogus", "Anton Cehov", "1951-07-16", "96 TL", 10);

echo "\nDetails of Book:\n";
$book1->displayDetails();
echo "\n";

$book1->setPrice(14.99);

$book1->purchase(3);
$book1->purchase(55);

echo "\nDetails of Book:\n";
$book1->displayDetails();
echo "\n";


$ebook1 = new Ebook("Genc Werther'in Acilari", "Gothe", "1951-07-16", "96 TL", 45, "102 MB");

echo "Details of Ebook:\n";
$ebook1->displayDetails();



?>
