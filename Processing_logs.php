<?php
function processing_log (string $l){
	$answer = [
		'hits' => 0,
		'urls' => 0,
		'traffic' => 0,
		'all_line' => 0,
		'search_requests' => [
			'Google' => 0,
			'Mail' => 0,
			'Rambler' => 0,
			'Yandex' => 0,
		],
		'answer_codes' => [],
	];
	$unic_urls = [];
	$answer_codes = [];
	$pattern = '/^([\S]+) (-) (-) (\[[\S]+) ([\S]+\]) "(.*) (.*) (.*)" ([0-9\-]{3}) ([0-9\-]+) "(.*)" "(.*)"$/';
	$search_pattern = "/Google|Mail|Rambler|Yandex/";
	if ($open_file = fopen($l, 'r')) {
		$i = 1;
		while (!feof($open_file)) {
			if ($line = trim(fgets($open_file))) {
				if (preg_match($pattern, $line, $matches)) {
					list(
                        $line,
                        $ip,
                        $a,
                        $b,
                        $date,
                        $date_zone,
                        $type_request,
                        $unic_url,
                        $protocol,
                        $code,
                        $bytes,
                        $peace_url,
                        $user
                    ) = $matches;
                    if (!array_search($unic_url, $unic_urls)) {
                    	$unic_urls[$unic_url] = 1;
                    } else {
                    	$unic_urls[$unic_url]++;
                    }
                    if (!array_key_exists($code, $answer_codes)) {
                    	$answer_codes[$code] = 1;
                    } else {
                    	$answer_codes[$code]++;
                    }
                    $answer['hits'] = $i;
                    $answer['urls'] = count($unic_urls);
                    $answer['traffic'] += $bytes;
                    $answer['all_line'] = $i;
                    $answer['answer_codes'] = $answer_codes;
                }
                preg_match($search_pattern, $user, $search_result);
                if (!empty($search_result)) {
                	list($search_name) = $search_result;
                	if (!array_key_exists($search_name, $answer['search_requests'])) {
                		$answer['search_requests'][$search_name] = 1;
                	} else {
                		$answer['search_requests'][$search_name]++;
                	}
                }
            } else {
            	error_log("Can't process line $i: $line");
            }
            $i++;
        }
    }
    return json_encode($answer);
}
$file = getopt('l::');
$answer = processing_log ($file ['l']);
echo ($answer);
?>