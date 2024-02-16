<?php
$parameter = array(
    "query"=>"Howard Phillips Lovecraft"
);
 
$host = "https://dapi.kakao.com/v2/search/web";
$api_key = "4a10552ea42f3e71bb5c39c7994f8602";
$headers = array("Authorization: KakaoAK {$api_key}");
 
$query = http_build_query($parameter);
$content_type = "json";
 
$opts = array(
    CURLOPT_URL => $host . '.' . $content_type . '?' . $query,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSLVERSION => 1,
    CURLOPT_HEADER => false,
    CURLOPT_HTTPHEADER => $headers
);
 
$curl_session = curl_init();
curl_setopt_array($curl_session, $opts);
$return_data = curl_exec($curl_session);

$decode = json_decode($return_data, true);
$result = $decode['documents']['0']['title'];
$result = explode("-", $result);
$result_array = rtrim($result[0]);
$result_array = explode(" ", $result_array);
print_r($result_array);
//print_r($decode);
 
if (curl_errno($curl_session)) {
    throw new Exception(curl_error($curl_session));
} else {
    curl_close($curl_session);
}

//출처: https://mintea.tistory.com/7