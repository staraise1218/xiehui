<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
	<div class="content-menu ib-a blue line-x">
		<a class="add fb" href="javascript:;" onclick="javascript:window.top.art.dialog({id:'add',iframe:'?m=activity&c=agenda&a=add&activity_id=<?php echo $_GET["activity_id"];?>', title:'添加议程', width:'800', height:'450'}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);"><em>添加议程</em></a>
		<a href="javascript:;" class="on">活动议程</a>
	</div>
	<form name="myform" id="myform" action="?m=activity&c=agenda&a=listorder" method="post" >
	<div class="table-list">
	<table width="100%" cellspacing="0">
		<thead>
			<tr>
				<!-- <th width="5%">ID</th> -->
				<!-- <th width="5%" align="center">展会类型</th> -->
				<th width="20%" align="center">活动时间</th>
				<th width="12%" align="center">操作</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($infos)){
			foreach($infos as $info){
	?>
		<tr>
			<!-- <td align="center" width="5%"><?php echo $info['id'];?></td> -->
			<!-- <td align="center" width="5%"><?php echo $typename;?></td> -->
			<td align="center" width="20%"><?php echo $info['title'];?></td>

			<td align="center" width="12%">
				<a href="###" onclick="edit(<?php echo $info['id']?>, '活动议程')">修改</a>
				<span>|</span>
				<a href="###" onclick="del(<?php echo $info['id']?>)">删除</a>
			</td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
	</table>
	</div>

	<input type="hidden" name="activity_id" value="<?php echo $_GET["activity_id"];?>">
	</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog(
		{
			title:'<?php echo L('edit')?> '+name+' ',
			id:'edit',
			iframe:'?m=activity&c=agenda&a=edit&id='+id,
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

function del(id){
	if(id == '') return false;
	if(!confirm('确定删除吗')){
		return false;
	}
	var act = "?m=activity&c=agenda&a=delete&id="+id+"&activity_id=<?php echo $_GET['activity_id'];?>";

	myform.action=act;
	myform.submit();
}
</script>
</body>
</html>
