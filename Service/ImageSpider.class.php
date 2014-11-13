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
		curl_setopt($curl, CURLOPT_URL, $url/*"http://b.app111.com/iphone/58-0-0-1/"*/);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		$output = curl_exec($curl);
		curl_close($curl);
		$explodeArray = explode('<div class="w120">',$output);
		$count = count($explodeArray);
		for ($i=1; $i<$count; $i++) { 

			//获取播放时间
			$tempTime = explode('<span class="tm">',$explodeArray[$i]);
			$tempTime = explode('</span>',$tempTime[1]);
			$videoTime = $tempTime[0];
			//echo "playTime:" . $playTime . "<br/>";

			//获取视频介绍
			$tempDescription = explode('alt=',$explodeArray[$i]);
			$tempImgUrl = explode('<img src=', $tempDescription[0]); //获取图片地址
			$tempPlayUrl = explode('<a href=', $tempImgUrl[0]); //获取播放地址
			$tempDescription = explode('width=', $tempDescription[1]);
			$videoDescription = $tempDescription[0];
			echo "description: " . $videoDescription . "<br/>";

			//获取视频图片
			$tempImgUrl = explode('"',$tempImgUrl[1]);
			$videoImgUrl = $tempImgUrl[1];
			echo "img url: " . $videoImgUrl . "<br/>";

			//获取播放地址
			$tempPlayUrl = explode('"', $tempPlayUrl[1]);
			$videoUrl = $tempPlayUrl[1];
			echo "video url: " . $videoUrl . "<br/>";

			//获取播放次数
			$tempPlayCount = explode('<div class="sz">',$explodeArray[$i]);
			$tempPlayCount = explode('<cite>', $tempPlayCount[1]);
			$tempPlayCount = explode('</cite>', $tempPlayCount[1]);
			$videoPlayCount = $tempPlayCount[0];
			echo "video play count: " . $videoPlayCount . "<br/>";

			echo $explodeArray[$i];


		}
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
		
		// $images = explode(")", $imagesTmep[1]);
		// echo $images[0];


		/*
		 *
		 *photos.push({'id': 862886,'height': 481,'imgUrl': 'http://img.tu.yeabow.com/group1/M00/CE/99/98603d2819197f4a68ff9736d25fe6a1.jpg','remark': '老公，帐篷里面真的没人啦~'})
        photos.push({'id':862887,'height':517,'imgUrl':'http://img.tu.yeabow.com/group1/M00/A2/48/053edb1d20bc0176e440e508609dd5ab.jpg','remark':'都快天亮了，车子还没走完一圈'})
        photos.push({'id':862888,'height':518,'imgUrl':'http://img.tu.yeabow.com/group1/M00/9C/0B/a96da71b2149335ed3977d639dbd66e0.jpg','remark':'今天殡仪屋的伙计工作太积极了'})
        photos.push({'id':862889,'height':480,'imgUrl':'http://img.tu.yeabow.com/group1/M00/A5/CF/5fcfd8eddd4aef3a0788e46943bd4586.jpg','remark':'告诉妈妈的话就完蛋了'})
        photos.push({'id':862890,'height':442,'imgUrl':'http://img.tu.yeabow.com/group1/M00/EA/81/a57df6d42c651476b6991c85e72a920a.jpg','remark':'憋...了3个小时了...终于...'})
        photos.push({'id':862891,'height':612,'imgUrl':'http://img.tu.yeabow.com/group1/M00/E1/80/465f3b828ddb102b78fc009497b5bf10.jpg','remark':'我裤子都脱了，你……'})
        photos.push({'id':862892,'height':481,'imgUrl':'http://img.tu.yeabow.com/group1/M00/7A/DC/51244a1c7c8635bd94192c26eeec4e82.jpg','remark':'他是第一个敞开心扉的……他死得比较早……————《残酷社会》'})
        photos.push({'id':862893,'height':441,'imgUrl':'http://img.tu.yeabow.com/group1/M00/0D/DB/f1e69d3c691d7257b8573ae533b3c10c.jpg','remark':'右面第二个也可以……'})
        photos.push({'id':862894,'height':665,'imgUrl':'http://img.tu.yeabow.com/group1/M00/42/A1/f1669170510bce4399ee84e3e777c290.jpg','remark':'蟹哥你身体不要紧吗'})
        photos.push({'id':862895,'height':536,'imgUrl':'http://img.tu.yeabow.com/group1/M00/49/96/2aa6aded7885f437cbd0048f9158e634.jpg','remark':'还真的抢了奥特曼不少人气啊'})
        photos.push({'id':862896,'height':615,'imgUrl':'http://img.tu.yeabow.com/group1/M00/95/49/70a366c168a14c48ce0208ecb3f5b857.jpg','remark':'“吓你一跳”巧克力有新贴纸了~'})
        photos.push({'id':862897,'height':655,'imgUrl':'http://img.tu.yeabow.com/group1/M00/0D/24/909d3bbea50074c414c2b8ef7b477edc.jpg','remark':'链球比赛时忘记松手了'})
        photos.push({'id':862898,'height':559,'imgUrl':'http://img.tu.yeabow.com/group1/M00/23/5A/b6c759a94c06f2d2a10a9fc3a4076201.jpg','remark':'“来，看着镜头，跟我一起，茄子”'})
        photos.push({'id':862899,'height':615,'imgUrl':'http://img.tu.yeabow.com/group1/M00/D0/3D/62853f9fde31f71da0051e308096f871.jpg','remark':'好了好了，给你饲料'})
        photos.push({'id':862900,'height':611,'imgUrl':'http://img.tu.yeabow.com/group1/M00/33/2B/bd78a5b6915e5992b8d197deefddfc8c.jpg','remark':'理发的你出来，我保证不挠~~死你'})
        photos.push({'id':862901,'height':624,'imgUrl':'http://img.tu.yeabow.com/group1/M00/18/F6/649b2b80715ea23b0e69f07d6662b869.jpg','remark':'吃下去后一分钟，不也是过期么？'})
        photos.push({'id':862902,'height':623,'imgUrl':'http://img.tu.yeabow.com/group1/M00/2F/F2/5611c9e5e076685b64ee6d4412f02cad.jpg','remark':'妈妈今天是星期日啊！'})
        photos.push({'id':862903,'height':617,'imgUrl':'http://img.tu.yeabow.com/group1/M00/0A/30/ba4bd5e45c3107b6c84e9549280601ca.jpg','remark':'这个愿望已经超过了神的能力范围！'})
        photos.push({'id':862904,'height':518,'imgUrl':'http://img.tu.yeabow.com/group1/M00/B8/9C/ec9db9e36b6f5ee957cbc6f98406bafa.jpg','remark':'魔法少年坐扫把的话，不会觉得痛吗'})
        photos.push({'id':862905,'height':471,'imgUrl':'http://img.tu.yeabow.com/group1/M00/28/96/cd2326d66c3893e77feddf42b9724b22.jpg','remark':'一开始就学火球术了！'})
        photos.push({'id':862906,'height':484,'imgUrl':'http://img.tu.yeabow.com/group1/M00/54/6B/d0395b0ac4d2c45e1f1811fdde054cb8.jpg','remark':'下期预告'})
        photos.push({'id':862907,'height':628,'imgUrl':'http://img.tu.yeabow.com/group1/M00/F3/50/bad6acff754f8485dad767bcbe10fb66.jpg','remark':'001'})
        photos.push({'id':862908,'height':454,'imgUrl':'http://img.tu.yeabow.com/group1/M00/B2/24/339db936bb9e09095e8fc19b08f7df18.jpg','remark':'002'})
        photos.push({'id':862909,'height':664,'imgUrl':'http://img.tu.yeabow.com/group1/M00/04/E2/c7e5c2a3d50047121b77f63d960e8c79.jpg','remark':'003'})
        photos.push({'id':862910,'height':622,'imgUrl':'http://img.tu.yeabow.com/group1/M00/78/ED/284a8a8d1a35117fedb856c9e725c869.jpg','remark':'004'})
        photos.push({'id':862911,'height':592,'imgUrl':'http://img.tu.yeabow.com/group1/M00/F7/49/aad2e12defed9b236e297fb722835067.jpg','remark':'005'})
        photos.push({'id':862912,'height':620,'imgUrl':'http://img.tu.yeabow.com/group1/M00/7A/BA/5836cf171051a692f5d7184367ed00b6.jpg','remark':'006'})
        photos.push({'id':862913,'height':438,'imgUrl':'http://img.tu.yeabow.com/group1/M00/5A/64/1d6ffe21cb5569b98889858a633a0170.jpg','remark':'007'})
        photos.push({'id':862914,'height':528,'imgUrl':'http://img.tu.yeabow.com/group1/M00/4B/D4/c45779bcb01839cee4d121333da593cc.jpg','remark':'008'})
        photos.push({'id':862915,'height':619,'imgUrl':'http://img.tu.yeabow.com/group1/M00/1B/BA/f3b5583853c43f32ac65bb9210a8d5af.jpg','remark':'009'})
        photos.push({'id':862916,'height':483,'imgUrl':'http://img.tu.yeabow.com/group1/M00/FB/98/4b8911b2fb6f191c6b2ff53266aebb59.jpg','remark':'010'})
        photos.push({'id':862917,'height':518,'imgUrl':'http://img.tu.yeabow.com/group1/M00/42/16/e43d4f5ce8bc98b97630b1287520e6e3.jpg','remark':'011'})
        photos.push({'id':862918,'height':515,'imgUrl':'http://img.tu.yeabow.com/group1/M00/51/C4/e74f10486c70331bb83e7514d34b4fe9.jpg','remark':'012'})
        photos.push({'id':862919,'height':489,'imgUrl':'http://img.tu.yeabow.com/group1/M00/BE/E1/6ac432eb4d5e9805f1c7205e907f9908.jpg','remark':'013'})
        photos.push({'id':862920,'height':615,'imgUrl':'http://img.tu.yeabow.com/group1/M00/5A/16/eb140a8735e4b3df0d8cbf8eb574d9fb.jpg','remark':'014'})
        photos.push({'id':862921,'height':666,'imgUrl':'http://img.tu.yeabow.com/group1/M00/89/68/5dbd234eb9dfe70bb6a9074e1f62da0b.jpg','remark':'015'})
		 */
	}
}

?>