<?php
//Private strings for restricted access ..
$getKey = 'NWGXJsPBu8rqMfkA';
$postKey = 'HFz3CPUC9azKvdKS';

if (!$_GET || !array_key_exists('key',$_GET)|| $_GET['key'] != $getKey){
	die('Access Denied, invalid access');
}

function getPostData(){
	$post = file_get_contents('php://input');
	try{
		$post = json_decode($post,true);
	}catch (Exception $e){
		die('Invalid format');
	}
	return $post;
};
$data = getPostData();
//Make sure data exists
if (!$data || !array_key_exists('PostKey', $data) || $data['PostKey'] != $postKey){
	die('Access Denied, invalid permissions');
}
if (!array_key_exists('url', $data)){
	die('No url provided');
}

$url = $data['url'];
//Make the http request

$ch = curl_init();
curl_setopt_array($ch, array(
	CURLOPT_URL => $url,
	CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
	CURLOPT_RETURNTRANSFER => true
));
$result = curl_exec($ch);

if($result === false){
	echo('No response recieved from '.$url);
}
curl_close($ch);
echo $result;
?>