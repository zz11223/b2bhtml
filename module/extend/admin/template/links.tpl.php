<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');

show_menu($menus);
?>

<div class="sbox" >
<form action="?" >
	<div class="btns"> 
		<input type="button" value="添加" class="btn-g" id="links_add" /> 
		 <select name="" id="companys" >
 	

 		</select>
		<span id="links_add_span"></span>
	</div>
	 
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php echo $fields_select;?>&nbsp;
<input type="text" size="20" name="kw" value="<?php echo $kw;?>" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;
<span data-hide="1200"><?php echo $level_select;?>&nbsp;</span>
  
<span data-hide="1200"><?php echo $order_select;?>&nbsp;</span>
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/>
</form>
</div>
 
<table cellspacing="0" class="tb ls">
<tr>
 <th>所属公司</th>  
 <th>公司链接</th>
<th>关键词</th> 
<th>关键词链接</th>

<th width="180">操作</th>
</tr>
<tbody id="tbody">
<?php foreach($lists as $k=>$v) {?>
<tr class="links_tr" align="center" title="编辑:<?php echo $v['aname'];?>&#10;添加时间:<?php echo $v['adddate'];?>&#10;更新时间:<?php echo $v['editdate'];?> ">
	<input type="hidden" class="itemid" value="<?php echo $v['itemid'];?>">
	<input type="hidden" class="id" value="<?php echo $v['id'];?>">
 <td class="username">
 	<span ><?php echo $v['username'];?></span>
 
 </td>
 <td  class="comurl">
	<a  href="<?php echo DT_PATH;?>api/redirect.php?url=<?php echo urlencode($v['comurl']);?>" target="_blank"><?php echo $v['comurl'];?></a>
  
 </td>
 <td class="title">
 	<span class="info1"><?php echo $v['title'];?></span>
<input class="info2" style="display:none;" type="text" value="<?php echo $v['title'];?>">
 </td>
<td  class="linkurl">
	<a class="info1" href="<?php echo DT_PATH;?>api/redirect.php?url=<?php echo urlencode($v['linkurl']);?>" target="_blank"><?php echo $v['linkurl'];?></a>
 <input class="info2" style="display:none;" type="text" value="<?php echo $v['linkurl'];?>">
 </td>
<td>
<img class="links_edit" src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/>
&nbsp;&nbsp;&nbsp;
 
 <input type="button" value="保存" class="btn-g links_save"  /> 
</td>
</tr>
<?php }?>
</tbody>
</table>
 
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>
 
<script>
var url=location.href; 
  
$.ajax({
	url: url,
	type:'post', 
	data:{'actionget':'actionget'},
	dataType:'json',
	error:function(data){
		alert('错误，刷新页面');
		location.reload(true);
	},
	success:function(data){
		 
		var options='';
 		for(var i in data){
 			options+='<option value="'+data[i]['id']+'">'+data[i]['username']+'-'+data[i]['comurl']+'</option>';
 		}
 		 
 		$('#companys').html(options);
	}
});

$('#links_add').click(function(){
	 
	$('#tbody').prepend($('.links_tr').eq(0).clone(true)); 
	var $tr=$('.links_tr').eq(0);
	$tr.find('.info1').hide();
	$tr.find('.info2').show();
	$tr.find('.itemid').val(0);
	var txt=$.trim($('#companys option:selected').eq(0).text());
	var id=$('#companys').val(); 
	 
	var arrs=txt.split('-');
	var comurl=arrs[1];
	var username=arrs[0]; 
	$tr.find('.itemid').val(0);
	$tr.find('.id').val(id);
	$tr.find('.username span').text(username);
	$tr.find('.comurl a').text(comurl); 
	$tr.find('.comurl a').attr('href',comurl); 
	$tr.find('.title input').val('');
	$tr.find('.linkurl input').text('');
	
});
$('.links_edit').click(function(){
	var $tr=$(this).parent().parent();
	$tr.find('.info1').hide();
	$tr.find('.info2').show();
	 
});
$('.links_save').click(function(){
	 

	var $tr=$(this).parent().parent(); 
	var title=$.trim($tr.find('.title input').val());
	var linkurl=$.trim($tr.find('.linkurl input').val());
	var itemid=parseInt($tr.find('.itemid').val());
	var company=parseInt($tr.find('.id').val());
	var json_data;
	if(itemid>0){
		json_data={'actionp':'add','title':title,'linkurl':linkurl,'itemid':itemid};
	}else{
		json_data={'actionp':'add','title':title,'linkurl':linkurl,'company':company};
	}
	 
	 $.ajax({
		url: url,
		type:'post', 
		data:json_data,
		dataType:'json',
		error:function(data){
			alert('错误，刷新页面');
			location.reload(true);
		},
		success:function(data){

			console.log(data);
			if(data.code>0){
				 
	 			$tr.find('.title span').text(title);
				$tr.find('.linkurl a').text(linkurl);
				$tr.find('.linkurl a').attr('href',linkurl);
				if(itemid==0){
					$tr.find('.itemid').val(data.code);
				}
	  
				$tr.find('.info2').hide();
			    $tr.find('.info1').show();
			}else{
				$('#links_add_span').text(data.msg);
			}
		}
	});
});
  
</script>