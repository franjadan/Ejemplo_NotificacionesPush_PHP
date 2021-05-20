<?php 

	/* Array de tokens en caso de enviarse por token */
	
	$tokensiOS = ['eI5TejthQUjKmGcVVcT_Ts:APA91bHlrFam3D00JoRaxxyZfJzUqpVCLW5U_LbenImhERhPQalw9LwbY-JNkZYyfcILrGgK7UcyDVV9phS4iJsUzQDdZxDHatjVzpeIpcZafjwe_vyYX7isMdxtuKygSGJAdomZVcL-'];
	$tokensAndroid = ['cY0PDkd9Q-CP1W6NPNATn3:APA91bGkJHEP-ftSOi_UIvrq1qODEhpnXytFvNy794EsHwP_M9bI4HFiNOuQcvo5CFIobOYU9d0h64IVQ82SCJzoLyFrl3FJtaWZMmTBGLPhmcenfi38Z70NMB0B9kuUxabvsFyQwYl5'];
	
	/* Defino las notificaciones que pueden variar en funcion del dispositivo */
	
	$notificationAndroid= array();          
                                         
    $notificationAndroid["body"] = "Hola";
    $notificationAndroid["title"] = "Esto es una notifiación push";
    $notificationAndroid["sound"] = "default";
    $notificationAndroid["type"] = 1;
	
	$notificationiOS= array();          
                                         
    $notificationiOS["body"] = "Hola";
    $notificationiOS["title"] = "Esto es una notifiación push";
    $notificationiOS["sound"] = "default";
	$notificationiOS["badge"] = 1;
    $notificationiOS["type"] = 1;
	
	$resultiOS = sendNotifications($tokensiOS, $notificationiOS, 'iOS');
	$resultAndroid = sendNotifications($tokensAndroid, $notificationAndroid, 'Android');
	
	print_r("iOS: " . $resultiOS . "\n");
	print_r("Android: " . $resultAndroid . "\n");



	function sendNotifications($registatoin_ids, $notification,$device_type){
		$url = 'https://fcm.googleapis.com/fcm/send';
		if($device_type == "Android"){
			
			//Para array de device_tokens
			/*
			$fields = array(
				'registration_ids' => $registatoin_ids,
				'data' => $notification
			);*/
			
			//Para un solo device_token
			/*
			$fields = array(
				'to' => $registatoin_ids,
				'data' => $notification
			);*/
			
			/*
				'data' => Puedes mandar parámetros personalizados
				'notification' => Solo puedes mandar parámetros predefinidos

			*/
			
			$fields = array(
				'to' => '/topics/pushNotificationTopic',
				'data' => $notification,
				//'notification' => $notificacion
			);
		}else{
			
			//Para array de device_tokens
			/*
			$fields = array(
				'registration_ids' => $registatoin_ids,
				'notification' => $notification
			);*/
			
			//Para un solo device_token
			/*
			$fields = array(
				'to' => $registatoin_ids,
				'notification' => $notification
			);*/
			
			//Para un tema
			$fields = array(
				'to' => '/topics/pushNotificationTopic',
				'notification' => $notification
			);
		}
		
		//Clave de servidor de cloud messaging en Firebase (en este caso diferencio entre dispositivo porque usan dos aplicaciones distintas)
		  
		if($device_type == "Android"){
			$apiKey = 'AAAA8VedW8k:APA91bFmHWw3BlltITK_qzKI-u06nhsfmb40pH1zp6tO6RPnW8m-p4PJjwDkrwZYGP_iMLIjBKpm3yv8YvpnHQY8hCAhvNjmj3uM5yFPX_8g9EcaZho73M8YCdkZb428yc5od-JwAUUF';
		}else{
			$apiKey = 'AAAArbZjxb8:APA91bFI7aAY22CEJUmQ5sF5sHWP0qAzi_alz3I8rcFF_fSzwyjH6KwKtoOtJ3saxflF1RGYCAFzt5OAhDYD3Q9fAqGzE4hQCaz73P7FM0O1KAaAwvj6LJjvaRVuWjgj0E3GwkOnqwi6';
		}

		// Firebase API Key
		$headers = array('Authorization:key=' . $apiKey,'Content-Type:application/json');
		// Open connection
		$ch = curl_init();
		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Error: ' . curl_error($ch));
		}
		curl_close($ch);
		  
		return $result;
	 }

?>