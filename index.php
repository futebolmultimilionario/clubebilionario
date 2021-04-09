<?php
	$dados = file_get_contents("php://input");
	ob_start();
	var_dump($dados);
	$input = ob_get_contents();
	ob_end_clean();
	file_put_contents("input.log",$input.PHP_EOL,FILE_APPEND);
	$requisicao = json_decode($dados, TRUE);
	
	define('BOT_TOKEN', '1698766079:AAF0cMzXlSNsQ0UqUWKwrsqsUn7KBCte7ss');
	define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

	$botToken = "1698766079:AAF0cMzXlSNsQ0UqUWKwrsqsUn7KBCte7ss";
	$idchat3 = "-1001488710027";
	$idchat2 = "-1001459553477";
	$idchat = "-1001443215600";
	$bot_url    = "https://api.telegram.org/bot".$botToken;
	
	function sendMessage($method, $parameters) {
  	$options = array(
  	'http' => array(
    	'method'  => 'POST',
    	'content' => json_encode($parameters),
    	'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
    	)
	);

	$context  = stream_context_create( $options );
	$fim = file_get_contents(API_URL.$method, false, $context );
	return $fim;
	}
	
	if(array_key_exists('message', $requisicao)){
		if(!array_key_exists('sticker', $requisicao['message']) && !array_key_exists('video', $requisicao['message']) && !array_key_exists('poll', $requisicao['message'])){
			if(array_key_exists('caption', $requisicao['message'])){
				$texto = $requisicao['message']['caption'];
			} else {
				$texto = $requisicao['message']['text'];
			} if(strpos(strtolower($texto), 'duplo green') === false && strpos(strtolower($texto), 'duplogreen') === false && strpos(strtolower($texto), 'green duplo') === false && strpos(strtolower($texto), 'greenduplo') === false && strpos(strtolower($texto), 'duplo') === false && strpos(strtolower($texto), 'relatório') === false && strpos(strtolower($texto), 'relatorio') === false && strpos(strtolower($texto), ' dg') === false){
				$chat_id = $requisicao['message']['chat']['id'];
				if($chat_id=='-1001360346569'){
				$msgid = $requisicao['message']['message_id'];
				$url = $bot_url."/copyMessage?chat_id=".$idchat."&from_chat_id=".$chat_id."&message_id=".$msgid;
				$url2 = $bot_url."/copyMessage?chat_id=".$idchat2."&from_chat_id=".$chat_id."&message_id=".$msgid;
				$url3 = $bot_url."/copyMessage?chat_id=".$idchat3."&from_chat_id=".$chat_id."&message_id=".$msgid;
				$resposta = sendMessage("copyMessage", array('chat_id' => $idchat, "from_chat_id" => $chat_id, "message_id" => $msgid));
				$resposta2 = sendMessage("copyMessage", array('chat_id' => $idchat2, "from_chat_id" => $chat_id, "message_id" => $msgid));
				$resposta3 = sendMessage("copyMessage", array('chat_id' => $idchat3, "from_chat_id" => $chat_id, "message_id" => $msgid));
				$msgid_rep = $resposta['result']['message_id'];
				$msgid_rep2 = $resposta2['result']['message_id'];
				$msgid_rep3 = $resposta3['result']['message_id'];
				file_put_contents("idmsg.csv",$msgid.",".$msgid_rep.",".$msgid_rep2.",".$msgid_rep3.PHP_EOL,FILE_APPEND);
				}
			}
		}
		
	}

	if(array_key_exists('edited_message', $requisicao)){
		$chat_id = $requisicao['edited_message']['chat']['id'];
		$msgid = $requisicao['edited_message']['message_id'];
		if($chat_id=='-1001360346569'){
		if (($h = fopen("idmsg.csv", "r")) !== FALSE){
			// Convert each line into the local $data variable
			$i=0;
			if(!array_key_exists('sticker', $requisicao['edited_message']) && !array_key_exists('video', $requisicao['edited_message']) && !array_key_exists('poll', $requisicao['edited_message'])){
			while (($data = fgetcsv($h, 1000, ",")) !== FALSE){
				$teste[]=$data;
				if($teste[$i][0] == $msgid){
					if(!array_key_exists('photo', $requisicao['edited_message'])){
						$texto = $requisicao['edited_message']['text'];
						if(strpos(strtolower($texto), 'duplo green') === false && strpos(strtolower($texto), 'duplogreen') === false && strpos(strtolower($texto), 'green duplo') === false && strpos(strtolower($texto), 'greenduplo') === false && strpos(strtolower($texto), 'duplo') === false && strpos(strtolower($texto), 'relatório') === false && strpos(strtolower($texto), 'relatorio') === false && strpos(strtolower($texto), ' dg') === false){
						$url = $bot_url."/editMessageText?chat_id=".$idchat."&message_id=".$teste[$i][1]."&text=".urlencode($texto);
						$url2 = $bot_url."/editMessageText?chat_id=".$idchat2."&message_id=".$teste[$i][2]."&text=".urlencode($texto);
						$url3 = $bot_url."/editMessageText?chat_id=".$idchat3."&message_id=".$teste[$i][3]."&text=".urlencode($texto);
						sendMessage("editMessageText", array('chat_id' => $idchat, "message_id" => $teste[$i][1], "text" => urlencode($texto)));
						sendMessage("editMessageText", array('chat_id' => $idchat2, "message_id" => $teste[$i][2], "text" => urlencode($texto)));
						sendMessage("editMessageText", array('chat_id' => $idchat3, "message_id" => $teste[$i][3], "text" => urlencode($texto)));
						}
					} else {
						$texto = $requisicao['edited_message']['caption'];

						if(strpos(strtolower($texto), 'duplo green') === false && strpos(strtolower($texto), 'duplogreen') === false && strpos(strtolower($texto), 'green duplo') === false && strpos(strtolower($texto), 'greenduplo') === false && strpos(strtolower($texto), 'duplo') === false && strpos(strtolower($texto), 'relatório') === false && strpos(strtolower($texto), 'relatorio') === false && strpos(strtolower($texto), ' dg') === false){
						$url = $bot_url."/editMessageCaption?chat_id=".$idchat."&message_id=".$teste[$i][1]."&caption=".urlencode($texto);
						$url2 = $bot_url."/editMessageCaption?chat_id=".$idchat2."&message_id=".$teste[$i][2]."&caption=".urlencode($texto);
						$url3 = $bot_url."/editMessageCaption?chat_id=".$idchat3."&message_id=".$teste[$i][3]."&caption=".urlencode($texto);
						sendMessage("editMessageCaption", array('chat_id' => $idchat, "message_id" => $teste[$i][1], "caption" => urlencode($texto)));
						sendMessage("editMessageCaption", array('chat_id' => $idchat2, "message_id" => $teste[$i][2], "caption" => urlencode($texto)));
						sendMessage("editMessageCaption", array('chat_id' => $idchat3, "message_id" => $teste[$i][3], "caption" => urlencode($texto)));
						}
					}
					break;
				}
				$i=$i+1;
  			}
			}
  			fclose($h);
		}
		}
	}


?>
