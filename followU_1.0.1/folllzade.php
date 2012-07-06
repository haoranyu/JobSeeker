<? 
/* Созданно @PUPKINZADE */
/* Version 1.0.1
/* Обновлено все. Новый поиск, все настойки в одном файле, фолловинг API, вывод результата */

/* SETTING/НАСТРОЙКА */

$twi_key = "followback"; /* ключевое слово по которому будет идти поиск */
$twi_lang = "en"; /* язык поиска, можеть быть ru и en */
$twi_limit = 2; /* количество людей за которыми нужно последовать за раз максимум 100 */

$consumer_key=""; /* тут ваш CONSUMER-KEY */
$consumer_sec=""; /* тут ваш CONSUMER-SECRET */
$oauth_tok=""; /* тут ваш OAUTH-TOKEN */
$oauth_sec=""; /* тут ваш OAUTH-SECRET */
 
/* НИЖЕ НИЧЕГО НЕ ИЗМЕНЯТЬ */

$twit_search="http://search.twitter.com/search.json?q=".urlencode($twi_key)."&rpp=".$twi_limit."&include_entities=false&result_type=mixed&lang=".$twi_lang;
$search_tw=file_get_contents($twit_search);
$massiv_json=json_decode($search_tw);

echo "<h3>Вы зафолловили:</h3>";

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