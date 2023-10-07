<?php

namespace Helper;

use cURLFile;

class Http
{
    /** curl请求
     * @param string $url
     * @param $param
     * @param array $headers
     * @param string $method
     * @return bool|string
     */
    public static function curl(string $url, $param, array $headers = [], string $method = 'GET')
    {
        $curl = curl_init();
        $opt = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ];

        if (strtoupper($method) === 'POST') {
            $opt[CURLOPT_POSTFIELDS] = $param;
        }

        curl_setopt_array($curl, $opt);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /** get请求
     * @param string $url
     * @param $param
     * @param array $headers
     * @return bool|string
     */
    public static function get(string $url, $param, array $headers = [])
    {
        $parse = parse_url($url);

        parse_str($parse['query'] ?? '', $output);
        $output = array_merge($output, $param);
        $url = sprintf("%s://%s%s?%s", $parse['scheme'], $parse['host'], $parse['path'], http_build_query($param));

        return self::curl($url, $param, $headers);
    }

    /** post请求
     * @param string $url
     * @param $param
     * @param array $headers
     * @return bool|string
     */
    public static function post(string $url, $param, array $headers = [])
    {
        $param = http_build_query($param);
        return self::curl($url, $param, $headers, 'POST');
    }

    /** 表单请求
     * @param string $url
     * @param $param
     * @param array $headers
     * @param array $files
     * @return bool|string
     */
    public static function form(string $url, $param, array $headers = [], array $files = [])
    {
        $fields = $param;

        foreach ($files as $key => $path) {
            if (is_array($path)) {
                foreach ($path as $k => $f) {
                    $fields[$key . '[' . $k . ']'] = new cURLFile($f);
                }
            } else {
                $fields[$key] = new cURLFile($path);
            }
        }

        return self::curl($url, $fields, $headers, 'POST');
    }
}