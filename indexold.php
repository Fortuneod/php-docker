<?php

    $conn = new mysqli("db", "Fortuneod", "seyejames@123", "php_docker");


    $s="SELECT * FROM `expenses`";
    $r=$conn->query($s);
    while($v=$r->fetch_object())
    {
        echo "<p>". $v->comments ."</p>";
    }

    echo "<hr/>";

    phpinfo();

?>