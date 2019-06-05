<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	$("#title").formValidator({onshow:"<?php echo L("input").'议程时间'?>",onfocus:"<?php echo L("input").'议程时间'?>"}).inputValidator({min:1,onerror:"<?php echo L("input").'议程时间'?>"});

	})
//-->
</script>

<div class="pad_10">
<form action="?m=activity&c=agenda&a=edit&id=<?php echo $id;?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	
	<tr>
		<th>议程时间：</th>
		<td><input type="text" id="title" name="info[title]" size="30" value="<?php echo $title;?>"></td>
	</tr>
	<tr>
		<th width="100">议程图片：</th>
		<!-- <td><?php echo form::images('info[content]', 'content', $content, 'activity')?></td> -->
		<td><textarea name="info[content]" id="content"><?php echo $content;?></textarea><?php echo form::ueditor('content', 'full');?></td>
	</tr>

	<tr>
		<th></th>
		<td>
			<input type="hidden" name="forward" value="?m=activity&c=agenda&a=edit"> 
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交">
		</td>
	</tr>

</table>
</form>
</div>
</body>
</html> 