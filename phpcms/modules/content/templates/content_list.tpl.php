<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div id="closeParentTime" style="display:none"></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}
//-->
</SCRIPT>
<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<a class="add fb" href="javascript:;" onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=&catid=<?php echo $catid;?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>','')><em><?php echo L('add_content');?></em></a>　

<?php echo $workflow_menu;?> <a href="javascript:;" onclick="javascript:$('#searchid').css('display','');"><em><?php echo L('search');?></em></a> 
<?php if($category['ishtml']) {?>
<span>|</span><a href="?m=content&c=create_html&a=category&pagesize=30&dosubmit=1&modelid=0&catids[0]=<?php echo $catid;?>&pc_hash=<?php echo $pc_hash;?>&referer=<?php echo urlencode($_SERVER['QUERY_STRING']);?>"><em><?php echo L('update_htmls',array('catname'=>$category['catname']));?></em></a>
<?php }?>
</div>
<div id="searchid" style="display:<?php if(!isset($_GET['search'])) echo 'none';?>">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $catid;?>" name="catid">
<input type="hidden" value="<?php echo $steps;?>" name="steps">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 
				<?php echo L('addtime');?>：
				<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?>
				
				<select name="searchtype">
					<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>><?php echo L('title');?></option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="37"><?php echo L('listorder');?></th>
            <th width="40">ID</th>
			<th><?php echo L('title');?></th>
            <!-- <th width="40"><?php echo L('hits');?></th> -->
            <th width="70"><?php echo L('publish_user');?></th>
            <th width="118"><?php echo L('updatetime');?></th>
			<th width="72"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = pc_base::load_model('hits_model');
		
		foreach ($datas as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$r['id']));
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
        <td align='center'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		<td align='center' ><?php echo $r['id'];?></td>
		<td>
		<?php
		if($status==99) {
			if($r['islink']) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} elseif(strpos($r['url'],'http://')!==false) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} else {
				echo '<a href="'.$release_siteurl.$r['url'].'" target="_blank">';
			}
		} else {
			echo '<a href="javascript:;" onclick=\'window.open("?m=content&c=content&a=public_preview&steps='.$steps.'&catid='.$catid.'&id='.$r['id'].'","manage")\'>';
		}?><span<?php echo title_style($r['style'])?>><?php echo $r['title'];?></span></a> <?php if($r['thumb']!='') {echo '<img src="'.IMG_PATH.'icon/small_img.gif" title="'.L('thumb').'">'; } if($r['posids']) {echo '<img src="'.IMG_PATH.'icon/small_elite.gif" title="'.L('elite').'">';} if($r['islink']) {echo ' <img src="'.IMG_PATH.'icon/link.png" title="'.L('islink_url').'">';}?></td>
		<!-- <td align='center' title="<?php echo L('today_hits');?>：<?php echo $hits_r['dayviews'];?>&#10;<?php echo L('yestoday_hits');?>：<?php echo $hits_r['yesterdayviews'];?>&#10;<?php echo L('week_hits');?>：<?php echo $hits_r['weekviews'];?>&#10;<?php echo L('month_hits');?>：<?php echo $hits_r['monthviews'];?>"><?php echo $hits_r['views'];?></td> -->
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."&pc_hash=".$_SESSION['pc_hash']."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center'><?php echo format::date($r['updatetime'],1);?></td>
		<td align='center'><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $catid;?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a></td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
    	<input type="button" class="button" value="<?php echo L('listorder');?>" onclick="myform.action='?m=content&c=content&a=listorder&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php if($category['content_ishtml']) {?>
		<input type="button" class="button" value="<?php echo L('createhtml');?>" onclick="myform.action='?m=content&c=create_html&a=batch_show&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }
		if($status!=99) {?>
		<input type="button" class="button" value="<?php echo L('passed_checked');?>" onclick="myform.action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }?>
		<input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?m=content&c=content&a=delete&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';return confirm_delete()"/>
		
		
	</div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
function push() {
	var str = 0;
	var id = tag = '';
	$("input[name='ids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		alert('<?php echo L('you_do_not_check');?>');
		return false;
	}
	window.top.art.dialog({id:'push'}).close();
	window.top.art.dialog({title:'<?php echo L('push');?>：',id:'push',iframe:'?m=content&c=push&action=position_list&catid=<?php echo $catid?>&modelid=<?php echo $modelid?>&id='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'push'}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'push'}).close()});
}
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'<?php echo L('view_comment');?>：'+name,id:'view_comment',iframe:'index.php?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function reject_check(type) {
	if(type==1) {
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') {
				str = 1;
			}
		});
		if(str==0) {
			alert('<?php echo L('you_do_not_check');?>');
			return false;
		}
		document.getElementById('myform').action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&reject=1';
		document.getElementById('myform').submit();
	} else {
		$('#reject_content').css('display','');
		return false;
	}	
}
setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}
setInterval("refersh_window()", 3000);
//-->
</script>
</body>
</html>