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

<div class="pad_10">
<form action="?m=activity&c=exhibition&a=edit&id=<?php echo $id;?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="100">论坛标题：</th>
		<td><input type="text" name="info[title]" id="title" size="30" class="input-text" value="<?php echo $title;?>"></td>
	</tr>
	
	<tr>
		<th width="100">论坛banner：</th>
		<td><?php echo form::images('info[banner]', 'banner', $banner, 'activity')?></td>
	</tr>

	<tr>
		<th width="100">论坛介绍：</th>
		<td>
			<textarea name="info[description]" id="description"><?php echo $description?></textarea>
			<?php echo form::ueditor('description')?>
		</td>
	</tr>
	
	<tr>
		<th width="100">赞助与合作：</th>
		<td><?php echo form::images('info[cooperation]', 'cooperation', $cooperation, 'activity')?></td>
	</tr>
	
	<tr>
		<th width="100">合作方案：</th>
		<td><?php echo form::upfiles('info[cooperation_plan]', 'cooperation_plan', $cooperation_plan, 'activity', '', '', '', '', 'pdf', 'doc', 'docx')?></td>
	</tr>

	<tr>
		<th></th>
		<td>
			<input type="hidden" name="forward" value="?m=activity&c=exhibition&a=edit"> 
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
		</td>
	</tr>

</table>
</form>
</div>
</body>
</html> 