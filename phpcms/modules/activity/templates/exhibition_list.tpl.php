<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
	<div class="content-menu ib-a blue line-x">
			<a href="javascript:" class="on">展会管理</a>
	</div>
	<form name="myform" id="myform" action="?m=activity&c=exhibition&a=listorder" method="post" >
	<div class="table-list">
	<table width="100%" cellspacing="0">
		<thead>
			<tr>
				<th width="5%" align="center">展会类型</th>
				<th width="20%" align="center">展会标题</th>
				<th width="12%" align="center">操作</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($infos)){
			foreach($infos as $info){
	?>
		<tr>
			<td align="center" width="5%"><?php echo $info['typename'];?></td>
			<td align="center" width="20%"><?php echo $info['title'];?></td>

			<td align="center" width="12%">
				<a href="?m=activity&c=agenda&a=init&activity_id=<?php echo $info['id']?>&typename=<?php echo $info['typename'];?>">活动议程</a> | 
				<a href="###"
				onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['typename']))?>')">修改</a>

			</td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
	</table>
	</div>
	</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog(
		{
			title:'<?php echo L('edit')?> '+name+' ',
			id:'edit',
			iframe:'?m=activity&c=exhibition&a=edit&id='+id,
			width:'800',
			height:'450'
		},
		function(){
			var d = window.top.art.dialog({id:'edit'}).data.iframe;
			var form = d.document.getElementById('dosubmit');
			form.click();
			return false;
		},
		function(){
			window.top.art.dialog({id:'edit'}).close()
		}
	);
}
</script>
</body>
</html>
