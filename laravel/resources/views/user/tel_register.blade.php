<?php
use Illuminate\Support\Facades\URL;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('/css/login.css')}}">
		<script src="{{URL::asset('/js/app.js')}}"></script>

	</head>
	<body>
		<form  method="post" action="register" id="form">
		<div class="regist">
			<div class="regist_center">
				<div class="regist_top">
					<div class="left fl">手机号注册</div>
					<div class="right fr"><a href="index" target="_self">小米商城</a></div>
					<div class="right fr" style="margin-right: 20px"><a href="register" target="_self">邮箱注册</a></div>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="regist_main center">
					<div class="username">手&nbsp;&nbsp;机&nbsp;&nbsp;号:&nbsp;&nbsp;<input class="shurukuang" type="tel" id="username" name="tel" placeholder="请输入你的用户名"/><span>请不要输入汉字</span></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="shurukuang" type="password" id="password" name="password" placeholder="请输入你的密码"/><span>请输入6位以上字符</span></div>
					<div class="username">确认密码:&nbsp;&nbsp;<input class="shurukuang" type="password" id="repassword" name="repassword" placeholder="请确认你的密码"/><span>两次密码要输入一致哦</span></div>
					<div class="username">
						<div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="yanzhengma" type="text" id="captcha" name="captcha" placeholder="请输入验证码"/></div>
						<div class="right fl"><img src="{{captcha_src()}}" onclick="this.src='http://www.laravel.com/index.php/captcha/default?'+Math.random()"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="regist_submit">
					<button class="submit">立即注册</button>
				</div>
			</div>
		</div>
		</form>
	</body>
</html>
<script>
    $(function () {
        $("#form").submit(function () {
            var repassword=$("#repassword").val()
            var password=$("#password").val()
            var captcha=$("#captcha").val()
            var username=$("#username").val()

			var reg=/^(133|159|185|199|132|176)\d{8}$/;

            if(!reg.test(username)){
                alert('手机号格式不正确');
                return false;
			}

            if(password==''){
                alert('密码不能为空');
                return false;
            }
            if(repassword!==password){
                alert('两次输入的密码不一致');
                return false;
            }
            if(captcha==''){
                alert('验证码不能为空');
                return false;
            }
            if(username==''){
                alert('手机号不能为空');
                return false;
            }
        })
    })
</script>