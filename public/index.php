<?php  
// 请将这里的网址改为自己的（顶级）域名地址  
$myDomain = 'stg-kingwdywebgo.avosapps.us';  
  
// 这里用正则提取 $_SERVER["QUERY_STRING"] 而不是直接 get url  
// 是因为如果链接中自身带有 GET 参数则会导致获取不完整  
preg_match('/url=(.*)/i', $_SERVER["QUERY_STRING"], $jumpUrl);   
  
// 如果没获取到跳转链接，直接跳回首页  
if(!isset($jumpUrl[1])) {  
    header("location:/");  
    exit();  
}  
  
$jumpUrl = $jumpUrl[1];  
  
// 判断是否包含 http:// 头，如果没有则加上  
preg_match('/(http|https):\/\//', $jumpUrl, $matches);      
  
$url = $matches? $jumpUrl: 'http://'. $jumpUrl;  
  
  
// 判断网址是否完整  
preg_match('/[\w-]*\.[\w-]*/i', $url, $matche);      
  
// 是否需要给出跳转提示  
$echoTips = false;  
  
if($matche){  
    // 如果是本站的链接，不展示动画直接跳转  
    if(isMyDomain($url, $myDomain)) {  
        header("location:{$url}");  
        exit();    // 后续操作不再执行  
    }  
      
    $title = '页面加载中,请稍候...';  
    $fromUrl = isset($_SERVER["HTTP_REFERER"])? $_SERVER["HTTP_REFERER"]: ''; // 获取来源url  
      
    // 如果来源和跳转后的地址都不是本站，那么就要给出提示  
    if(!isMyDomain($fromUrl, $myDomain)) {  
        $echoTips = true;  
    }  
} else {    // 网址参数不完整  
    $url = '/';  
    $title = '参数错误，正在返回首页...';  
}  
  
  
/** 
 * 判断是不是自己的域名 
 * @param $domain 要进行判断的域名 
 * @param $my 自己的域名 
 * @return 对比结果 
 */  
function isMyDomain($domain, $my) {  
    preg_match('/([^\?]*)/i', $domain, $match);  
    if(isset($match[1])) $domain = $match[1];  
    preg_match('/([\w-]*\.[\w-]*)\/.*/i', $domain.'/', $match);  
    if(isset($match[1]) && $match[1] == $my) return true;  
    return false;  
}  
  
?>  
<html>  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
<meta http-equiv="X-UA-Compatible" content="IE=edge">  
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">  
<?php  
if($echoTips) {  
    echo '<title>跳转提示</title>';  
} else {  
    echo '<meta http-equiv="refresh" content="0;url='.$url.'">';  
    echo '<title>'.$title.'</title>';  
}  
?>  
<style>  
body{background:#fff;font-family:Microsoft Yahei;-webkit-animation:fadeIn 1s linear;animation:fadeIn 1s linear}  
@-webkit-keyframes fadeIn{from{opacity:0}  
to{opacity:1}  
}@keyframes fadeIn{from{opacity:0}  
to{opacity:1}  
}#circle{background-color:rgba(0,0,0,0);border:5px solid rgba(0,183,229,0.9);opacity:.9;border-right:5px solid rgba(0,0,0,0);border-left:5px solid rgba(0,0,0,0);border-radius:50px;box-shadow:0 0 35px #2187e7;width:50px;height:50px;margin:0 auto;position:fixed;left:30px;bottom:30px;-moz-animation:spinPulse 1s infinite ease-in-out;-webkit-animation:spinPulse 1s infinite ease-in-out;-o-animation:spinPulse 1s infinite ease-in-out;-ms-animation:spinPulse 1s infinite ease-in-out}  
#circle1{background-color:rgba(0,0,0,0);border:5px solid rgba(0,183,229,0.9);opacity:.9;border-left:5px solid rgba(0,0,0,0);border-right:5px solid rgba(0,0,0,0);border-radius:50px;box-shadow:0 0 15px #2187e7;width:30px;height:30px;margin:0 auto;position:fixed;left:40px;bottom:40px;-moz-animation:spinoffPulse 1s infinite linear;-webkit-animation:spinoffPulse 1s infinite linear;-o-animation:spinoffPulse 1s infinite linear;-ms-animation:spinoffPulse 1s infinite linear}  
@-webkit-keyframes spinPulse{0%{-webkit-transform:rotate(160deg);opacity:0;box-shadow:0 0 1px #505050}  
50%{-webkit-transform:rotate(145deg);opacity:1}  
100%{-webkit-transform:rotate(-320deg);opacity:0}  
}@-webkit-keyframes spinoffPulse{0%{-webkit-transform:rotate(0deg)}  
100%{-webkit-transform:rotate(360deg)}  
}#loading-text{position:fixed;left:110px;bottom:35px;color:#736D6D}  
@media screen and (max-width:600px){#circle,#circle1{left:0;right:0;top:0;bottom:0}  
#circle{margin:120px auto}  
#circle1{margin:130px auto}  
#loading-text{display:block;text-align:center;margin-top:220px;position:static;margin-left:10px}  
}  
.warning{max-width: 500px;margin: 20px auto;}  
.wtitle {font-size: 22px;color: #d68300;}  
.wurl {overflow: hidden;text-overflow: ellipsis;white-space: nowrap;color: #827777;}  
.btn {display: inline-block;line-height: 20px;cursor: pointer;border: 1px solid #A9A6A6;padding: 6px 10px;font-size: 14px;text-decoration: none;}  
.btn-green {color: #fff;background-color: #238aca;border: 1px solid #238aca;}  
.btn:hover {background-color: #A9A6A6;border: 1px solid #A9A6A6;color: #fff;}  
</style>  
</head>  
<body>  
    <?php if($echoTips) { ?>  
    <div class="warning">  
        <p class="wtitle">您将要访问：</p>  
        <p class="wurl" title="<?php echo $url;?>"><?php echo $url;?></p>  
        <p>该网站不属于孟坤博客，我们无法确认该网页是否安全，它可能包含未知的安全隐患。</p>  
        <a class="btn btn-green" href="<?php echo $url;?>" rel="nofollow">继续访问</a>  
        <span class="btn" onclick="closePage()">关闭网页</span>  
    </div>  
    <script>  
    function closePage() {  
        // 通用窗口关闭  
        window.opener=null;  
        window.open('','_self');  
        window.close();  
        // 微信浏览器关闭  
        WeixinJSBridge.call('closeWindow');  
    }  
    </script>  
    <?php } else { ?>  
    <div id="circle"></div>  
    <div id="circle1"></div>  
    <p id="loading-text">页面加载中，请稍候...</p>  
    <?php } ?>  
</body>  
</html>  
