{extend name="public:base" /}
{block name="head"}
<link href="__PUBLIC__/view_res/mobile/css/uc.css" type="text/css" rel="Stylesheet" />

{/block} 

{block name="content"}

<div id="wrapper">
    <div class="close"></div>
</div>

<div class="uc-headwrap" style='background-image: url(__RES__/mobile/images/ucbag/bag2.jpg);'>
    <div class="uc-head">
    	{if condition="in_wechat()"}
	        <a class="headwrap"><img src="{$userinfo.userpic}/0"/></a>	             
        {else/}
	        <a class="headwrap">
	        	{if condition="!empty($userinfo['userpic'])"}
	        	<img src="{$userinfo.userpic}"/>
	        	{else/}
	        	<img src="__RES__/mobile/images/icon/iconfont-iconname_2x.png"/>
	        	{/if}
	        </a>  
        {/if}
        <span class="uc-name">{$userinfo.nickname}</span>   
    </div>
    <div class="comspreadstat clearfix">
        <span class="spread-item" onclick="location.href = '{:url("Points/points_list")}';"><b>{$userinfo.points}</b>积分</span>        
        <span class="spread-item" onclick="location.href = '{:url("User/wish_list")}';"><b>{$userinfo.wish}</b>收藏</span>
    </div>
</div>

<div class="uc-section" onclick="location.href = '{:url("order/index")}';"><i class='dingdan'></i><b>查看全部</b>我的订单</div>

<div class='uc-order-sec clearfix'>
    <a class='uc-order-btn fukuan' href="{:url('order/index',array('status'=>config('default_order_status_id')))}"><i></i>待付款<b class='prices'>{$no_pay|default='0'}</b></a>
    <a class='uc-order-btn fahuo' href="{:url('order/index',array('status'=>config('paid_order_status_id')))}"><i></i>待发货<b class='prices'>{$paid|default='0'}</b></a>    
</div>

<div class="uc-section" onclick="location.href = '{:url("user/wish_list")}';">
    <i></i><b>我喜欢，我收藏</b>我的收藏
</div>

<div class="uc-section" onclick="location.href = '{:url("points/index")}'">
    <i class='credit'></i><b>您有 {$userinfo.points-$userinfo.cash_points} 积分可兑换</b>积分兑换
</div>	
	{if condition="$userinfo['is_agent'] EQ 1"}	
	        <div class="uc-section" onclick="location.href = '{:url("Agent/sub_agent")}'">
	            <i class='hezuo'></i><b>总收益： &yen; {$userinfo.total_bonus|0} </b>我的代理
	        </div>
	        <div class="uc-section" onclick="location.href = '{:url("Agent/my_agent_info")}'">
	            <i class='infoedit'></i><b>可查看/修改资料</b>我的资料
	        </div>
	        <div class="uc-section" id="companyQrcode">
	            <i class='qrcode'></i><b>一起来推广吧</b>推广分享
	        </div>
	        <div style="height:100px;"></div>	        
	{else/}
	    <div class="uc-section" onclick="location.href = '{:url("Agent/apply_agent")}'">
	        <i class='hezuo'></i><b>加入代理，共同成长</b>成为代理
	    </div>
	{/if}
{if condition="in_wechat()"}{/if}

{/block}

{block name="footer"}
{include file="public/footer-nav" /}
{/block}

{block name="script"}
<script data-main="__RES__/mobile/js/shop_uchome.js" src="__RES__/mobile/js/require.min.js"></script>
{/block}