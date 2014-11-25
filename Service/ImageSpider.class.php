<?php

/**
* 
*/
class ImageSpider
{
	//private $result;

	function __construct() 
	{
		//$result = array();
	}

	function fetchContent($url)
	{
		$result = array();
		$curl = curl_init();
		//伪造User-Agent为window下的浏览器,不然会被引导到手机端
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.baidu.com)'); 
		curl_setopt($curl, CURLOPT_URL, $url/*"http://b.app111.com/iphone/58-0-0-1/"*/);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl);
		curl_close($curl);
		$explodeArray = explode('<div class="w120">',$output);
		$count = count($explodeArray);
		for ($i=1; $i<$count; $i++) { 

			$result[$i-1] = array();
			//获取播放时间
			$tempTime = explode('<span class="tm">',$explodeArray[$i]);
			$tempTime = explode('</span>',$tempTime[1]);
			$videoTime = $tempTime[0];
			//echo "playTime:" . $videoTime . "<br/>";
			$result[$i-1]['video_time'] = $videoTime;

			//获取视频介绍
			$tempTitle = explode('alt=',$explodeArray[$i]);
			$tempImgUrl = explode('<img src=', $tempTitle[0]); //获取图片地址
			$tempPlayUrl = explode('<a href=', $tempImgUrl[0]); //获取播放地址
			$tempTitle = explode('width=', $tempTitle[1]);
			$videoTitle = $tempTitle[0];
			//echo "description: " . $videoDescription . "<br/>";
			$result[$i-1]['video_title'] = $videoTitle;

			//获取视频图片
			$tempImgUrl = explode('"',$tempImgUrl[1]);
			$videoImgUrl = $tempImgUrl[1];
			//echo "img url: " . $videoImgUrl . "<br/>";
			$result[$i-1]['video_cover_img'] = $videoImgUrl;

			//获取播放地址
			$tempPlayUrl = explode('"', $tempPlayUrl[1]);
			$videoResult = ImageSpider::fetchVideoURLAndDescription($tempPlayUrl[1]);
			//echo "video url: " . $videoUrl . "<br/>";
			$result[$i-1]['video_play_url'] = $videoResult['video_play_url'];

			$result[$i-1]['video_description'] = $videoResult['video_description'];

			//获取播放次数
			$tempPlayCount = explode('<div class="sz">',$explodeArray[$i]);
			$tempPlayCount = explode('<cite>', $tempPlayCount[1]);
			$tempPlayCount = explode('</cite>', $tempPlayCount[1]);
			$videoPlayCount = $tempPlayCount[0];
			//echo "video play count: " . $videoPlayCount . "<br/>";
			$result[$i-1]['video_play_count'] = $videoPlayCount;

			//echo $explodeArray[$i];
			//echo "<br/>";
		}
		return $result;
	}

	function fetchVideoPageCount($webURL)
	{
		$curl = curl_init();
		//伪造User-Agent为window下的浏览器,不然会被引导到手机端
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.baidu.com)'); 
		curl_setopt($curl, CURLOPT_URL, $webURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl);
		curl_close($curl);
		$pageCount = 0;
		$explodeArray = explode('<div class="pages">',$output);
		if (!empty($explodeArray)) {
			$tempArray = explode('</div>',$explodeArray[1]);
			$tempArray = explode('<a href=',$tempArray[0]);
			$count = count($tempArray);
			if ($count >= 2) {
				//echo $tempArray[$count-2];
				$pageTemp = explode('>',$tempArray[$count-2]);
				$pageTemp = explode('<',$pageTemp[1]);
				$pageCount = $pageTemp[0];
			}
		}
		//echo "pageCount = " . $pageCount . "<br/>";
		return $pageCount;
	}

	function fetchVideoURLAndDescription($webURL)
	{
		$result = array();
		$curl = curl_init();
		//伪造User-Agent为window下的浏览器,不然会被引导到手机端
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.baidu.com)'); 
		curl_setopt($curl, CURLOPT_URL, $webURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl);
		$explodeArray = explode('var flashvars=',$output);
		$videoTemp = explode('}',$explodeArray[1]);
		$videoTemp = explode('a:',$videoTemp[0]);
		$videoTemp = explode(',',$videoTemp[1]);
		$videoTemp = explode("'",$videoTemp[0]);
		$result['video_play_url'] = $videoTemp[1]; //获取播放地址

		$explodeArray = explode('class="zaiyao_content">',$output);
		$videoDescription = explode('</p>',$explodeArray[1]);
		$videoDescription = explode('>',$videoDescription[0]);
		// print_r($videoDescription);
		// echo "<br/>";
		$result['video_description'] = $videoDescription[1]; //获取播放地址

		return $result;

	}

	function fetchDetailImage($url)
	{
		$result = array();
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl);
		curl_close($curl);

		$imagesTemp = explode("photos.push({", $output);
		$count = count($imagesTemp);
		for ($i=1; $i < $count; $i++) { //数组0必须要有元素，不然结构很奇怪
			$result[$i-1] = array();
			$json = explode("})", $imagesTemp[$i]);
			$jsonArr = explode("':", $json[0]);
			//echo "jsonArr:" . $json[0] . "<br/>";

			$id = explode(",", $jsonArr[1]);
			$result[$i-1]['id'] = $id[0];

			$height = explode(",", $jsonArr[2]);
			$result[$i-1]['height'] = $height[0];

			$imgUrl = explode(",", $jsonArr[3]);
			$result[$i-1]['imgUrl'] = $imgUrl[0];

			$remark = explode("}", $jsonArr[4]);
			//echo "remark:" . $jsonArr[4] . "<br/>";
			$result[$i-1]['remark'] = $remark[0];

		}
		return $result;
	}
}

?>