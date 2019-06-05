<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
$layui = true;
include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
	.pictd {position: relative;}
	.bodyimg {position: absolute; display: none; top:-100px;  right: -200px; z-index: 2}
</style>
<script type="text/javascript">
	$(function(){
		$('.headimg').hover(function(){
			$(this).next().show();
		}, function(){
			$(this).next().hide();
		})
	})
</script>
<div class="pad-10">

	<div id="searchid">
		<form name="searchform" action="" method="get" >
			<input type="hidden" value="report" name="m">
			<input type="hidden" value="report" name="c">
			<input type="hidden" value="orderlist" name="a">
			<input type="hidden" value="1" name="search">
			<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">

			<table width="100%" cellspacing="0" class="search-form">
			    <tbody>
					<tr>
						<td>
							<div class="explain-col">
								<select name="searchtype">
									<option value="">请选择</option>
									<option value="fullname" <?php if($searchtype == 'fullname') echo 'selected'; ?>>姓名</option>
									<option value="contact" <?php if($searchtype == 'contact') echo 'selected'; ?>>联系方式</option>
									<option value="report_name" <?php if($searchtype == 'report_name') echo 'selected'; ?>>报告名称</option>
								</select>
								<input name="keyword" type="text" value="<?php echo $keyword; ?>" class="input-text">
								<input type="submit" name="search" class="button" value="搜索">
								
							</div>
						</td>
					</tr>
			    </tbody>
			</table>
		</form>
	</div>

	<form name="myform" id="myform" action="?m=recruit&c=job&a=listorder" method="post" >
	<div class="table-list">
	<table width="100%" cellspacing="0">
		<thead>
			<tr>
				<th width="3%" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
				<th width="3%">ID</th>
				<th width="10%" align="center">报告名称</th>
				<th width="5%" align="center">姓名</th>
				<th width="5%" align="center">单位名称</th>
				<th width="5%" align="center">联系方式</th>
				<th width="5%" align="center">机器码</th>
				<th width="5%" align="center">支付方式</th>
				<th width="5%" align="center">支付时间</th>
				<th width="5%" align="center">发货状态</th>
				<th width="5%" align="center">发货时间</th>
				<th width="5%" align="center">操作</th>
			</tr>
		</thead>
	<tbody>

	<?php
		if(is_array($list)){
			foreach($list as $info){
	?>
		<tr>
			<td align="center" width="3%"><input type="checkbox" name="id[]" value="<?php echo $info['id']?>"></td>
			<td align="center" width="3%"><?php echo $info['id'];?></td>
			<td align="center" width="10%">
				<?php echo $info['title']?> <br>
			</td>
			<td align="center" width="5%"> <?php echo $info['fullname']?></td>
			<td align="center" width="5%"> <?php echo $info['company']?> </td>
			<td align="center" width="5%"><?php echo $info['contact'];?></td>
			<td align="center" width="5%" class="pictd"><?php echo $info['machine_code'];?></td>
			<td align="center" width="5%"><?php echo $info['pay_method'] == 1 ? '支付宝' : '微信';?></td>
			<td align="center" width="5%"><?php if($info['pay_time']) echo date('Y-m-d H:i:s', $info['pay_time']);?></td>
			<td align="center" width="5%">
				<input type="hidden" name="id" value="<?php echo $info['id'];?>">
				<select name="shipping_status">
					
					<option value="0" <?php if($info['shipping_status'] == 0) echo 'selected'; ?>>未发货</option>
					<option value="1" <?php if($info['shipping_status'] == 1) echo 'selected'; ?>>已发货</option>
				</select>
			</td>
			<td align="center" width="5%"><?php if($info['shipping_time']) echo date('Y-m-d H:i:s', $info['shipping_time']);?></td>
			
			<td align="center" width="5%">
				<a href="###" onclick="detail(<?php echo $info['id']?>)">查看</a>
				<!-- <a href="###" onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['job_name']))?>')">修改</a>  -->
				
				
			</td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
	</table>
	</div>
	<div class="btn">
		<!-- <input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=recruit&c=enroll&a=delete'" value="<?php echo L('delete')?>"/> -->
		<!-- <input type="button" class="button" name="dosubmit" onclick="check()" value="批量审核"/> -->
	</div>
	<div id="pages"><?php echo $pages?></div>
	</form>
</div>
<script type="text/javascript">



	function detail(id){
		window.top.art.dialog({
				id:'add',
				iframe:'?m=report&c=report&a=orderDetail&id='+id,
				title:'详情',
				width:'700',
				height:'550'
			}, function(){
				window.top.art.dialog({id:'detail'}).close()
			}, function(){
				window.top.art.dialog({id:'detail'}).close()
			}
		);
	}

	function edit(id, name) {
		window.top.art.dialog({id:'edit'}).close();
		window.top.art.dialog(
			{
				title:'<?php echo L('edit')?> '+name+' ',
				id:'edit',
				iframe:'?m=recruit&c=job&a=edit&id='+id,
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
<script type="text/javascript">
	$(function(){
		$('select[name=shipping_status]').change(function(){
			var id = $(this).parents('tr').find('input[name=id]').val();
			var shipping_status = $(this).val();

			$.ajax({
				url: '?m=report&c=report&a=ajax_change_shipping_status&pc_hash=<?php echo input("pc_hash")?>&id='+id+'&shipping_status='+shipping_status,
				type: 'get',
				dateType: 'json',
				success: function(data){
					window.location.reload();
				}
			})
		})

	
			
	})
</script>

</body>
</html>
