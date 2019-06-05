<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
	<div class="content-menu ib-a blue line-x">
			<!-- <a href="javascript:" class="on">论坛管理</a> -->
	</div>
	<!-- <div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="activity" name="m">
			<input type="hidden" value="qikan" name="c">
			<input type="hidden" value="init" name="a">
			<input type="hidden" value="1" name="search">
			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
									
									<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
							</div>
						</td>
					</tr>
			    </tbody>
			</table>
		</form>
	</div> -->
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th width="5%" align="center">ID</th>
					<th width="5%" align="center">姓名</th>
					<th width="10%" align="center">电话</th>
					<th width="10%" align="center">邮箱</th>
					<th width="10%" align="center">职务</th>
					<th width="20%" align="center">单位名称</th>
					<th width="10%" align="center">订阅时间</th>
					<th width="10%" align="center">操作</th>
				</tr>
			</thead>
			<tbody>

				<?php
					if(is_array($infos)){
						foreach($infos as $k => $info){
				?>
				<tr>
					<td align="center" width="5%"><?php echo $info['id'];?></td>
					<td align="center" width="5%"><?php echo $info['fullname'];?></td>
					<td align="center" width="10%"><?php echo $info['phone'];?></td>
					<td align="center" width="10%"><?php echo $info['email'];?></td>
					<td align="center" width="10%"><?php echo $info['zhiwu'];?></td>
					<td align="center" width="20%"><?php echo $info['unit_name'];?></td>
					<td align="center" width="10%"><?php echo $info['inputtime'];?></td>

					<td align="center" width="10%">
						<a href="###" onclick="details(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['typename']))?>')">查看</a>

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
			iframe:'?m=activity&c=qikan&a=details&id='+id,
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
