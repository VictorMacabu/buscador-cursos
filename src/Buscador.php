<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use http\Client;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $httpClient;
    /**
     * @var Crawler
     */
    private Crawler $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }
    public function buscar(string $url): array
    {

        try {
            $resposta = $this->httpClient->request('GET', $url);
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }

        $html = $resposta->getBody();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $elemento) {
            $cursos[] = $elemento->textContent . PHP_EOL;
        }
        return $cursos;
    }
}
