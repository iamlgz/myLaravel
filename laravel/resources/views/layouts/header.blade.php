<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/27
 * Time: 14:27
 */
?>
        <div class="top center">
            <div class="left fl">
                <ul>
                    <li><a href="index" target="_blank">小米商城</a></li>
                    <li>|</li>
                    <li><a href="">MIUI</a></li>
                    <li>|</li>
                    <li><a href="">米聊</a></li>
                    <li>|</li>
                    <li><a href="">游戏</a></li>
                    <li>|</li>
                    <li><a href="">多看阅读</a></li>
                    <li>|</li>
                    <li><a href="">云服务</a></li>
                    <li>|</li>
                    <li><a href="">金融</a></li>
                    <li>|</li>
                    <li><a href="">小米商城移动版</a></li>
                    <li>|</li>
                    <li><a href="">问题反馈</a></li>
                    <li>|</li>
                    <li><a href="">Select Region</a></li>
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="right fr">
                <div class="gouwuche fr"><a href="cart">购物车</a></div>
                <div class="fr">
                    <ul>
                        @if(empty(session('username')))
                        <li><a href="login" target="_blank">登录</a></li>
                        <li>|</li>
                        <li><a href="register" target="_blank" >注册</a></li>
                        <li>|</li>
                        @else
                            <li><a href="selfinfo" target="_blank" >{{session('username')}}</a></li>
                            <li>|</li>
                            <li><a href="loginout" target="_blank" >退出</a></li>
                            <li>|</li>
                        @endif
                        <li><a href="">消息通知</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
