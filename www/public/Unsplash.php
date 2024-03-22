<?php


namespace Ivet\Ac1;
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PDO;

class Unsplash
{
    private Client $client;
    private string $accessKey;

    public function __construct($accessKey)
    {
        $this->client = new Client();
        $this->accessKey = $accessKey;
    }

    public function getDataByKeyWord(string $keyWord)
    {
        $numPics = 30;
        $urlAPI = "https://api.unsplash.com/search/photos?query=$keyWord&per_page=$numPics&client_id=$this->accessKey";
        try {
            $response = $this->client->request("GET", $urlAPI);
            $data = json_decode($response->getBody()->getContents(), true);
            return $data;
        } catch (GuzzleException $e) {
            return null;
        }
    }

    public function registerSearchHistory($userId, $keyword): void
    {
        //insert data in UnsplashSearch table
        $connection = new PDO('mysql:host=mysql;dbname=LsCreativity_project_db', 'pw2user', 'pw2pass');
        $statement = $connection->prepare('INSERT INTO UnsplashSearch(query,timestamp) VALUES (?,NOW())');
        $statement->bindParam(1, $keyword);
        $statement->execute();
        //get the stored id
        $unsplash_search_id = $connection->lastInsertId();
        //insert data in UserHistory table
        $statement = $connection->prepare('INSERT INTO UserHistory(user_id,unsplash_search_id) VALUES (?,?)');
        $statement->bindParam(1, $userId);
        $statement->bindParam(2, $unsplash_search_id);
        $statement->execute();
    }
}