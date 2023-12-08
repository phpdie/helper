<?php

namespace Helper;

class Http
{
    public static function curl($url, $query = [], $body = [], $method = 'GET', $headers = [])
    {
        $curl = curl_init();
        $opt = [
            CURLOPT_URL => $query ? $url . '?' . http_build_query($query) : $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
        ];
        if ($headers) {
            $opt[CURLOPT_HTTPHEADER] = $headers;
        }
        if ($body) {
            $opt[CURLOPT_POSTFIELDS] = $body;
        }

        curl_setopt_array($curl, $opt);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}