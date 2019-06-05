<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>


<div class="pad-10">
	<div class="common-form">
		<form action="?m=admin&c=extend_setting&a=edit" method="post" name="myform" id="myform">
			<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
				

				<tr>
					<th width="100">会议报名费<br/>（会员价）：</th>
					<td>
						<input type="text" name="setting[meeting_price_member]" value="<?php echo $meeting_price_member;?>">
					</td>
				</tr>
				<tr>
					<th width="100">会议报名费<br/>（非会员价）：</th>
					<td>
						<input type="text" name="setting[meeting_price_nomember]" value="<?php echo $meeting_price_nomember;?>">
					</td>
				</tr>
				<tr>
					<th width="100">咨询电话：</th>
					<td>
						<input type="text" name="setting[kefu_phone]" value="<?php echo $kefu_phone;?>">
					</td>
				</tr>
				<tr>
					<th width="100">参展联系方式：</th>
					<td>
						<textarea name="setting[exhibition_contact]" id="exhibition_contact"><?php echo $exhibition_contact?></textarea>
						<?php echo form::editor('exhibition_contact', 'basic')?>
					</td>
				</tr>
				<tr>
					<th width="100">参会联系方式：</th>
					<td>
						<textarea name="setting[forum_contact]" id="forum_contact"><?php echo $forum_contact?></textarea>
						<?php echo form::editor('forum_contact','basic')?>
					</td>
				</tr>

				<tr>
					<th width="100">订阅联系方式：</th>
					<td>
						<textarea name="setting[subscribe_contact]" id="subscribe_contact"><?php echo $subscribe_contact?></textarea>
						<?php echo form::editor('subscribe_contact','basic')?>
					</td>
				</tr>

				<tr>
					<th width="100">用户注册协议：</th>
					<td>
						<textarea name="setting[register_xieyi]" id="register_xieyi"><?php echo $register_xieyi?></textarea>
						<?php echo form::ueditor('register_xieyi')?>
					</td>
				</tr>
				<tr>
					<td width="100">招聘页banner</td>
					<td><?php echo form::images('setting[recruit_banner]', 'recruit_banner', $recruit_banner, 'app');?></td>
				</tr>

			</table>
			<div class="bk15"></div>

			<input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="button">
		
		</form>
	</div>
</div>
</body>
</html> 