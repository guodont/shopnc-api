<style type="text/css">
.arrival-tip { font: 14px/20px "Microsoft Yahei"; color: #669900; text-align: center; padding: 30px 0 10px 0;}
.arrival-tip i { font-size: 36px; vertical-align: middle; margin-right: 8px;}
.recommend { padding: 10px;}
.recommend .title { font-size: 14px; font-weight: 600; color: #666; padding: 5px 10px; border-bottom: solid 1px #EEE;}
.recommend ul { font-size: 0; *word-spacing:-1px/*IE6、7*/;}
.recommend li { font-size: 12px; vertical-align: top; letter-spacing: normal; word-spacing: normal; display: inline-block; *display: inline/*IE7*/; width: 25%; padding: 15px 0; *zoom: 1/*IE7*/;}
.recommend dl { width: 90px; margin: 0 auto;}
.recommend dt { width: 90px; height: 90px; border: solid 1px #F5F5F5; position: relative; z-index: 1;}
.recommend dt a { background-color: #FFF; text-align: center; vertical-align: middle; display: table-cell; *display: block; width: 90px; height:90px; overflow: hidden;}
.recommend dt img { display: block; max-width: 90px; max-height: 90px; margin-top:expression(90-this.height/2); *margin-top:expression(45-this.height/2);}
.recommend dt em { color: #FFF; background-color: #D93600; padding: 0 5px; position: absolute; z-index: 1; bottom: 0; left: 0;}
.recommend dd { line-height: 16px; height: 32px; overflow: hidden; margin-top: 8px;}
</style>
<div class="eject_con">
  <div class="arrival-tip"><i class="icon-ok-circle"></i>一旦商品在30日内到货，您将收到邮件或短信通知！</div>
</div>
<?php if(!empty($output['goods_list'])){?>
<div class="recommend">
  <div class="title">你可能喜欢的商品</div>
  <ul>
    <?php foreach($output['goods_list'] as $value){?>
    <li>
      <dl>
        <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_jingle'];?>"><img src="<?php echo thumb($value, 240);?>" alt="<?php echo $value['goods_name'];?>"/></a><em><?php echo $lang['currency'];?><?php echo $value['goods_price'];?></em></dt>
        <dd><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_name'];?><?php echo $value['goods_jingle'];?>"><?php echo $value['goods_name'];?></a></dd>
      </dl>
    </li>
    <?php }?>
  </ul>
</div>
<?php }?>
