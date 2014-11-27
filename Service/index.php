<?php

require_once('./ImageSpider.class.php');
require_once('./MessageResponse.class.php');
require_once('./Youku.class.php');
require_once('./YoukuM3U8.class.php');
require_once('./Database.class.php');

header("Content-Type: text/html;charset=utf-8");

// $url = "http://v.youku.com/v_show/id_XODMzNTg4ODIw.html";
// $data = Youku::parse($url);
// print_r($data);
// //echo youku_m3u8::get_m3u8_url('XODAwMDc5Nzg0');
// return;
// 
$urlArray = array(/*搞笑短片分类*/
				  array('catalog' => 1000, 'type' => 1001, 'url' => 'http://www.gaoxiaodashi.com/egaozhenggu/'),/*恶搞整蛊*/
				  array('catalog' => 1000, 'type' => 1002, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaobaobao/'),/*搞笑宝宝*/
				  array('catalog' => 1000, 'type' => 1003, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaoshipinjijin/'),/*搞笑视频集锦*/
				  array('catalog' => 1000, 'type' => 1004, 'url' => 'http://www.gaoxiaodashi.com/leirenjiongshi/'),/*囧人糗事*/
				  array('catalog' => 1000, 'type' => 1005, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaotiyu/'),/*搞笑体育*/
				  array('catalog' => 1000, 'type' => 1006, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaodongwu/'),/*搞笑动物*/
				  array('catalog' => 1000, 'type' => 1007, 'url' => 'http://www.gaoxiaodashi.com/shenghuoshipai/'),/*生活实拍*/
				  array('catalog' => 1000, 'type' => 1008, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaozipai/'),/*搞笑自拍*/
				  array('catalog' => 1000, 'type' => 1009, 'url' => 'http://www.gaoxiaodashi.com/quweiguanggao/'),/*趣味广告*/
				  array('catalog' => 1000, 'type' => 1010, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaoqiche/'),/*搞笑汽车*/

				  // /*搞笑配音分类*/
				  // array('catalog' => 2000, 'type' => 2001, 'url' => 'http://www.gaoxiaodashi.com/egaopeiyinjianji/'),/*恶搞配音神剪辑*/
				  // array('catalog' => 2000, 'type' => 2002, 'url' => 'http://www.gaoxiaodashi.com/xuduba/'),/*胥渡吧*/
				  // array('catalog' => 2000, 'type' => 2003, 'url' => 'http://www.gaoxiaodashi.com/daanminganyaoanzaishen/'),/*大案命案*/
				  // array('catalog' => 2000, 'type' => 2004, 'url' => 'http://www.gaoxiaodashi.com/huaixiubang/'),/*淮秀帮*/
				  // array('catalog' => 2000, 'type' => 2005, 'url' => 'http://www.gaoxiaodashi.com/ysdfn/'),/*元首的愤怒*/
				  // array('catalog' => 2000, 'type' => 2006, 'url' => 'http://www.gaoxiaodashi.com/hulang/'),/*胡狼*/
				  // array('catalog' => 2000, 'type' => 2007, 'url' => 'http://www.gaoxiaodashi.com/siwenpizi/'),/*司文痞子*/
				  // array('catalog' => 2000, 'type' => 2008, 'url' => 'http://www.gaoxiaodashi.com/shengqinxiangyong/'),/*声琴相拥*/
				  // array('catalog' => 2000, 'type' => 2009, 'url' => 'http://www.gaoxiaodashi.com/mous/'),/*某S*/
				  // array('catalog' => 2000, 'type' => 2010, 'url' => 'http://www.gaoxiaodashi.com/laoshi/'),/*老湿*/
				  // array('catalog' => 2000, 'type' => 2011, 'url' => 'http://www.gaoxiaodashi.com/shangguoqingdun/'),/*尚锅卿炖*/
				  // array('catalog' => 2000, 'type' => 2012, 'url' => 'http://www.gaoxiaodashi.com/hexiangufu/'),/*何仙姑父*/
				  // array('catalog' => 2000, 'type' => 2013, 'url' => 'http://www.gaoxiaodashi.com/yanwugongzuoshi/'),/*炎舞工作室*/
				  // array('catalog' => 2000, 'type' => 2014, 'url' => 'http://www.gaoxiaodashi.com/liudongdong/'),/*刘咚咚*/
				  // array('catalog' => 2000, 'type' => 2015, 'url' => 'http://www.gaoxiaodashi.com/bigxiaogongfang/'),/*Big笑工坊*/
				  // array('catalog' => 2000, 'type' => 2016, 'url' => 'http://www.gaoxiaodashi.com/ouzizuitucao/'),/*欧子最吐槽*/
				  // array('catalog' => 2000, 'type' => 2017, 'url' => 'http://www.gaoxiaodashi.com/lige/'),/*Li哥*/
				  // array('catalog' => 2000, 'type' => 2018, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaopeiyin/daguoxiaojiang/'),/*大帼小酱*/

				  /*搞笑影视分类*/
				  array('catalog' => 3000, 'type' => 3001, 'url' => 'http://www.gaoxiaodashi.com/gaoxiaoyingshi/gaoxiaopianduan/'),/*搞笑片段*/
				  // array('catalog' => 3000, 'type' => 3002, 'url' => 'http://www.gaoxiaodashi.com/aiqinggongyugaoxiaopianduan/'),/*爱情公寓搞笑片*/
				  // array('catalog' => 3000, 'type' => 3003, 'url' => 'http://www.gaoxiaodashi.com/feidieshuo/'),/*飞碟说*/
				  // array('catalog' => 3000, 'type' => 3004, 'url' => 'http://www.gaoxiaodashi.com/chaojizhenggu/'),/*超级整蛊*/
				  // array('catalog' => 3000, 'type' => 3005, 'url' => 'http://www.gaoxiaodashi.com/weibojianghu/'),/*微播江湖*/
				  // array('catalog' => 3000, 'type' => 3006, 'url' => 'http://www.gaoxiaodashi.com/qingsongyingshi/'),/*轻松影视*/
				  // array('catalog' => 3000, 'type' => 3007, 'url' => 'http://www.gaoxiaodashi.com/qingsongshike/'),/*轻松时刻*/
				  // array('catalog' => 3000, 'type' => 3008, 'url' => 'http://www.gaoxiaodashi.com/meiriyijiong/'),/*每日一囧*/
				  // array('catalog' => 3000, 'type' => 3009, 'url' => 'http://www.gaoxiaodashi.com/qipaxiu/'),/*极品奇葩秀*/
				  // array('catalog' => 3000, 'type' => 3010, 'url' => 'http://www.gaoxiaodashi.com/baozoudashijian/'),暴走大事件
				  // array('catalog' => 3000, 'type' => 3011, 'url' => 'http://www.gaoxiaodashi.com/feidieyifenzhong/'),/*飞碟一分钟*/
				  // array('catalog' => 3000, 'type' => 3012, 'url' => 'http://www.gaoxiaodashi.com/minjianniuren/'),/*民间牛人*/
				  // array('catalog' => 3000, 'type' => 3013, 'url' => 'http://www.gaoxiaodashi.com/nishuolesuan/'),/*你说了蒜*/
				  // array('catalog' => 3000, 'type' => 3014, 'url' => 'http://www.gaoxiaodashi.com/jianbixiaohua/'),/*简笔笔画*/
				  // array('catalog' => 3000, 'type' => 3015, 'url' => 'http://www.gaoxiaodashi.com/yuantengfei/'),/*袁腾飞*/
				  // array('catalog' => 3000, 'type' => 3016, 'url' => 'http://www.gaoxiaodashi.com/nisuobuzhidaodexiyouji/'),/*你所不知道的西游记*/
				  // array('catalog' => 3000, 'type' => 3017, 'url' => 'http://www.gaoxiaodashi.com/gabgczxh/'),/*关爱八卦成长协会*/
				  // array('catalog' => 3000, 'type' => 3018, 'url' => 'http://www.gaoxiaodashi.com/bzdsj3/'),/*暴走大事件第三季*/
				  // array('catalog' => 3000, 'type' => 3019, 'url' => 'http://www.gaoxiaodashi.com/xiaobalaile/'),/*笑霸来了*/

				  // /*搞笑短剧分类*/
				  // array('catalog' => 4000, 'type' => 4001, 'url' => 'http://www.gaoxiaodashi.com/zhengyungaoxiaoshipin/'),/*郑云搞笑视频全集*/
				  // array('catalog' => 4000, 'type' => 4002, 'url' => 'http://www.gaoxiaodashi.com/qingsongyixiao/'),/*轻松一笑*/
				  // array('catalog' => 4000, 'type' => 4003, 'url' => 'http://www.gaoxiaodashi.com/meiriyibao/'),/*每日一暴*/
				  // array('catalog' => 4000, 'type' => 4004, 'url' => 'http://www.gaoxiaodashi.com/wwmxd2/'),/*万万没想到第二季*/
				  // array('catalog' => 4000, 'type' => 4005, 'url' => 'http://www.gaoxiaodashi.com/loldierji/'),/*lol第二季*/
				  // array('catalog' => 4000, 'type' => 4006, 'url' => 'http://www.gaoxiaodashi.com/loldisanji/'),/*lol第三季*/
				  // array('catalog' => 4000, 'type' => 4007, 'url' => 'http://www.gaoxiaodashi.com/diaosinvshi/'),/*屌丝女士*/
				  // array('catalog' => 4000, 'type' => 4008, 'url' => 'http://www.gaoxiaodashi.com/diaosinvshidierji/'),/*屌丝女士第二季*/
				  // array('catalog' => 4000, 'type' => 4009, 'url' => 'http://www.gaoxiaodashi.com/baogaolaoban/'),/*报告老板*/
				  // array('catalog' => 4000, 'type' => 4010, 'url' => 'http://www.gaoxiaodashi.com/wwmxd/'),/*万万没想到*/
				  // array('catalog' => 4000, 'type' => 4011, 'url' => 'http://www.gaoxiaodashi.com/malagebidierji/'),/*麻辣隔壁第二季*/
				  // array('catalog' => 4000, 'type' => 4012, 'url' => 'http://www.gaoxiaodashi.com/malagebidisanji/'),/*麻辣隔壁第三季*/
				  // array('catalog' => 4000, 'type' => 4013, 'url' => ''),/*愤怒的唐僧*/

				  // /*搞笑节目分类*/
				  // array('catalog' => 5000, 'type' => 5001, 'url' => 'http://www.gaoxiaodashi.com/jimijimaoxiu/'),/*吉米鸡毛秀*/
				  // array('catalog' => 5000, 'type' => 5002, 'url' => 'http://www.gaoxiaodashi.com/zypd/'),/*综艺片段*/
				  // array('catalog' => 5000, 'type' => 5003, 'url' => 'http://www.gaoxiaodashi.com/aixiaohuiyishi/'),/*爱笑会议室*/
				  // array('catalog' => 5000, 'type' => 5004, 'url' => 'http://www.gaoxiaodashi.com/80houtuokouxiu/'),/*今晚80后脱口秀*/
				  // array('catalog' => 5000, 'type' => 5005, 'url' => 'http://www.gaoxiaodashi.com/jiatingyoumoluxiang/'),/*家庭幽默录像*/
				  // array('catalog' => 5000, 'type' => 5006, 'url' => 'http://www.gaoxiaodashi.com/womendouaixiao/'),/*我们都爱笑*/
				  // array('catalog' => 5000, 'type' => 5007, 'url' => 'http://www.gaoxiaodashi.com/zongyizuiaixian/'),/*综艺最爱宪*/

				  // /*美女分类*/
				  // array('catalog' => 6000, 'type' => 6001, 'url' => 'http://www.gaoxiaodashi.com/meinvbaoyanfu/'),/*美女饱眼福*/
				  // array('catalog' => 6000, 'type' => 6002, 'url' => 'http://www.gaoxiaodashi.com/meinvrewu/'),/*美女热舞*/
				  // array('catalog' => 6000, 'type' => 6003, 'url' => 'http://www.gaoxiaodashi.com/meinvxiezhen/'),/*美女写真*/

				  // /*神回复分类*/
				  // array('catalog' => 7000, 'type' => 7001, 'url' => 'http://www.gaoxiaodashi.com/shenjiefang/'),/*神街访*/
				  // array('catalog' => 7000, 'type' => 7002, 'url' => 'http://www.gaoxiaodashi.com/90houdexiu/'),/*90后的秀*/
				  // array('catalog' => 7000, 'type' => 7003, 'url' => 'http://www.gaoxiaodashi.com/jipinjiefang/'),/*极品街访*/
				  // array('catalog' => 7000, 'type' => 7004, 'url' => 'http://www.gaoxiaodashi.com/shenhuifu/wofangnihua/'),/*我访你话*/

				  /*社会热点分类*/
				  /*array('catalog' => 8000, 'type' => 8001, 'url' => 'http://www.gaoxiaodashi.com/shehuilieqi/'),/*社会猎奇*/);

$imageSpider = new ImageSpider();
$database = Database::getInstance();

$date = date("Y-m-d h:m:s");
foreach ($urlArray as $key => $value) {
	$catalog = $value['catalog'];
	$type = $value['type'];
	$url = $value['url'];
	$pageCount = $imageSpider->fetchVideoPageCount($url);
	$pageCount = $pageCount == 0 ? 1 : $pageCount;
	echo "pageCount = " . $pageCount . "<br/>";

	for ($i=1; $i <= $pageCount; $i++) { 
		$requestURL = $url;
		if ($i > 1) {
			$requestURL = $url . $i . ".html";
		}
		echo "requestURL = " . $requestURL . "<br/>";
		$res = $imageSpider->fetchContent($requestURL);
	
		foreach ($res as $resKey => $resValue) {
			$videoTime = $resValue['video_time'];
			$videoTitle = $resValue['video_title'];
			$videoCoverImg = $resValue['video_cover_img'];
			$videoWebURL = $resValue['video_play_url'];
			$videoURL = '';
			$videoDescription = $resValue['video_description'];
			$videoPlayCount = $resValue['video_play_count'];
			$videoID = md5($videoWebURL);

			$likeCount = rand(0,$videoPlayCount);
			$unlikeCount = rand(0,$likeCount/2);
			$shareCount = rand(0,$videoPlayCount);

			$sql = "INSERT INTO `videoList` (`id`,`catalog`,`type`,`title`,`description`,`videoURL`,`webURL`,`coverImgURL`,`localImgURL`,`videoTime`,`createDate`,`playCount`,`likeCount`,`unlikeCount`,`shareCount`)
								 VALUES ('$videoID','$catalog','$type','$videoTitle','$videoDescription','$videoURL','$videoWebURL','$videoCoverImg','','$videoTime','$date','$videoPlayCount','$likeCount','$unlikeCount','$shareCount');";
			//echo $sql . "<br/>";					 
			if ($database->query($sql)) {
				echo "success" . "<br/>";
			} else {
				echo "error" . mysql_error() . "<br/>";
				echo $sql . "<br/>";
			}
		}
	}
	echo $url . "   ============ END ============" . "<br/>";

}

echo "============ END ============" . "<br/>";

return;

//$imageSpider->fetchVideoPageCount('http://www.gaoxiaodashi.com/egaozhenggu/');
$result = $imageSpider->fetchContent('http://www.gaoxiaodashi.com/daanminganyaoanzaishen/');
$page = $imageSpider->fetchVideoPageCount('http://www.gaoxiaodashi.com/daanminganyaoanzaishen/');
echo "page = " . $page;
//print_r($result);
echo MessageResponse::createJSONMessage(0,'获取成功',$result);


?>