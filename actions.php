<?php
require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Exception\RequestException;
use voku\helper\HtmlDomParser;
use GuzzleHttp\Client;

$rawdata = file_get_contents("php://input");
$data = json_decode($rawdata);

if (isset($data->link)) {

/*        $client = new Client([
            'timeout' => 30,
            'allow_redirects' => false,
        ]);


        $response = $client->get($data->link)->getBody()->getContents();
        print_r($response);
        die;*/



    $dom = HtmlDomParser::file_get_html($data->link);
    $type = '.jpg';

    if (preg_match('/"is_video":true/i', $dom->innerText())) {
        $type = '.mp4';

        // check if is video
        $video = $dom->findOneOrFalse('meta[property="og:video"]');
        // nếu chỉ có video không
        if ($video) {
            $downloadLink = $video->getAttribute('content');
        } else {
            // nếu có cả hình cả video
            preg_match('/(?:video_url":")(.*?)"/i', $dom->innerText(), $matches);
            $decodedString = json_decode(sprintf('{"video_url": "%s"}', $matches[1]));
            $downloadLink = $decodedString->video_url;
        }
    } else {

        $image = $dom->findOneOrFalse('meta[property="og:image"]');
        if ($image) {
            $downloadLink = $image->getAttribute('content');
        }
    }

    $title = $dom->findOneOrFalse('title');


    echo json_encode([
        'success' => true,
        'download' => base64_encode(json_encode([
            'title' => $title->innerText(),
            'type' => $type,
            'downloadLink' => $downloadLink
        ]))
    ]);

}