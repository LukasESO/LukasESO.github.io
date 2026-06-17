<?php
// Permite que seu navegador acesse este script (resolve o CORS)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// URL original do Steam
$steamUrl = "https://steamcommunity.com/market/search/render/?query=&start=0&count=100&appid=3678970&currency=7";

// Busca os dados do Steam
$data = file_get_contents($steamUrl);

// Retorna para o seu Painel
echo $data;
?>