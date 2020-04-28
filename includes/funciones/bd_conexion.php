<?php

define ('DB_USUARIO','root');
define ('DB_PASSWORD','root');
define ('DB_HOST','localhost');
define ('DB_NOMBRE','ferrer');

$conn = new mysqli(DB_HOST,DB_USUARIO,DB_PASSWORD,DB_NOMBRE);
/* 
echo $conn->ping(); */



?>