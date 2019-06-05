<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
	<div class="table-list">
		<div class="common-form">
			<fieldset>
				<legend>详细信息</legend>
				<table width="100%" class="table_form">
					<tr>
						<td width="120">单位名称</td> 
						<td><?php echo $info['unit_name'];?></td>
					</tr>
					<tr>
						<td width="120">姓名</td> 
						<td><?php echo $info['fullname'];?></td>
					</tr>
					<tr>
						<td width="120">电话</td> 
						<td><?php echo $info['phone'];?></td>
					</tr>
					<tr>
						<td width="120">邮箱</td> 
						<td><?php echo $info['email'];?></td>
					</tr>
					<tr>
						<td width="120">地址</td> 
						<td><?php echo $info['address'];?></td>
					</tr>
					<tr>
						<td width="120">职务</td> 
						<td><?php echo $info['zhiwu'];?></td>
					</tr>
					<tr>
						<td width="120">其他信息</td> 
						<td><?php echo $info['remarks'];?></td>
					</tr>
				</table>
			</fieldset>
			<div class="bk15"></div>

		</div>
		<div class="bk15"></div>
		<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'details'}).close();"/>
	</div>
</div>
</body>
</html>