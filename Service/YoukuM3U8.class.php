<?php
class youku_m3u8
    {
        public static function curl($url, $carry_header = true, $REFERER_ = 0, $add_arry_header = 0)
        {
            $ch = curl_init($url);
            if ($carry_header)
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.116 Safari/537.36'));
            }
            if ($add_arry_header)
            {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $add_arry_header);
            }
            if ($REFERER_)
            {
                curl_setopt($ch, CURLOPT_REFERER, $REFERER_);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $get_url = curl_exec($ch);
            curl_close($ch);
            return $get_url;
        }
        public static function charCodeAt($str, $index)
        {
            $charCode = array();
            $key = md5($str);
            $index = $index + 1;
            if (isset($charCode[$key]))
            {
                return $charCode[$key][$index];
            }
            $charCode[$key] = unpack('C*', $str);
            return $charCode[$key][$index];
        }
        public static function charAt($str, $index = 0)
        {
            return substr($str, $index, 1);
        }
        public static function fromCharCode($codes)
        {
            if (is_scalar($codes))
            {
                $codes = func_get_args();
            }
            $str = '';
            foreach ($codes as $code)
            {
                $str .= chr($code);
            }
            return $str;
        }
        public static function yk_e($a, $c)
        {
            for ($f = 0, $i, $e = '', $h = 0; 256 > $h; $h++)
            {
                $b[$h] = $h;
            }
            for ($h = 0; 256 > $h; $h++)
            {
                $f = (($f + $b[$h]) + self::charCodeAt($a, $h % strlen($a))) % 256;
                $i = $b[$h];
                $b[$h] = $b[$f];
                $b[$f] = $i;
            }
            for ($q = ($f = ($h = 0)); $q < strlen($c); $q++)
            {
                $h = ($h + 1) % 256;
                $f = ($f + $b[$h]) % 256;
                $i = $b[$h];
                $b[$h] = $b[$f];
                $b[$f] = $i;
                $e .= self::fromCharCode(self::charCodeAt($c, $q) ^ $b[($b[$h] + $b[$f]) % 256]);
            }
            return $e;
        }
        public static function yk_d($a)
        {
            $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
            if (!$a)
            {
                return '';
            }
            $f = strlen($a);
            $b = 0;
            for ($c = ''; $b < $f ;  )
            {
                $e = self::charCodeAt($a, $b++) &255;
                if ($b == $f)
                {
                    $c .= self::charAt($str, $e >> 2);
                    $c .= self::charAt($str, ($e &3) << 4);
                    $c .= '==';
                    break;
                }
                $g = self::charCodeAt($a, $b++);
                if ($b == $f)
                {
                    $c .= self::charAt($str, $e >> 2);
                    $c .= self::charAt($str, ($e &3) << 4 | ($g &240) >> 4);
                    $c .= self::charAt($str, ($g &15) << 2);
                    $c .= '=';
                    break;
                }
                $h = self::charCodeAt($a, $b++);
                $c .= self::charAt($str, $e >> 2);
                $c .= self::charAt($str, ($e &3) << 4 | ($g &240) >> 4);
                $c .= self::charAt($str, ($g &15) << 2 | ($h &192) >> 6);
                $c .= self::charAt($str, $h &63);
            }
            return $c;
        }
        public static function get_m3u8_url($youku_ID, $type = 'flv')
        {
            $video_info = self::curl('http://v.youku.com/player/getPlayList/VideoIDS/' . $youku_ID . '/ctype/12/ev/1');
            $obj = json_decode($video_info);
            $vid = $obj->data[0]->videoid;
            $oip = $obj->data[0]->ip;
            $epdata = $obj->data[0]->ep;
            $youku_m3u8 = self::_calc_ep2($vid, $epdata);
            $m3u8_url = 'http://pl.youku.com/playlist/m3u8?vid=' . $vid . '&type=' . $type . '&ep=' . urlencode($youku_m3u8['ep']) . '&token=' . $youku_m3u8['token'] . '&ctype=12&ev=1&oip=' . $oip . '&sid=' . $youku_m3u8['sid'];
            return $m3u8_url;
        }
        public static function _calc_ep2($vid, $ep)
        {
            $e_code = self::yk_e('becaf9be', base64_decode($ep));
            $s_t = explode('_', $e_code);
            $sid = $s_t[0];
            $token = $s_t[1];
            // $new_ep = trans_e('bf7e5f01', '%s_%s_%s' % ($sid.$vid.$token));
            $new_ep = self::yk_e('bf7e5f01', $sid . '_' . $vid . '_' . $token);
            $new_ep = base64_encode($new_ep); //可以换作下面代码 
            // $new_ep = iconv('gbk', 'UTF-8', self::yk_d($new_ep));
            return array('ep' => $new_ep,
                'token' => $token,
                'sid' => $sid,
                );
        }
    }
?>
