<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 8/08/18
 * Time: 23:13
 */

namespace App\Service;


class MapLocation
{

    private static $apikey = 'AIzaSyA-nXEJ0eim6B9-G3B9GQLUnLsNxrs9A7g';


    public function getPosition($address)
    {

        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=" . self::$apikey . "&address=$address");

        $json = json_decode($json);


        $res = $json->results[0];


        return $res;
    }


}