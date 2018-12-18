<?php

use Carbon\Carbon;

function dd2($data)
{
    print_r($data);exit;

}

function ddb()
{
    dd(\DB::getQueryLog());
}

function ddj($data)
{
    dd(json_decode($data, true));
}

function userInfo()
{
    $user = auth()->user();

    if (is_null($user)) {
        return '';
    } else {
        return $user;
    }
    //
    // if (Cache::store('array')->has('userInfo')) {

    //     return Cache::store('array')->get('userInfo');
    // }

    // $user = auth()->user();

    // if (is_null($user)) {
    //     Cache::store('array')->put('userInfo', '', 10);
    // } else {
    //     Cache::store('array')->put('userInfo', $user, 10);
    // }
    // return Cache::store('array')->get('userInfo');

}

function subToday($day = 1)
{
    return Carbon::today()->subDay($day)->timestamp;
}

function addToday($day = 1)
{
    return Carbon::today()->addDay($day)->timestamp;
}

function is_true($val, $return_null = false)
{
    $boolval = (is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val);
    return ($boolval === null && !$return_null ? false : $boolval);
}

//過濾予許的網址
function stringAllowUrl(string $str): string
{
    return str_replace(PHP_EOL, '', preg_replace('/[^\w\+\.\-\x{4e00}-\x{9fa5}]+/isu', '', $str));
}

//過濾最後面/的網址
function filterLastUrl(string $url): string
{
    return substr($url, 0, strrpos($url, "/"));
}

//抓取最後面/的網址
function getLastUrl(string $url): string
{
    return substr($url, strrpos($url, "/") + 1);
}

//抓取使用者來源IP
function getClientIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddresses = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddresses = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ipAddresses = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipAddresses = '127.0.0.1';
    }
    $ipAddresses = explode(',', $ipAddresses);
    return $ipAddresses[0];
}
