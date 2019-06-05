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
					<?php if($info['table_type'] == 'exhibition') { ?>
					<tr>
						<td width="120">单位地址</td> 
						<td><?php echo $info['unit_address'];?></td>
					</tr>
					<tr>
						<td width="120">会员等级</td> 
						<td><?php echo $info['member_lever'];?></td>
					</tr>
					<?php } ?>
					<tr>
						<td width="120">联系人</td> 
						<td><?php echo $info['contact_name'];?></td>
					</tr>
					<tr>
						<td width="120">联系电话</td> 
						<td><?php echo $info['contact_phone'];?></td>
					</tr>
					<?php if($info['table_type'] == 'forum') { ?>
					<tr>
						<td width="120">职位名称</td> 
						<td><?php echo $info['position'];?></td>
					</tr>
					<tr>
						<td width="120">邮箱</td> 
						<td><?php echo $info['email'];?></td>
					</tr>
					<tr>
						<td width="120">其他联系人</td>
						<td>
							<?php 
								if($info['other_contact']){
									foreach (unserialize($info['other_contact']) as $item)
									{
										echo "<table>
												<tr>
													<td>{$item['add_contact_name']}</td>
													<td>{$item['add_position']}</td>
													<td>{$item['add_contact_phone']}</td>
													<td>{$item['add_email']}</td>
												</tr>
										</table>";
									}
								}
							?>

						</td>
					</tr>
					<?php } ?>
					<?php if($info['table_type'] == 'exhibition') { ?>
					<tr>
						<td width="120">展位面积</td> 
						<td><?php echo $info['area'];?></td>
					</tr>
					<?php } ?>
					<?php if($info['table_type'] == 'forum') { ?>
					<tr>
						<td width="120">支付状态</td> 
						<td><?php echo $info['pay_status'] == 1 ? '已支付' : '未支付';?></td>
					</tr>
					<tr>
						<td width="120">支付时间</td> 
						<td><?php echo  $info['pay_time'] ? date('Y-m-d H:i:s', $info['pay_time']) : '无';?></td>
					</tr>
					<tr>
						<td width="120">支付方式</td> 
						<td><?php echo  $info['pay_method'] ? ($info['pay_method'] == 1 ? '支付宝' : '微信') : '无' ?></td>
					</tr>
					<tr>
						<td width="120">支付金额</td> 
						<td><?php echo  $info['pay_status'] == 1 ? $info['price'] : '0';?></td>
					</tr>
					<tr>
						<td width="120">是否会员</td> 
						<td><?php echo  $info['is_member'] ? '会员' : '非会员' ?></td>
					</tr>
					<?php } ?>
					<?php if($info['table_type'] == 'forum') { ?>
					<tr>
						<td width="120">备注</td> 
						<td><?php echo $info['remarks'];?></td>
					</tr>
					<?php } ?>
					<?php if($info['table_type'] == 'exhibition') { ?>
					<tr>
						<td width="120">其他说明</td> 
						<td><?php echo $info['remarks'];?></td>
					</tr>
					<?php } ?>
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