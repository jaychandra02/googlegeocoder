<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Googlegeocoder {

    /**
     * GoogleGeocoder CI Class 
     * 
     *
     * @package   googlegeocoder
     * @version   1.0.0
     * @author    Jay Chandra, Shubh Tech <shubhtech.in>
     * @copyright Copyright (c) 2020, Jay Chandra
     * @license   http://www.opensource.org/licenses/mit-license.php
     * @link      http://github.com/jaychandra02/googlegeocoder/
     *
     */
    public function __construct() {
        $this->baseURL = "https://maps.google.com/maps/api/geocode/json?key=YOUR_API_KEY";
    }

    public function reverseGeocode($location, $addrtype = 0) {
        //$addrType : Response Format
        //0=Full Address
        //1=State, ZIP, Country
        //2=Locality, City, State, Country
        //3=City, State, Country
        //4=State, Country
        //5=Country
        $url = $this->baseURL . "&latlng=" . $location;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);
        curl_close($ch);
        if ($contents) {
            $resp = json_decode($contents);
            if ($resp->status = 'OK') {
                return $resp->results[$addrtype]->formatted_address;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function geocode($address) {
        $url = $this->baseURL . "&address=" . urlencode($address);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);
        curl_close($ch);

        if ($contents) {
            $resp = json_decode($contents);
            if ($resp->status = 'OK') {
                return $resp->results[0]->geometry->location;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}

?>