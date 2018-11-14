<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>小米6立即购买-小米商城</title>
		<link rel="stylesheet" type="text/css" href={{\Illuminate\Support\Facades\URL::asset('/css/style.css')}}>
		<script src="{{\Illuminate\Support\Facades\URL::asset('/js/app.js')}}"></script>
	</head>
	<body>
	<!-- start header -->
	<header>
		@include("layouts.header")
	</header>
	<!--end header -->

<!-- start banner_x -->
	@include("layouts.content")
<!-- end banner_x -->

	
	<!-- xiangqing -->
	<form action="post" method="">
	<div class="xiangqing">
		<div class="neirong w">
			<div class="xiaomi6 fl">{{$goods['goods_name']}}</div>
			<nav class="fr">
				<li><a href="">概述</a></li>
				<li>|</li>
				<li><a href="">变焦双摄</a></li>
				<li>|</li>
				<li><a href="">设计</a></li>
				<li>|</li>
				<li><a href="">参数</a></li>
				<li>|</li>
				<li><a href="">F码通道</a></li>
				<li>|</li>
				<li><a href="">用户评价</a></li>
				<div class="clear"></div>
			</nav>
			<div class="clear"></div>
		</div>	
	</div>
	
	<div class="jieshao mt20 w">
		<div class="left fl"><img src="{{\Illuminate\Support\Facades\URL::asset("storage/$goods[goods_img]")}}" height="562px" width="562px"></div>
		<div class="right fr">
			<div class="h3 ml20 mt20">{{$goods['goods_name']}}</div>
			<div class="jianjie mr40 ml20 mt10">{!! $goods['description'] !!}</div>
			<div class="jiage ml20 mt10">{{$goods['goods_price']}} 元</div>
			<div class="ft20 ml20 mt20">选择版本</div>
			<div class="xzbb ml20 mt10">

				@foreach($data as $k => $v)
					@if($k%2!=0)
						<div class="banben fl" style="margin-top: 7px">
							<a>
								<span>{{$v['sku_str']}} </span>
								<span>{{$v['price']}}元</span>
							</a>
						</div>
						@else
						<div class="banben fr" style="margin-top: 7px">
							<a>
								<span>{{$v['sku_str']}} </span>
								<span>{{$v['price']}}元</span>
							</a>
						</div>
					@endif
				@endforeach


			</div>
			<div class="clear"></div>
			{{--<div class="ft20 ml20 mt20">选择颜色</div>--}}
			{{--<div class="xzbb ml20 mt10">--}}
				{{--<div class="banben">--}}
					{{--<a>--}}
						{{--<span class="yuandian"></span>--}}
						{{--<span class="yanse">亮黑色</span>--}}
					{{--</a>--}}
				{{--</div>--}}

			{{--</div>--}}
			<div class="xqxq mt20 ml20">
				<div class="top1 mt10">
					<div class="left1 fl">小米6 全网通版 6GB内存 64GB 亮黑色</div>
					<div class="right1 fr">2499.00元</div>
					<div class="clear"></div>
				</div>
				<div class="bot mt20 ft20 ftbc">总计：2499元</div>
			</div>
			<div class="xiadan ml20 mt20">
					<input class="jrgwc"  type="button" name="jrgwc" value="立即选购" />
					<input class="jrgwc" type="button" name="jrgwc" value="加入购物车" />
				
			</div>
		</div>
		<div class="clear"></div>
	</div>
	</form>
	<!-- footer -->
	@include("layouts.footer")
	</body>
</html>
<script>
	$(".banben").click(function () {

    })
</script>