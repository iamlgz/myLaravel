<?php
use Illuminate\Support\Facades\URL;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>小米商城</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('/css/style.css')}}">
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

	<!-- start banner_y -->
		<div class="banner_y center">
			<div class="nav">				
				<ul>
					@foreach($result as $v)
					<li>
						<a href="{{URL::asset('')}}">{{$v['c_name']}}</a>
						<div class="pop">
							<div class="left fl">
							@if(isset($v['left']))
								@foreach($v['left'] as $va)
									<div>
										<div class="xuangou_left fl">
											<a href="{{URL::asset('detail?id='.$va['goods_id'])}}">
												<div class="img fl"><img src="{{URL::asset("storage/$va[goods_img]")}}" width="33px" height="39px"></div>
												<span class="fl">{{$va['goods_name']}}</span>
												<div class="clear"></div>
											</a>
										</div>
										<div class="xuangou_right fr"><a href="{{URL::asset('detail?id='.$va['goods_id'])}}" target="_blank">选购</a></div>
										<div class="clear"></div>
									</div>
									@endforeach
							@endif
								</div>
							<div class="ctn fl">
								@if(isset($v['center']))
									@foreach($v['center'] as $val)
								<div>
									<div class="xuangou_left fl">
										<a href="{{URL::asset('detail?id='.$val['goods_id'])}}">
											<div class="img fl"><img src="{{URL::asset("storage/$val[goods_img]")}}" alt=""></div>
											<span class="fl">{{$val['goods_name']}}</span>
											<div class="clear"></div>
										</a>
									</div>
									<div class="xuangou_right fr"><a href="{{URL::asset('detail?id='.$val['goods_id'])}}">选购</a></div>
									<div class="clear"></div>
								</div>
									@endforeach
								@endif
							</div>
							<div class="right fl">
								@if(isset($v['right']))
									@foreach($v['right'] as $value)
								<div>
									<div class="xuangou_left fl">
										<a href="{{URL::asset('detail?id='.$value['goods_id'])}}">
											<div class="img fl"><img src="{{URL::asset("storage/$value[goods_img]")}}" alt=""></div>
											<span class="fl">{{$val['goods_name']}}</span>
											<div class="clear"></div>
										</a>
									</div>
									<div class="xuangou_right fr"><a href="{{URL::asset('detail?id='.$value['goods_id'])}}">选购</a></div>
									<div class="clear"></div>
								</div>
									@endforeach
								@endif
							</div>
							<div class="clear"></div>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		
		</div>	

		<div class="sub_banner center">
			<div class="sidebar fl">
				@foreach($bottom['service'] as $v)
				<div class="fl"><a href="{{URL::asset("$v[url]")}}"><img src="{{URL::asset("$v[img]")}}"></a></div>
				@endforeach
				<div class="clear"></div>
			</div>
				@foreach($bottom['goods'] as $va)
					<div class="datu fl"><a href="{{URL::asset('detail/'.$va['goods_id'])}}"><img src="{{URL::asset($va['img'])}}" alt=""></a></div>
				@endforeach
			<div class="clear"></div>
		</div>
	<!-- end banner -->

	<!-- start danpin -->
		<div class="danpin center">
			
			<div class="biaoti center">小米明星单品</div>
			<div class="main center">
				@foreach($start as $v)
				<div class="mingxing fl">
					<div class="sub_mingxing"><a href="{{URL::asset('detail/'.$v['goods_id'])}}"><img src="{{URL::asset($v['img'])}}" alt=""></a></div>
					<div class="pinpai"><a href="{{URL::asset('detail/'.$v['goods_id'])}}">{{$v['goods_name']}}</a></div>
					<div class="youhui">{{$v['describe']}}</div>
					<div class="jiage">{{$v['goods_price']}}元起</div>
				</div>
				@endforeach
				<div class="clear"></div>
			</div>
		</div>
		<div class="peijian w">
			<div class="biaoti center">配件</div>
			<div class="main center">
				<div class="content">
					@foreach($parts['top'] as $value)
						@if($value['type'] == 'newlist')
							<div class="remen fl"><a href="{{URL::asset('')}}"><img src="{{URL::asset($value['img'])}}"></a></div>
							@else
							<div class="remen fl">
								<div class="xinpin"><span style="background:#fff"></span></div>
								<div class="tu"><a href="{{URL::asset('')}}"><img src="{{URL::asset($value['img'])}}"></a></div>
								<div class="miaoshu"><a href="{{URL::asset('')}}">{{$value['description']}}</a></div>
								<div class="jiage">{{$value['goods_price']}}元</div>
								<div class="pingjia">372人评价</div>
								@if(!empty($value['describe']))
									<div class="piao">
										<a href="{{URL::asset('')}}">
											<span>{{$value['describe']}}</span>
											<span>来至于mi狼牙的评价</span>
										</a>
									</div>
								@endif
							</div>
						@endif
					@endforeach
					<div class="clear"></div>
				</div>
				<div class="content">
					@foreach($parts['bottom'] as $value)
						@if($value['type'] == 'newlist')
							<div class="remen fl"><a href="{{URL::asset('')}}"><img src="{{URL::asset($value['img'])}}"></a></div>
						@else
							<div class="remen fl">
								<div class="xinpin"><span style="background:#fff"></span></div>
								<div class="tu"><a href="{{URL::asset('')}}"><img src="{{URL::asset($value['img'])}}"></a></div>
								<div class="miaoshu"><a href="{{URL::asset('')}}">{{$value['description']}}</a></div>
								<div class="jiage">{{$value['goods_price']}}元</div>
								<div class="pingjia">372人评价</div>
								@if(!empty($value['describe']))
									<div class="piao">
										<a href="{{URL::asset('')}}">
											<span>{{$value['describe']}}</span>
											<span>来至于mi狼牙的评价</span>
										</a>
									</div>
								@endif
							</div>
						@endif
					@endforeach
						<div class="remenlast fr">
							<div class="hongmi"><a href="{{URL::asset($parts['last'][0]['url'])}}"><img src="{{URL::asset($parts['last'][0]['img'])}}" alt=""></a></div>
							<div class="liulangengduo"><a href="{{URL::asset($parts['last'][1]['url'])}}"><img src="{{URL::asset($parts['last'][1]['img'])}}" alt=""></a></div>
						</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	@include("layouts.footer")
	</body>
</html>