<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');
require_once('simplejson.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "",
    'consumer_secret' => ""
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=#DEFCON&count=1&include_entities=false';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
$obj = json_decode($response);
$user = $obj["statuses"][0]["user"]["screen_name"];
$tweet = $obj["statuses"][0]["text"];
$user = preg_replace('/\\\u([0-9a-z]{4})/', '', $user);
$tweet = preg_replace('/\\\u([0-9a-z]{4})/', '', $tweet);
echo "<user>$user</user>\n";
echo "<tweet>$tweet</tweet>";
file_put_contents('/tmp/tweet.log',"$tweet\n",FILE_APPEND);
?>
