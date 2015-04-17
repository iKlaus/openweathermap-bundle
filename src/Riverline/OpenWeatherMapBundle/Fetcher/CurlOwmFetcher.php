<?php

namespace Riverline\OpenWeatherMapBundle\Fetcher;

use Cmfcmf\OpenWeatherMap\Fetcher\FetcherInterface;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;

/**
 * Class CurlOwmFetcher
 * @package Riverline\OpenWeatherMapBundle\Fetcher
 */
class CurlOwmFetcher implements FetcherInterface
{
    /**
     * {@inheritdoc}
     */
    public function fetch($url)
    {
        $ch = curl_init($url);
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (false === $content
            || empty($content)
            || $code != 200) {
            $errorMsg = 'Curl error on owm: '.curl_error($ch).' , content: '.$content.' , code: '.$code;
            curl_close($ch);
            throw new OWMException($errorMsg);
        }

        curl_close($ch);
        return $content;
    }
}
