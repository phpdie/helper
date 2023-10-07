<?php

namespace Helper;

class Http
{
    /** get请求
     * @param string $url
     * @param array $param
     * @param array $headers
     * @return bool|string
     */
    public static function get(string $url, array $param = [], array $headers = [])
    {
        $parse = parse_url($url);

        parse_str($parse['query'] ?? '', $output);
        $output = array_merge($output, $param);
        $url = sprintf("%s://%s%s?%s", $parse['scheme'], $parse['host'], $parse['path'], http_build_query($param));

        $curl = curl_init();
        $opt = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ];
        curl_setopt_array($curl, $opt);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /** post请求
     * @param string $url
     * @param array $param
     * @param array $headers
     * @return bool|string
     */
    public static function post(string $url, array $param = [], array $headers = [])
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
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($param),
            CURLOPT_HTTPHEADER => $headers,
        ];
        curl_setopt_array($curl, $opt);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /** 表单请求
     * @param string $url
     * @param array $param
     * @param array $headers
     * @param array $files
     * @return bool|string
     */
    public static function form(string $url, array $param = [], array $headers = [], array $files = [])
    {
        $fields = $param;

        foreach ($files as $key => $path) {
            if (is_array($path)) {
                foreach ($path as $k => $f) {
                    $fields[$key . '[' . $k . ']'] = new \cURLFile($f);
                }
            } else {
                $fields[$key] = new \cURLFile($path);
            }
        }

        $curl = curl_init();
        $opt = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => $headers,
        ];
        curl_setopt_array($curl, $opt);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}