<?php

namespace App\Services;

use Http\Adapter\Guzzle6\Client;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use TgBotApi\BotApiBase\ApiClient;
use TgBotApi\BotApiBase\BotApiNormalizer;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;
use TgBotApi\BotApiBase\BotApi;


class tgBotManager
{


    private YoutubeDl $youtubeDl;

    private $bot;

    public function __construct(string $secretKey)
    {
        $this->secretBotKey = $secretKey;
        $this->youtubeDl = new YoutubeDl;
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $client = new Client();
        $apiClient = new ApiClient($requestFactory, $streamFactory, $client);
        $this->bot = new BotApi($this->secretBotKey,$apiClient, new BotApiNormalizer());

    }

    public function downloadVideo($url)
    {
        $collection = $this->youtubeDl->download(
            Options::create()
                ->url($url)
        );

        foreach($collection->getVideos() as $video){
            if($video->getError() !== null){
                return $video->getError();
            }else{
                return $video->getFile();
            }
        }
        exit();
    }


    public function downloadAudio($url)
    {
        $collection = $this->youtubeDl->download(
            Options::create()
                ->extractAudio(true)
                ->audioFormat('mp3')
                ->audioQuality('0') // best
                ->output('%(title)s.%(ext)s')
                ->url($url)
        );

        foreach($collection->getVideos() as $video){
            if($video->getError() !== null){
                return $video->getError();
            }else{
                return $video->getFile();
            }
        }
        exit();
    }

    public function sendFille($type){

    }
}