<?php

/**
* 
*/
class MessageResponse
{
	static function message($messageCode,$message = '',$data = array())
	{
		$format = $_GET['format'];
		if (!is_numeric($messageCode) || !is_array($data))
		{
			return MessageResponse::createJSONMessage(404,"参数格式错误",array());
		}
		switch (strtoupper($format))
		{
			case 'XML':
				MessageResponse::createXMLMessage($messageCode,$message,$data);
				break;
			case 'ARRAY':
				MessageResponse::createArrayMessage($messageCode,$message,$data);
				break;
			case 'JSON':
			default:
				MessageResponse::createJSONMessage($messageCode,$message,$data);
				break;
		}
	}

	static function createXMLMessage($code,$message,$data)
	{
		header('Content-Type:text/xml');
		$messageXML = array('code' => $code, 'message' => $message, 'data' => $data);
		$xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
		$xml .= "<root>\n";
		$xml .= MessageResponse::arrayToXML($messageXML);
		$xml .= "</root>";
		echo $xml;
	}

	static function arrayToXML($data)
	{
		$xml = "";
		foreach ($data as $key => $value) 
		{
			//为了解决array(4,5,6)这样的key为数字情况
			$isNum = is_numeric($key);
			if ($isNum)
			{
				$xml .= "<item id='{$key}'>";
			}
			else
			{
				$xml .= "<{$key}>";
			}
			$xml .= is_array($value) ? MessageResponse::arrayToXML($value) : $value;
			if ($isNum) 
			{
				$xml .= "</item>\n";
			}
			else
			{
				$xml .= "</{$key}>\n";
			}
			
		}
		return $xml;

	}

	static function createArrayMessage($code,$message,$data)
	{
		$messageArray = array();
		$messageArray['code'] = $code;
		$messageArray['message'] = $message;
		$messageArray['data'] = $data;
		var_dump($messageArray);
	}

	static function createJSONMessage($code,$message,$data)
	{
		$messageJSON = array();
		$messageJSON['code'] = $code;
		$messageJSON['message'] = $message;
		$messageJSON['data'] = $data;
		echo json_encode($messageJSON);
	}
}

?>