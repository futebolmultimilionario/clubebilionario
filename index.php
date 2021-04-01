<?php
	$dados = file_get_contents("php://input");
	ob_start();
	var_dump($dados);
	$input = ob_get_contents();
	ob_end_clean();
	file_put_contents("input.log",$input.PHP_EOL,FILE_APPEND);
	$requisicao = json_decode($dados, TRUE);

	$botToken = "1698766079:AAFSctTXkEK1RN2I7LsDGkQ0cygteLts_1g";
	$idchat2 = "-1001488710027";
	$idchat = "-1001443215600";
	$bot_url    = "https://api.telegram.org/bot".$botToken;

	if(array_key_exists('channel_post', $requisicao)){
		if(!array_key_exists('sticker', $requisicao['channel_post']) && !array_key_exists('video', $requisicao['channel_post']) && !array_key_exists('poll', $requisicao['channel_post'])){
			if(array_key_exists('caption', $requisicao['channel_post'])){
				$texto = $requisicao['channel_post']['caption'];
			} else {
				$texto = $requisicao['channel_post']['text'];
			} if(strpos(strtolower($texto), 'duplo green') === false && strpos(strtolower($texto), 'duplogreen') === false && strpos(strtolower($texto), 'green duplo') === false && strpos(strtolower($texto), 'greenduplo') === false && strpos(strtolower($texto), 'duplo') === false && strpos(strtolower($texto), 'relatório') === false && strpos(strtolower($texto), 'relatorio') === false && strpos(strtolower($texto), ' dg') === false){
				$chat_id = $requisicao['channel_post']['chat']['id'];
				if($chat_id=='-1001459553477' || $chat_id=='-1001467521005'){
				$msgid = $requisicao['channel_post']['message_id'];
				$url = $bot_url."/copyMessage?chat_id=".$idchat."&from_chat_id=".$chat_id."&message_id=".$msgid;
				$url2 = $bot_url."/copyMessage?chat_id=".$idchat2."&from_chat_id=".$chat_id."&message_id=".$msgid;
				$resposta = json_decode(file_get_contents($url), TRUE);
				$resposta2 = json_decode(file_get_contents($url2), TRUE);
				$msgid_rep = $resposta['result']['message_id'];
				$msgid_rep2 = $resposta2['result']['message_id'];
				}
			}
		}
		file_put_contents("idmsg.csv",$msgid.",".$msgid_rep.",".$msgid_rep2.PHP_EOL,FILE_APPEND);
	}

	if(array_key_exists('edited_channel_post', $requisicao)){
		$chat_id = $requisicao['edited_channel_post']['chat']['id'];
		$msgid = $requisicao['edited_channel_post']['message_id'];
		if($chat_id=='-1001459553477' || $chat_id=='-1001467521005'){
		if (($h = fopen("idmsg.csv", "r")) !== FALSE){
			// Convert each line into the local $data variable
			$i=0;
			if(!array_key_exists('sticker', $requisicao['edited_channel_post']) && !array_key_exists('video', $requisicao['edited_channel_post']) && !array_key_exists('poll', $requisicao['edited_channel_post'])){
			while (($data = fgetcsv($h, 1000, ",")) !== FALSE){
				$teste[]=$data;
				if($teste[$i][0] == $msgid){
					if(!array_key_exists('photo', $requisicao['edited_channel_post'])){
						$texto = $requisicao['edited_channel_post']['text'];
						if(strpos(strtolower($texto), 'duplo green') === false && strpos(strtolower($texto), 'duplogreen') === false && strpos(strtolower($texto), 'green duplo') === false && strpos(strtolower($texto), 'greenduplo') === false && strpos(strtolower($texto), 'duplo') === false && strpos(strtolower($texto), 'relatório') === false && strpos(strtolower($texto), 'relatorio') === false && strpos(strtolower($texto), ' dg') === false){
						$url = $bot_url."/editMessageText?chat_id=".$idchat."&message_id=".$teste[$i][1]."&text=".urlencode($texto);
						$url2 = $bot_url."/editMessageText?chat_id=".$idchat2."&message_id=".$teste[$i][2]."&text=".urlencode($texto);
						file_get_contents($url);
						file_get_contents($url2);
						}
					} else {
						$texto = $requisicao['edited_channel_post']['caption'];

						if(strpos(strtolower($texto), 'duplo green') === false && strpos(strtolower($texto), 'duplogreen') === false && strpos(strtolower($texto), 'green duplo') === false && strpos(strtolower($texto), 'greenduplo') === false && strpos(strtolower($texto), 'duplo') === false && strpos(strtolower($texto), 'relatório') === false && strpos(strtolower($texto), 'relatorio') === false && strpos(strtolower($texto), ' dg') === false){
						$url = $bot_url."/editMessageCaption?chat_id=".$idchat."&message_id=".$teste[$i][1]."&caption=".urlencode($texto);
						$url2 = $bot_url."/editMessageCaption?chat_id=".$idchat2."&message_id=".$teste[$i][2]."&caption=".urlencode($texto);
						file_get_contents($url);
						file_get_contents($url2);
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
