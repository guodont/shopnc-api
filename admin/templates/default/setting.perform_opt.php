<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_admin_perform_opt'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['memory_set_opt'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
	<table id="prompt" class="table tb-type2">
	<tbody>
	<tr class="space odd" style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
	<th class="nobg" colspan="12">
	<div class="title">
	<h5><?php echo $lang['nc_prompts'];?></h5>
	<span class="arrow"></span>
	</div>
	</th>
	</tr>
	<tr class="odd" style="background: none repeat scroll 0% 0% rgb(255, 255, 255); display: table-row;">
	<td>
	<ul>
	<li><?php echo $lang['memory_set_prompt1'];?></li>
	<li><?php echo $lang['memory_set_prompt2'];?></li>
	<li><?php echo $lang['memory_set_prompt3'];?></li>
	<li><?php echo $lang['memory_set_prompt4'];?></li>
	</ul>
	</td>
	</tr>
	</tbody>
	</table>
	<table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
		<th colspan="15"><label><?php echo $lang['memory_set_cur_status'];?></label></th>
		</tr>
		<tr>
		<th class="w24"></th>
		<th class="w84"><?php echo $lang['memory_set_type'];?></th>
		<th class="w84"><?php echo $lang['memory_set_php'];?></th>
		<th class="w84"><?php echo $lang['memory_set_config'];?></th>
		<th class="w84"><?php echo $lang['memory_set_cls'];?></th><br>
		<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td>Memcache</td>
			<td><?php echo extension_loaded('memcache') ? 'YES': 'NO';?></td>
			<td><?php echo C('cache.type') == 'memcache' ? 'YES': 'NO';?></td>
			<td>
			<?php if (extension_loaded('memcache') && C('cache.type') == 'memcache'){?>
			<a href="index.php?act=perform&op=perform&type=clear"><?php echo $lang['memory_set_cls'];?></a><?php }else{ echo '--';}?>
			</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>eAccelerator</td>
			<td><?php echo  extension_loaded('eAccelerator')? 'YES': 'NO';?></td>
			<td><?php echo C('cache.type') == 'eaccelerator' ? 'YES': 'NO';?></td>
			<td>--</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>APC</td>
			<td><?php echo function_exists('apc_cache_info') ? 'YES': 'NO';?></td>
			<td><?php echo C('cache.type') == 'apc' ? 'YES': 'NO';?></td>
			<td><?php if (function_exists('apc_cache_info') && C('cache.type') == 'apc'){?>
			<a href="index.php?act=perform&op=perform&type=clear"><?php echo $lang['memory_set_cls'];?></a><?php }else{ echo '--';}?></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Xcache</td>
			<td><?php echo function_exists('xcache_info') ? 'YES': 'NO';?></td>
			<td><?php echo C('cache.type') == 'xcache' ? 'YES': 'NO';?></td>
			<td><?php if (function_exists('xcache_info') && C('cache.type') == 'xcache'){?>
			<a href="index.php?act=perform&op=perform&type=clear"><?php echo $lang['memory_set_cls'];?></a><?php }else{ echo '--';}?></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Redis</td>
			<td><?php echo extension_loaded('redis') ? 'YES': 'NO';?></td>
			<td><?php echo C('cache.type') == 'redis' ? 'YES': 'NO';?></td>
			<td>
			<?php if (extension_loaded('redis') && C('cache.type') == 'redis'){?>
			<a href="index.php?act=perform&op=perform&type=clear"><?php echo $lang['memory_set_cls'];?></a><?php }else{ echo '--';}?>
			</td>
			<td></td>
		</tr>
	</tbody>
	</table>
<!--	<table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
		<th colspan="15"><label><?php echo $lang['memory_set_opt_moduleset'];?></label></th>
		</tr>
		<tr>
		<th class="w24"></th>
		<th class="w84"><?php echo $lang['memory_set_opt_module'];?></th>
		<th class="w84"><?php echo $lang['memory_set_opt_ifopen'];?></th>
		<th class="w84"><?php echo $lang['memory_set_opt_ttl'];?></th>
		<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td>商品搜索结果</td>
			<td><?php echo C('memory.search_p.open')? 'YES':'NO';?></td>
			<td><?php echo C('memory.search_p.ttl');?></td>
			<td class="vatop tips">0表示永不过期，只缓存按商品分类、规格、属性搜索出来的数据</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>店铺搜索结果</td>
			<td><?php echo C('memory.search_s.open')? 'YES':'NO';?></td>
			<td><?php echo C('memory.search_s.ttl');?></td>
			<td class="vatop tips">0表示永不过期，只缓存按商品分类、规格、属性搜索出来的数据</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>用户数据</td>
			<td><?php echo C('memory.member.open')? 'YES':'NO';?></td>
			<td><?php echo C('memory.member.ttl');?></td>
			<td class="vatop tips">0表示永不过期，缓存用户常用数据（站内信数量）</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>商品数据</td>
			<td><?php echo C('memory.product.open')? 'YES':'NO';?></td>
			<td><?php echo C('memory.product.ttl');?></td>
			<td class="vatop tips">0表示永不过期，缓存商品基本统计数据（浏览量、售出量）</td>
			<td></td>
		</tr>
	</tbody>
	</table>-->
</div>
