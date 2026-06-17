<?php
// Permite que seu navegador acesse este script (resolve o CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Evita cache no navegador ou em servidores intermediários
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Define um tempo limite para evitar que o script trave
ini_set('default_socket_timeout', 15);

// URL original do Steam com parâmetros de busca
$steamUrl = "https://steamcommunity.com/market/search/render/?query=&start=0&count=100&appid=3678970&norender=1&currency=7";

// Configura o stream de contexto para simular um navegador real
$options = [
    "http" => [
        "method" => "GET",
        "header" => [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36",
            "Accept: application/json, text/javascript, */*; q=0.01",
            "Referer: https://steamcommunity.com/market/"
        ],
        "timeout" => 15
    ]
];
$context = stream_context_create($options);

// Busca os dados do Steam de forma protegida
$data = @file_get_contents($steamUrl, false, $context);

// Verifica se a busca falhou ou retornou vazio
if ($data === false || empty($data)) {
    http_response_code(502);
    echo json_encode(["error" => "Falha ao conectar com o servidor do Steam ou dados indisponíveis", "status" => "502"]);
} else {
    // Retorna os dados para o seu Painel
    echo $data;
}
?>
