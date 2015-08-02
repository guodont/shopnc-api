<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div id="ncmInformFlow" class="ncm-flow-container">
    <div class="title">
      <h3>咨询平台客服</h3>
    </div>
    <div class="ncm-flow-step">
      <dl class="step-first current">
        <dt>填写咨询内容</dt>
        <dd class="bg"></dd>
      </dl>
      <dl class="<?php if ($output['consult_info']['is_reply'] == 1) {?>current<?php }?>">
        <dt>平台客服回复</dt>
        <dd class="bg"> </dd>
      </dl>
      <dl class="<?php if ($output['consult_info']['is_reply'] == 1) {?>current<?php }?>">
        <dt>咨询完成</dt>
        <dd class="bg"> </dd>
      </dl>
    </div>
    <div class="ncm-default-form">
      <dl>
        <dt>咨询类型<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <?php echo $output['type_list'][$output['consult_info']['mct_id']]['mct_name'];?>
        </dd>
      </dl>
      <dl>
        <dt>咨询内容<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <?php echo $output['consult_info']['mc_content'];?>
        </dd>
      </dl>
      <dl>
        <dt>咨询时间<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <?php echo date('Y-m-d H:i:s', $output['consult_info']['mc_addtime']);?>
        </dd>
      </dl>
      <dl>
        <dt>回复状态<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <?php echo $output['state'][$output['consult_info']['is_reply']];?>
        </dd>
      </dl>
      <?php if ($output['consult_info']['is_reply'] == 1) {?>
      <dl>
        <dt>回复内容<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <?php echo $output['consult_info']['mc_reply'];?>
        </dd>
      </dl>
      <?php }?>
      <div class="bottom"><a href="javascript:history.go(-1);" class="ncm-btn ml10">返回列表</a></div>
    </div>
  </div>
  <div class="ncm-flow-item">
    <div class="title">温馨提示</div>
    <div class="content">
      <div class="alert">
        <ul>
          <li> 1.如果您对商品规格、介绍等有疑问，可以在商品详情页“购买咨询”处发起咨询，会得到及时专业的回复；</li>
          <li> 2.如需处理交易中产生的纠纷，请选择投诉；</li>
          <li> 3.举报时依次选择咨询类型，填写违规描述（必填，不超过200字）。请尽量详细填写您要咨询的内容，以方便我们用最短的时间解决您的疑问。</li>
        </ul>
      </div>
    </div>
  </div>
</div>
