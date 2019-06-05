<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#name").formValidator({onshow:"<?php echo L("input").L('exhibition_name')?>",onfocus:"<?php echo L("input").L('exhibition_name')?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('exhibition_name')?>"});

	 
	})
//-->
</script>

<div class="pad-10">
	<div class="common-form">
		<form action="?m=activity&c=ferris&a=edit&activity_id=<?php echo $id;?>" method="post" name="myform" id="myform">
			<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
				
				<tr>
					<th width="100">banner：</th>
					<td><?php echo form::images('info[banner]', 'banner', $banner, 'activity')?></td>
				</tr>

				<tr>
					<th width="100">摩天奖介绍：</th>
					<td>
						<textarea name="info[description]" id="description"><?php echo $description?></textarea>
						<?php echo form::ueditor('description','full')?>
					</td>
				</tr>
				
				<tr>
					<th width="100">赞助与合作：</th>
					<td><?php echo form::images('info[cooperation]', 'cooperation', $cooperation, 'activity')?></td>
				</tr>
				
				<tr>
					<th width="100">合作方案：</th>
					<td><?php echo form::upfiles('info[cooperation_plan]', 'cooperation_plan', $cooperation_plan, 'activity', '', '', '', '', 'pdf|doc|docx')?></td>
				</tr>

			</table>
			<div class="bk15"></div>

			<input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="button">
		
		</form>
	</div>
</div>
</body>
</html> 