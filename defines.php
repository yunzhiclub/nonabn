<?php
/**
 * Created by PhpStorm.
 * User: panjie
 * Date: 17/3/22
 * Time: 上午11:00
 */
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$filter = new IpFilter(array('127.0.0.1 255.255.255.255', '219.243.80.0 255.255.240.0'));
if (!$filter -> check($ip)) {
    header('Location: http://www.nanobn.cn');
    return;
}

/**
 * Class IpFilter
 * https://github.com/icovn/php-ip-filter
 * @since 1.0
 */
class IpFilter
{
    private static $_IP_TYPE_SINGLE = 'single';
    private static $_IP_TYPE_WILDCARD = 'wildcard';
    private static $_IP_TYPE_MASK = 'mask';
    //icovn
    private static $_IP_TYPE_MASK_ADVANCE = 'mask_advance';
    private static $_IP_TYPE_SECTION = 'section';
    private $_allowed_ips = array();
    public function __construct($allowed_ips)
    {
        $this -> _allowed_ips = $allowed_ips;
    }
    public function check($ip, $allowed_ips = null)
    {
        $allowed_ips = $allowed_ips ? $allowed_ips : $this->_allowed_ips;
        //icovn
        if($allowed_ips != null){
            if(is_array($allowed_ips)){
                foreach($allowed_ips as $allowed_ip)
                {
                    $type = $this -> _judge_ip_type($allowed_ip);
                    $sub_rst = call_user_func(array($this,'_sub_checker_' . $type), $allowed_ip, $ip);
                    if ($sub_rst)
                    {
                        return true;
                    }
                }
            }else{
                $type = $this -> _judge_ip_type($allowed_ips);
                return call_user_func(array($this,'_sub_checker_' . $type), $allowed_ips, $ip);
            }
        }
        return false;
    }
    private function _judge_ip_type($ip)
    {
        if (strpos($ip, '*'))
        {
            return self :: $_IP_TYPE_WILDCARD;
        }
        if (strpos($ip, '/'))
        {
            return self :: $_IP_TYPE_MASK;
        }
        //icovn
        if (strpos($ip, ' '))
        {
            return self :: $_IP_TYPE_MASK_ADVANCE;
        }
        if (strpos($ip, '-'))
        {
            return self :: $_IP_TYPE_SECTION;
        }
        if (ip2long($ip))
        {
            return self :: $_IP_TYPE_SINGLE;
        }
        return false;
    }
    private function _sub_checker_single($allowed_ip, $ip)
    {
        return (ip2long($allowed_ip) == ip2long($ip));
    }
    private function _sub_checker_wildcard($allowed_ip, $ip)
    {
        $allowed_ip_arr = explode('.', $allowed_ip);
        $ip_arr = explode('.', $ip);
        for($i = 0;$i < count($allowed_ip_arr);$i++)
        {
            if ($allowed_ip_arr[$i] == '*')
            {
                return true;
            }
            else
            {
                if (false == ($allowed_ip_arr[$i] == $ip_arr[$i]))
                {
                    return false;
                }
            }
        }
    }
    private function _sub_checker_mask($allowed_ip, $ip)
    {
        list($allowed_ip_ip, $allowed_ip_mask) = explode('/', $allowed_ip);
        $begin = (ip2long($allowed_ip_ip) &ip2long($allowed_ip_mask)) + 1;
        $end = (ip2long($allowed_ip_ip) | (~ip2long($allowed_ip_mask))) + 1;
        //icovn
        if ($end < 0){
            $end += 4294967296 ;
        }
        $ip = ip2long($ip);
        return ($ip >= $begin && $ip <= $end);
    }
    //icovn
    private function _sub_checker_mask_advance($allowed_ip, $ip)
    {
        list($allowed_ip_ip, $allowed_ip_mask) = explode(' ', $allowed_ip);
        $begin = (ip2long($allowed_ip_ip) &ip2long($allowed_ip_mask)) + 1;
        $end = (ip2long($allowed_ip_ip) | (~ip2long($allowed_ip_mask))) + 1;
        if ($end < 0){
            $end += 4294967296 ;
        }
        $ip = ip2long($ip);
        return ($ip >= $begin && $ip <= $end);
    }
    private function _sub_checker_section($allowed_ip, $ip)
    {
        list($begin, $end) = explode('-', $allowed_ip);
        $begin = ip2long($begin);
        $end = ip2long($end);
        $ip = ip2long($ip);
        return ($ip >= $begin && $ip <= $end);
    }
}