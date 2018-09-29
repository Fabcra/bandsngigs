<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 17/06/18
 * Time: 16:55
 */

namespace App\Service;

use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_PlaylistItemListResponse;



class YoutubeAPI
{

    /**
     * @var string
     */
    private $apiKey;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return Google_Client
     */
    public function getClient()
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->apiKey);
        return $client;
    }


    public function getVideosFromPlaylist($playlistId, $maxResult)
    {
        $client = $this->getClient();
        $youtube = new Google_Service_YouTube($client);

        $searchResponse = $youtube->playlistItems->listPlaylistItems('id,snippet', array(
           'playlistId'=>$playlistId,
           'maxResults'=>$maxResult,
        ));

        return $searchResponse['items'];
    }


}