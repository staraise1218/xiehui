<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<div class="pad-lr-10">
	<div class="table-list">
		<div class="common-form">
			<fieldset>
				<legend>详细信息</legend>
				<table width="100%" class="table_form">
					<tr>
						<td width="120">姓名</td> 
						<td><?php echo $info['fullname'];?></td>
					</tr>
					<tr>
						<td width="120">单位名称</td> 
						<td><?php echo $info['company'];?></td>
					</tr>
					<tr>
						<td width="120">手机号</td> 
						<td><?php echo $info['contact'];?></td>
					</tr>
					<tr>
						<td width="120">机器码</td> 
						<td><?php echo $info['machine_code'];?></td>
					</tr>
					<tr>
						<td width="120">支付状态</td> 
						<td><?php echo  $info['pay_status'] ? '已支付' : '未支付'?></td>
					</tr>
					<tr>
						<td width="120">支付方式</td> 
						<td><?php echo  $info['pay_method'] ? ($info['pay_method'] == 1 ? '支付宝' : '微信') : '无' ?></td>
					</tr>
					<tr>
						<td width="120">支付时间</td> 
						<td><?php echo  $info['pay_time'] ? date('Y-m-d H:i:s', $info['pay_time']) : '无';?></td>
					</tr>
					<tr>
						<td width="120">发货状态</td> 
						<td><?php echo $info['shipping_status'] == 1 ? '已支付' : '未支付';?></td>
					</tr>
					<tr>
						<td width="120">发货时间</td> 
						<td><?php echo  $info['shipping_time'] ? date('Y-m-d H:i:s', $info['shipping_time']) : '无';?></td>
					</tr>
					<tr>
						<td width="120">开票信息</td> 
						<td><?php echo  $info['invoice_info'] ? ($info['invoice_info'] == 1 ? '支付宝' : '微信') : '无' ?></td>
					</tr>
					<tr>
						<td width="120">支付金额</td> 
						<td><?php echo  $info['pay_status'] == 1 ? $info['price'] : '0'; ?></td>
					</tr>
					<tr>
						<td width="120">是否会员</td> 
						<td><?php echo  $info['is_member'] ? '会员' : '非会员' ?></td>
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