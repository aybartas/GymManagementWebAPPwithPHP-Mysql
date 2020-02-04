<?php


    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword="Hacettepecs";
   $dbName = "gym_management";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword,$dbName);
/*$conn= mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, "C:\Users\aybar\Desktop\ilkdeneme\includes\BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
mysqli_options ($conn, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
define('oktayserver.mysql.database.azure.com', '193.140.239.215:3306');

     mysqli_real_connect($conn, "oktayserver.mysql.database.azure.com", "koray@oktayserver", "AKO.1920", "deneme_aybar2", 3306); */
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
