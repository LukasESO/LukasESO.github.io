<?php
// Permite que seu navegador acesse este script (resolve o CORS)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Define um tempo limite para evitar que o script trave
ini_set('default_socket_timeout', 10);

// URL original do Steam com parâmetros de busca
$steamUrl = "https://steamcommunity.com/market/search/render/?query=&start=0&count=100&appid=3678970&norender=1&currency=7";

// Configura o stream de contexto para simular um navegador real e evitar bloqueios imediatos
$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($options);

// Busca os dados do Steam de forma protegida
$data = @file_get_contents($steamUrl, false, $context);

// Verifica se a busca falhou
if ($data === false) {
    // Retorna um erro JSON formatado caso o Steam bloqueie ou timeout
    http_response_code(502);
    echo json_encode(["error" => "Falha ao conectar com o servidor do Steam", "status" => "502"]);
} else {
    // Retorna os dados para o seu Painel
    echo $data;
}
?>
