<?php

use App\Models\TinCertificate;
use \Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Application;
use App\Models\Notification;
use App\Models\Configure;
use App\BanglaNumberToWord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

function template($asset = false)
{
    $activeTheme = config('basic.theme');
    if ($asset) return 'assets/themes/' . $activeTheme . '/';
    return 'themes.' . $activeTheme . '.';
}


function recursive_array_replace($find, $replace, $array)
{
    if (!is_array($array)) {
        return str_replace($find, $replace, $array);
    }
    $newArray = [];
    foreach ($array as $key => $value) {
        $newArray[$key] = recursive_array_replace($find, $replace, $value);
    }
    return $newArray;
}

function menuActive($routeName, $type = null)
{
    $class = 'active';
    if ($type == 3) {
        $class = 'selected';
    } elseif ($type == 2) {
        $class = 'has-arrow active';
    } elseif ($type == 1) {
        $class = 'in';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}


function getFile($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(config('location.default'));
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function loopIndex($object)
{
    return ($object->currentPage() - 1) * $object->perPage() + 1;
}

function getAmount($amount, $length = 0)
{
    if (0 < $length) {
        return number_format($amount + 0, $length);
    }
    return $amount + 0;
}


function strRandom($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function dateTime($date, $format = 'd M, Y h:i A')
{
    return date($format, strtotime($date));
}
if (!function_exists('putPermanentEnv')) {
    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();
        $escaped = preg_quote('=' . env($key), '/');
        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

function checkTo($currencies, $selectedCurrency = 'USD')
{
    foreach ($currencies as $key => $currency) {
        if (property_exists($currency, strtoupper($selectedCurrency))) {
            return $key;
        }
    }
}

function code($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}
function invoice(){

    return time().code(4);
}
function wordTruncate($string, $offset = 0, $length = null): string
{
    $words = explode(" ", $string);
    isset($length) ? array_splice($words, $offset, $length) : array_splice($words, $offset);
    return implode(" ", $words);
}

function linkToEmbed($string)
{
    if (strpos($string, 'youtube') !== false) {
        $words = explode("/", $string);
        if (strpos($string, 'embed') == false) {
            array_splice($words, -1, 0, 'embed');
        }
        $words = str_ireplace('watch?v=', '', implode("/", $words));
        return $words;
    }
    return $string;
}


function slug($title)
{
    return \Illuminate\Support\Str::slug($title);
}
function title2snake($string)
{
    return Str::title(str_replace(' ', '_', $string));
}

function snake2Title($string)
{
    return Str::title(str_replace('_', ' ', $string));
}

function kebab2Title($string)
{
    return Str::title(str_replace('-', ' ', $string));
}

function getLevelUser($id)
{
    $ussss = new \App\Models\User();
    return $ussss->referralUsers([$id]);
}

function getPercent($total, $current)
{
    if ($current > 0 && $total > 0) {
        $percent = (($current * 100) / $total) ?: 0;
    } else {
        $percent = 0;
    }
    return round($percent, 0);
}

function flagLanguage($data)
{
    return  '{'.rtrim($data, ',').'}';
}

function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}



function resourcePaginate($data,$callback){
    return $data->setCollection($data->getCollection()->map($callback));
}


function clean($string) {
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function camelToWord($str) {
    $arr =  preg_split('/(?=[A-Z])/',$str);
    return trim(join(' ',$arr));
}


function in_array_any($needles, $haystack) {
    return (bool) array_intersect($needles, $haystack);
}



function adminAccessRoute($search) {
    $list = collect(config('role'))->pluck('access')->flatten()->intersect(auth()->guard('admin')->user()->admin_access);


    if (is_array($search)) {
        $list = $list->intersect($search);
        if(0 < count($list)){
            return true;
        }
        return  false;
    } else {

        return $list->search(function($item) use ($search) {
            if($search == $item){
                return true;
            }
            return false;
        });
    }
}
function shortName($name,$length =3)
{
  return  Str::limit(strtoupper($name),$length,'');
}
function basicControl()
{
    return \App\Models\Configure::firstOrCreate(['id' => 1]);
}

if (!function_exists('getRoute')) {
    function getRoute($route, $params = null)
    {
        return isset($params) ? route($route, $params) : route($route);
    }
}

if (!function_exists('isMenuActive')) {
    function isMenuActive($routes, $type = 0)
    {
        $class = [
            '0' => 'active',
            '1' => 'style=display:block',
            '2' => true
        ];

        if (is_array($routes)) {
            foreach ($routes as $key => $route) {
                if (request()->routeIs($route)) {
                    return $class[$type];
                }
            }
        } elseif (request()->routeIs($routes)) {
            return $class[$type];
        }

        if ($type == 1){
            return 'style=display:none';
        }
        else{
            return false;
        }
    }
}


if (!function_exists('getTitle')) {
    function getTitle($title)
    {
        return ucwords(preg_replace('/[^A-Za-z0-9]/', ' ', $title));
    }
}

if (!function_exists('getPaginate')) {
    function getPaginate($limit = 20)
    {
        return $limit;
    }
}
function en_to_bn_date( $str ) {
	$enMonth = array ( 'lm1' => 'January',
					   'lm2' => 'February',
					   'lm3' => 'March',
					   'lm4' => 'April',
					   'lm5' => 'May',
					   'lm6' => 'June',
					   'lm7' => 'July',
					   'lm8' => 'August',
					   'lm9' => 'September',
					   'lm10'=> 'October',
					   'lm11'=> 'November',
					   'lm12'=> 'December',
					   'sm1' => 'Jan',
					   'sm2' => 'Feb',
					   'sm3' => 'Mar',
					   'sm4' => 'Apr',
					   'sm5' => 'May',
					   'sm6' => 'Jun',
					   'sm7' => 'Jul',
					   'sm8' => 'Aug',
					   'sm9' => 'Sep',
					   'sm10'=> 'Oct',
					   'sm11'=> 'Nov',
					   'sm12'=> 'Dec'
					   );

	$enWeeks = array ( 'ld1' => 'Saturday',
					   'ld2' => 'Sunday',
					   'ld3' => 'Monday',
					   'ld4' => 'Tuesday',
					   'ld5' => 'Wednesday',
					   'ld6' => 'Thursday',
					   'ld7' => 'Friday',
					   'sd1' => 'Sat',
					   'sd2' => 'Sun',
					   'sd3' => 'Mon',
					   'sd4' => 'Tue',
					   'sd5' => 'Wed',
					   'sd6' => 'Thu',
					   'sd7' => 'Fri'
					   );

	$bnMonth = array ( 'lm1' => 'জানুয়ারি',
					   'lm2' => 'ফেব্রুয়ারি',
					   'lm3' => 'মার্চ',
					   'lm4' => 'এপ্রিল',
					   'lm5' => 'মে',
					   'lm6' => 'জুন',
					   'lm7' => 'জুলাই',
					   'lm8' => 'আগস্ট',
					   'lm9' => 'সেপ্টেম্বর',
					   'lm10'=> 'অক্টোবর',
					   'lm11'=> 'নভেম্বর',
					   'lm12'=> 'ডিসেম্বর',
					   'sm1' => 'জানু',
					   'sm2' => 'ফেব্রু',
					   'sm3' => 'মার্চ',
					   'sm4' => 'এপ্রি',
					   'sm5' => 'মে',
					   'sm6' => 'জুন',
					   'sm7' => 'জুলা',
					   'sm8' => 'আগ',
					   'sm9' => 'সেপ্টে',
					   'sm10'=> 'অক্টো',
					   'sm11'=> 'নভে',
					   'sm12'=> 'ডিসে'
					   );

	$bnWeeks = array ( 'ld1' => 'শনিবার',
					   'ld2' => 'রবিবার',
					   'ld3' => 'সোমবার',
					   'ld4' => 'মঙ্গলবার',
					   'ld5' => 'বুধবার',
					   'ld6' => 'বৃহস্পতিবার',
					   'ld7' => 'শুক্রবার',
					   'sd1' => 'শনি',
					   'sd2' => 'রবি',
					   'sd3' => 'সোম',
					   'sd4' => 'মঙ্গল',
					   'sd5' => 'বুধ',
					   'sd6' => 'বৃহঃ',
					   'sd7' => 'শুক্র'
					   );
	$mergeA1 = array_merge( $enMonth, $enWeeks );
	$mergeA2 = array_merge( $bnMonth, $bnWeeks );
	array_push( $mergeA1, 'AM', 'PM', 'st', 'th', 'nd', 'rd', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	array_push( $mergeA2, 'পূর্বাহ্ণ', 'অপরাহ্ণ', '', '', '', '', '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' );

	return str_ireplace(  $mergeA1, $mergeA2, $str );
}
function bn_in_word($number){
    $c = new BanglaNumberToWord();
    return $c->numToWord($number);
}
function bn_number($number){
    $engNumber = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
    $bangNumber = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
    $converted = str_replace( $engNumber, $bangNumber, $number );
    return $converted;
}
function generate_sign($text){
    $parts = explode(" ",$text);
    $sign = '';
    if (empty($text) ){
        return false;
    }
    if (empty($parts) ){
        return false;
    }
    if ( count($parts) == 1 ){
        $sign = $parts[0]; 
    } else if( count($parts) > 2 ) {
        $sign = $parts[0].' '.$parts[1];
    } else{
        $sign = $parts[0].' '.$parts[1];
    }
    return $sign;
}

function get_single_db_value($table,$id,$key){
    $string = '';
    
    $data = DB::table($table)->select($key)->where('id',$id)->first();
    if ( !blank($data) && isset($data->$key) ){
        $string = $data->$key;
    }
    return $string;
}
function inum($number){
    return number_format((float)$number, 2, '.', '');
}

function get_pending_app_count(){
    return Application::where('status',0)->count();
}
function get_settings(){
    $control =  Cache::get('settings'); //Configure::First();
    if (blank($control)){
        $s = Configure::First();
        $control = Cache::rememberForever('settings', function () use($s) {
            return json_encode($s);
        });
    }
    return json_decode($control);
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
function create_transaction($amount,$type,$details,$user_id,$tx_id = ''){
    if ( blank($tx_id) ){
        $tx_id = strtoupper(generateRandomString(8));
    }
    $t = new Transaction();
    $t->amount = $amount;
    $t->type = $type;
    $t->details = $details;
    $t->user_id = $user_id;
    $t->tx_id = $tx_id;
    $t->save();
    return $t;
}
function get_main_api_domain(){
    return 'https://api2.bdx.today';
}
function send_get_request($url){
    $client = new GuzzleHttp\Client(['http_errors' => false]);
    $res = $client->get($url);
    if ( $res->getStatusCode() == 200 ){
    return $res->getBody();
    }
    return 'failed';
}
function isDate($string) {
            $matches = array();
            $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
            if (!preg_match($pattern, $string, $matches)) return false;
            if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
            return true;
}
function get_unread_notification($user_id){
    $notifications = Notification::whereDate('created_at', date('Y-m-d'));
    $notifications->where(function($query) use($user_id) {
             return $query
                    ->where('user_id',$user_id )
                    ->orWhere('user_id','')
                    ->orWhereNull('user_id');
            });
    return $notifications->count();
} 
function _reg_data(){
    return Session::get('reg_data','');
}
function is_md5($md5 =''){
    return preg_match('/^[a-f0-9]{32}$/', $md5);
}
function send_user_api_request($user){
    $client = new GuzzleHttp\Client();
    return $client->request('POST', 'https://lxa0.com/users-api', [
    'form_params' => array_merge( array('key' => '45u348056u34oiu345u903459034'), json_decode($user,true))
    ]);
}

function generateTinNumber(): int
{
    do {
        $tin = random_int(100000000000, 999999999999); // 12 digit
    } while (TinCertificate::where('tin_number', $tin)->exists());

    return $tin;
}

function getUrlContent($url)
{
    try {
        $response = Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0',
            ])
            ->get($url);

        if ($response->successful()) {
            return $response->body();
        }

        return [
            'success' => false,
            'status'  => $response->status(),
            'message' => 'Failed to fetch content',
        ];

    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => $e->getMessage(),
        ];
    }
}


function saveUrlContent($url)
{

    $response = Http::get($url);

    if ($response->successful()) {

        $content = $response->body();

        // Save as HTML
        File::put(public_path('downloaded-page.html'), $content);

        // Save as PHP
         File::put(public_path('downloaded-page.php'), $content);

        return 'File saved successfully';
    }

    return 'Failed to fetch content';
}

function convertToCustomDate($date)
{
    $timestamp = strtotime($date);
    return strtoupper(date('d M Y', $timestamp));
}