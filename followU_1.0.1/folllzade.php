<? 
/* �������� @PUPKINZADE */
/* Version 1.0.1
/* ��������� ���. ����� �����, ��� �������� � ����� �����, ��������� API, ����� ���������� */

/* SETTING/��������� */

$twi_key = "followback"; /* �������� ����� �� �������� ����� ���� ����� */
$twi_lang = "en"; /* ���� ������, ������ ���� ru � en */
$twi_limit = 2; /* ���������� ����� �� �������� ����� ����������� �� ��� �������� 100 */

$consumer_key=""; /* ��� ��� CONSUMER-KEY */
$consumer_sec=""; /* ��� ��� CONSUMER-SECRET */
$oauth_tok=""; /* ��� ��� OAUTH-TOKEN */
$oauth_sec=""; /* ��� ��� OAUTH-SECRET */
 
/* ���� ������ �� �������� */

$twit_search="http://search.twitter.com/search.json?q=".urlencode($twi_key)."&rpp=".$twi_limit."&include_entities=false&result_type=mixed&lang=".$twi_lang;
$search_tw=file_get_contents($twit_search);
$massiv_json=json_decode($search_tw);

echo "<h3>�� �����������:</h3>";

for ($sw=1; $sw<=$twi_limit; $sw++) {
$follower=$massiv_json->results[$sw-1]->from_user;

set_time_limit(0);
        require_once 'twitteroauth/twitteroauth.php';
	$connection = new TwitterOAuth($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
	$connection->format = 'json';

$connection->post('friendships/create', array('screen_name'=>$follower));

echo "<li>".$follower."</li>";
}

?>