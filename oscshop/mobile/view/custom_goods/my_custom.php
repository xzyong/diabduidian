<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>我的定制</title>
    <link rel="stylesheet" href="css/weui.min.css">
    <link rel="stylesheet" href="css/jquery-weui.min.css">
    <link rel="stylesheet" href="css/example.css" />
    <link rel="stylesheet" href="css/my-sytle.css">
</head>
<body>


<div class="my-order">
    <div class="order-lest">
        <div class="weui-row weui-no-gutter text-center">
            <div class="weui-col-25"><a class="in" href="my_custom.php">全部定制</a></div>
            <div class="weui-col-15"><a href="custom_dqr.php">待确认</a></div>
            <div class="weui-col-20"><a href="custom_dfk.php">待付款</a></div>
            <div class="weui-col-20"><a href="custom_dzz.php">定制中</a></div>
            <div class="weui-col-20"><a href="custom_dsh.php">待收货</a></div>
        </div>
    </div>
<!--    待确定-状态  -->
    <div class="my-product">
        <a href="javascript:;" class="open-popup" data-target="#order_details">
        <div class="products">
            <div class="left"><img src="images/qi.jpg" width="60px" height="60px"></div>
            <div class="center">
                <b>标题：我是标题  我是标题我是标题  我是标题我是标题 超出部分会自动隐藏</b>
                <p>作者：宋勉</p>
                <p>下单时间：2012-12-13</p>
            </div>
            <div class="right text-right">
                <p>￥1888.00</p>
                <p>x1</p>
            </div>
        </div>
        </a>
        <div class="more text-right">
            <a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default" id="End">取消订单</a>
            <a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default" id="Pending_confirmation">待确认</a>
        </div>
    </div>
<!--    待确定-状态  END-->
    
<!--    待付定金-状态  -->
    <div class="my-product">
       <a href="javascript:;" class="open-popup" data-target="#order_details">
        <div class="products">
            <div class="left"><img src="images/qi.jpg" width="60px" height="60px"></div>
            <div class="center">
                <b>标题：我是标题  我是标题我是标题  我是标题我是标题 超出部分会自动隐藏</b>
                <p>作者：宋勉</p>
                <p>下单时间：2012-12-13</p>
            </div>
            <div class="right text-right">
                <p>￥1888.00</p>
                <p>x1</p>
            </div>
        </div>
        </a>
        <div class="more text-right">
            <a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default in open-popup on" data-target="#half">待付款</a>
        </div>
    </div>
<!--    待付定金-状态 END   -->

   
<!--    制作中-状态  -->
    <div class="my-product">
       <a href="javascript:;" class="open-popup" data-target="#order_details">
        <div class="products">
            <div class="left"><img src="images/qi.jpg" width="60px" height="60px"></div>
            <div class="center">
                <b>标题：我是标题  我是标题我是标题  我是标题我是标题 超出部分会自动隐藏</b>
                <p>作者：宋勉</p>
                <p>下单时间：2012-12-13</p>
            </div>
            <div class="right text-right">
                <p>￥1888.00</p>
                <p>x1</p>
            </div>
        </div>
        </a>
        <div class="more text-right">
            <a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default on" id="Deliver-goods">定制中</a>
        </div>
    </div>
<!--    制作中-状态  END   -->

<!--    待发货-状态  -->
    <div class="my-product">
       <a href="javascript:;" class="open-popup" data-target="#order_details">
        <div class="products">
            <div class="left"><img src="images/qi.jpg" width="60px" height="60px"></div>
            <div class="center">
                <b>标题：我是标题  我是标题我是标题  我是标题我是标题 超出部分会自动隐藏</b>
                <p>作者：宋勉</p>
                <p>下单时间：2012-12-13</p>
            </div>
            <div class="right text-right">
                <p>￥1888.00</p>
                <p>x1</p>
            </div>
        </div>
        </a>
        <div class="more text-right">
           <a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default" id='express'>快递单号</a>
            <a href="javascript:;" class="weui_btn weui_btn_mini weui_btn_default in open-popup" id="determination">确定收货</a>
        </div>
    </div>
<!--    待发货状态  END   -->





<!--  待付款弹窗部分  -->
<div id="half" class='weui-popup-container popup-bottom' style="margin-bottom:55px;">
      <div class="weui-popup-overlay"></div>
      <div class="weui-popup-modal">
        <div class="toolbar">
          <div class="toolbar-inner">
            <a href="javascript:;" class="picker-button close-popup">x</a>
            <h1 class="title" style="text-align: center;">付款详情</h1>
          </div>
        </div>
        <div class="modal-content">
          <div class="weui_cells">
          
          <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
              <p>付款方式</p>
            </div>
            <div class="weui_cell_ft">
              微信支付
            </div>
          </div>
          
          <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
              <p>需支付：</p>
            </div>
            <div class="weui_cell_ft">
              <b style="font-size:20px; color:red;">1888元</b>
            </div>
          </div>
        </div>
        <a href="javascript:;" class="weui_btn weui_btn_primary close-popup" style="margin:60px 10px 10px 10px;">确定付款</a>
        </div>
      </div>
    </div>
<!--  待付款弹窗部分  END  -->   
<!--  订单详情-弹窗部分  -->
 <div id="order_details" class='weui-popup-container order_details'>
      <div class="weui-popup-modal">
       <div class="top">
           <div class="left"><img src="images/dw.png" alt=""></div>
           <div class="right">
               <p>收货人：柳妃妃 <span>13432353852</span></p>
               <p>收货地址：广东省 深圳市 宝安区 松岗镇 松岗街道 芙蓉路9号 桃花源创新科技园B栋603</p>
           </div>
       </div>
       <div class="weui_cells" style="margin-top:10px;">
          <div class="weui_cell">
            <div class="weui_cell_bd weui_cell_primary">
              <p>交付时间</p>
            </div>
            <div class="weui_cell_ft">
              2017-02-13
            </div>
          </div>
        </div>
       <div class="weui_panel weui_panel_access">
          <div class="weui_panel_bd">
            <div class="weui_media_box weui_media_text">
              <h4 class="weui_media_title">相关事宜说明：</h4>
              <p class="weui_media_desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>
            </div>
          </div>
        </div>
        
       <div class="my-product">
        <div class="products">
            <div class="left"><img src="images/qi.jpg" width="60px" height="60px"></div>
            <div class="center">
                <b>标题：我是标题  我是标题我是标题  我是标题我是标题 超出部分会自动隐藏</b>
                <p>作者：宋勉</p>
                <p>下单时间：2012-12-13</p>
            </div>
            <div class="right text-right">
                <p class="red">￥1888.00</p>
                <p>x1</p>
            </div>
        </div>
    </div>
       
        <article class="weui_article">
          <section>
            <a href="javascript:;" class="weui_btn weui_btn_primary close-popup" style="margin-bottom:55px;">关闭</a>
          </section>
        </article>
      </div>
</div>
<!--  订单详情-弹窗部分  END  -->
</div>

<?php include 'bottom.html' ?>
</body>
<script>
      $(document).on("click", "#express", function() {
        $.alert("888 5455 8452", "顺丰快递");
      });
    $(document).on("click", "#End", function() {
        $.confirm("您确定要取消此订单吗？", "确认取消?", function() {
          $.toast("订单已取消!");
        }, function() {
          //取消操作
        });
      });
    $(document).on("click", "#determination", function() {
        $.confirm("您确定已经收到包裹了吗？？？", "确认收货?", function() {
          $.toast("操作成功");
        }, function() {
          //取消操作
        });
      });
    $(document).on("click", "#Deliver-goods", function() {
        $.alert("请耐心等候哦！", "您的宝贝正在紧张制作中！");
      });
    $(document).on("click", "#Pending_confirmation", function() {
        $.alert("请耐心等候哦！", "管理员正在审核您的定制邀约");
      });
    </script>
</html>