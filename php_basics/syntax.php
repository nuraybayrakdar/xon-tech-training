<?php

######## PHP Syntax ########

$name = "Nuray";
echo "Name:  $name \n";

$string1 = "Nuray";
$string2 = "Bayrakdar";
$num1 = 20;
$num2 = 5;
$sum = $num1 + $num2;
$subtraction = $num1 - $num2;
$multiply = $num1 * $num2;
$divide = $num1 / $num2;

$name_surname = $string1 . " " . $string2; 
$checker = "True";

if ($num1 > $num2) { 
    $checker = "True";
} else {
    $checker = "False"; 
}

echo "I am $name_surname \n"; 
echo "$num2 is less than $num1 : $checker \n"; 
echo "Toplam: $sum, Çıkarma: $subtraction, Çarpma: $multiply, Bölme: $divide  \n"; 

echo strtoupper($name_surname) . "\n"; 
echo strtolower($name_surname) . "\n"; 
echo str_replace("Nuray", "Canan", $name_surname) . "\n"; 
echo substr($name_surname, 0, 5) . "\n"; 


var_dump($sum);
$sum = (string)$sum;
var_dump($sum);

switch($name) {
    case "Nuray":
        echo "Name is Nuray \n";
        break;
    case "Canan":
        echo "Name is Canan \n";
        break;
    default:
        echo "Name is not Nuray or Canan";
}

$names = array("Nuray", "Canan", "Mehmet", "Ayşe");
$ages = array("Nuray" => 20, "Canan" => 21, "Mehmet" => 22, "Ayşe" => 23);

for($i = 0; $i < count($names); $i++) {
    echo $names[$i] . "\n";
}

foreach($ages as $key => $value) {
    echo "Name: $key, Age: $value \n";
}

$colors = array("Red", "Blue", "Pruple");
array_push($colors, "Green");
print_r($colors);

### Üslü Sayı Hesaplama
echo "Tabanı girin: ";
$base = intval(trim(fgets(STDIN)));
echo "Üssü girin: ";
$exponent = intval(trim(fgets(STDIN))); 

$result = 1;
$count = 0;

while ($count < $exponent) {
    $result *= $base; 
    $count++; 
}

echo "$base üzeri $exponent = $result \n";

### Dikdörtgen ve Çember Alanı Hesaplama
function rectangleArea($height, $width) {
    $result = $height * $width;
    return $result;
}

function cricleArea($radius) {
    $area = pi() * pow($radius, 2);
    return $area;
}

$rectangleArea = rectangleArea(4, 3);
$circleArea = cricleArea(4); 

echo "Area of the rectangle: $rectangleArea \n";
echo "Area of the circle: $circleArea \n";

?>
