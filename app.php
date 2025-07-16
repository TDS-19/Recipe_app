<?php

$con = mysqli_connect('127.0.0.1', 'root', '', 'recipe_app_dump');
 
if ($con){
    echo "Ligação à base de dados efetuada com sucesso!\n";
} else {
    echo "Erroa conectar com a base de dados\n";
}

mysqli_close($con);