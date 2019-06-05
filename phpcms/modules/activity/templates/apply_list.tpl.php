<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
	<div class="content-menu ib-a blue line-x">
			<!-- <a href="javascript:" class="on">论坛管理</a> -->
	</div>
	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="activity" name="m">
			<input type="hidden" value="apply" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="1" name="search">
			<input type="hidden" name="table_type" value="<?php echo $table_type;?>">
			<!-- <input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash"> -->
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									<select name="local_type" id="">
										<option value="">全部</option>
										<option <?php if($search['local_type'] == 'bj'){echo 'selected=selected';}?> value="bj">北京<?php echo $table_name;?></option>
										<option <?php if($search['local_type'] == 'sh'){echo 'selected=selected';}?> value="sh">上海<?php echo $table_name;?></option>
									</select>
									<?php if($table_type == 'forum') { ?>
									<select name="pay_status" id="">
										<option value="-1">支付状态</option>
										<option <?php if($pay_status == '1'){echo 'selected=selected';}?> value="1">已支付</option>
										<option <?php if($pay_status == '0'){echo 'selected=selected';}?> value="0">未支付</option>
									</select>
									<?php } ?>
									<select name="searchtype">
										<option value="">搜索类型</option>
										<option value="contact_name" <?php if($searchtype == 'contact_name') echo 'selected'; ?>>联系人</option>
										<option value="contact_phone" <?php if($searchtype == 'contact_phone') echo 'selected'; ?>>联系方式</option>
										<option value="unit_name" <?php if($searchtype == 'unit_name') echo 'selected'; ?>>单位名称</option>
									</select>
									<input name="keyword" type="text" value="<?php echo $keyword; ?>" class="input-text">
									<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
							</div>
						</td>
					</tr>
			    </tbody>
			</table>
		</form>
	</div>
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th width="5%" align="center">ID</th>
					<th width="10%" align="center">单位名称</th>
					<th width="5%" align="center">联系人</th>
					<th width="5%" align="center">联系电话</th>
					<th width="5%" align="center">报名时间</th>
					<?php if($table_type == 'forum') { ?>
					<th width="5%" align="center">支付状态</th>
					<th width="5%" align="center">支付时间</th>
					<th width="5%" align="center">支付方式</th>
					<?php } ?>
					<th width="10%" align="center">操作</th>
				</tr>
			</thead>
			<tbody>

				<?php
					if(is_array($infos)){
						foreach($infos as $k => $info){
				?>
				<tr>
					<td align="center" width="5%"><?php echo $limit*($page-1) + $k+1;?></td>
					<td align="center" width="10%"><?php echo $info['unit_name'];?></td>
					<td align="center" width="5%"><?php echo $info['contact_name'];?></td>
					<td align="center" width="5%"><?php echo $info['contact_phone'];?></td>
					<td align="center" width="5%"><?php echo $info['inputtime'];?></td>
					<?php if($table_type == 'forum') { ?>
					<td align="center" width="5%"><?php echo $info['pay_status'] == 1 ? '已支付' : '未支付';?></td>
					<td align="center" width="5%"><?php echo  $info['pay_time'] ? date('Y-m-d H:i:s', $info['pay_time']) : '无';?></td>
					<td align="center" width="5%"><?php echo  $info['pay_method'] ? ($info['pay_method'] == 1 ? '支付宝' : '微信') : '无' ?></td>
					<?php } ?>
					<td align="center" width="12%">
						<a href="###" onclick="details(<?php echo $info['id']?>, '')">查看</a>
					</td>
				</tr>
				<?php }  } ?>
			</tbody>
		</table>
	</div>
	<div id="pages"><?php echo $pages?></div>
</div>

<script type="text/javascript">

function details(id, name) {
	window.top.art.dialog({id:'details'}).close();
	window.top.art.dialog(
		{
			title:'查看详情',
			id:'edit',
			iframe:'?m=activity&c=apply&a=details&id='+id,
			width:'800',
			height:'450'
		},
		function(){
			// var d = window.top.art.dialog({id:'edit'}).data.iframe;
			// var form = d.document.getElementById('dosubmit');
			// form.click();
			// return false;
			window.top.art.dialog({id:'edit'}).close()
		},
		function(){
			window.top.art.dialog({id:'edit'}).close()
		}
	);
}
</script>
</body>
</html>
