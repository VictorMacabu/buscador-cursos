<?php

require 'vendor/autoload.php';
require 'src/Buscador.php';

use Alura\BuscadorDeCursos\Buscador;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client([
    'curl' => array( CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false ),
    'allow_redirects' => false,
    'cookies' => true,
    'verify' => false,
    'base_uri' => 'https://www.alura.com.br/'
]);
$crawler = new Crawler();


$buscador = new Buscador($client, $crawler);
$cursos = [];

try {
    $cursos = $buscador->buscar('/cursos-online-programacao/php');
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    echo $e->getMessage();
}
$conteudo = "";
$indice = '1';
foreach ($cursos as $curso)
{
    echo $curso . PHP_EOL;
    $conteudo .= "$indice $curso \n";
    $indice++;
}

file_put_contents("cursosPHP.txt", $conteudo);
