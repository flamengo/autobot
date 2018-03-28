<?php
require_once('./vendor/autoload.php');

// Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = 'jJt20EwnIYxyCEg7CbVaJLAFWIr9nODngQab3J8AI87yuZ9FB0Oqya/o76OdFkX5dAgUJNxMCP3SUyTc02kG7jNuGyYV68lAbO7w9TR1aepwUFxkXErYk3qSr58FeTEGbXMeS8TTwvZCsJRYqeWiiQdB04t89/1O/w1cDnyilFU=';
$channel_secret = 'a8982cf03629d10877f964af13d9b230';

// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Line API send a lot of event type, we interested in message only.
        if ($event['type'] == 'message') {
            switch ($event['message']['type']) {
                case 'text':
                    // Get replyToken
                    $replyToken = $event['replyToken'];

                    // Reply message
                    $respMessage = 'สวัสดีครับ เมื่อสักครู่คุณส่งข้อความถึงเราว่า "'. $event['message']['text'] . '" นะครับ';

                    $httpClient = new CurlHTTPClient($channel_token);
                    $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
                    $textMessageBuilder = new TextMessageBuilder($respMessage);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
                break;
            }
        }
    }
}

echo "OK!";
