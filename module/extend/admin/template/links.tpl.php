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
 <th >公司操作</th>
<th>关键词</th> 
<th>关键词链接</th>

<th >关键字操作</th>

</tr>
<tbody id="tbody">
<?php foreach($lists as $k=>$v) {?>
<tr class="links_tr" align="center" title="编辑:<?php echo $v['aname'];?>&#10;添加时间:<?php echo $v['adddate'];?>&#10;更新时间:<?php echo $v['editdate'];?> ">
	<input type="hidden" class="itemid" value="<?php echo $v['itemid'];?>">
	<input type="hidden" class="id" value="<?php echo $v['id'];?>">
 <td class="username">
 	<span class="com1"><?php echo $v['username'];?></span>
 <input class="com2" style="display:none;" type="text" value="<?php echo $v['username'];?>">
 </td>
 <td  class="comurl">
	<a  class="com1" href="<?php echo DT_PATH;?>api/redirect.php?url=<?php echo urlencode($v['comurl']);?>" target="_blank"><?php echo $v['comurl'];?></a>
   <input class="com2" style="display:none;" type="text" value="<?php echo $v['comurl'];?>">
 </td>
 <td  class="clickInfo">
 
							
 <input type="button" value="公司修改" class="btn-g com_edit"  /> 
&nbsp;&nbsp;&nbsp; 
 <input type="button" value="公司保存" class="btn-g com_save"  /> 
 &nbsp;&nbsp;&nbsp;  
 <input type="button" value="友链更新" class="btn-r com_uid"  /> 
  &nbsp;&nbsp;&nbsp; 

 <input type="button" value="查看友链" class="btn-g com_links1"  /> 
 
   &nbsp;&nbsp;&nbsp;  
 <input type="button" value="查看反链" class="btn-g com_links2"  /> 
 <div class="links1"></div>
  <div class="links2"></div>

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
 
 <input type="button" value="关键字修改" class="btn-g links_edit"  /> 
 
 <input type="button" value="关键字保存" class="btn-g links_save"  /> 
</td>
</tr>
 
 
<?php }?>
</tbody>
</table>
 
<?php echo $pages ? '<div class="pages">'.$pages.'</div>' : '';?>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>
 
<script>
var url_href=location.href; 
  console.log(url_href);
$.ajax({
	url: url_href,
	type:'post', 
	data:{'actionp':'get_companys'},
	dataType:'json',
	error:function(data){
		alert('错误，请刷新重试'); 
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
	$tr.find('.username input').val(username);
	$tr.find('.comurl a').text(comurl); 
	$tr.find('.comurl a').attr('href',comurl);
	$tr.find('.comurl input').val(comurl);   
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
		url: url_href,
		type:'post', 
		data:json_data,
		dataType:'json',
		error:function(data){
			alert('错误，请刷新重试'); 
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
$('.com_edit').click(function(){
	var $tr=$(this).parent().parent();
	$tr.find('.com1').hide();
	$tr.find('.com2').show();
	 
});
$('.com_save').click(function(){
	  
	var $tr=$(this).parent().parent(); 
	var username=$.trim($tr.find('.username input').val());
	var comurl=$.trim($tr.find('.comurl input').val()); 
	var id=parseInt($tr.find('.id').val());
	var json_data; 
	 location.href=url_href+'&filedo=company_save&id='+id+'&username='+username+'&comurl='+encodeURI(comurl); 
	 return 0; 
});
$('.com_uid').click(function(){
	  
	var $tr=$(this).parent().parent(); 
 
	var id=parseInt($tr.find('.id').val()); 
	 var url=location.href;
	 location.href=url+'&filedo=company_uid&id='+id; 
	 return 0; 
});

$('.com_links1').click(function(){
	var $tr=$(this).parent().parent();
	var id=parseInt($tr.find('.id').val()); 
	$.ajax({
		url: url_href,
		type:'post', 
		data:{'actionp':'get_links1','id':id},
		dataType:'json',
		error:function(data){
			alert('错误，请刷新重试'); 
		},
		success:function(data){
			 console.log(data);
			var labels='友链：';
	 		for(var i in data){
	 			 
	 			labels+='<label  style="display:inline-block;margin:0;padding:2px 10px;"><a href="'+data[i]['linkurl']+'" target="_blank">'+data[i]['username']+'-'+data[i]['title']+'</a></label>';
	 		 
	 		} 
	 		$tr.find('.links1').html(labels); 
		}
	});
});
$('.com_links2').click(function(){
	var $tr=$(this).parent().parent();
	var id=parseInt($tr.find('.id').val()); 
	$.ajax({
		url: url_href,
		type:'post', 
		data:{'actionp':'get_links2','id':id},
		dataType:'json',
		error:function(data){
			alert('错误，请刷新重试'); 
		},
		success:function(data){ 
			var labels='反链：';
	 		for(var i in data){
	 			labels+='<label  style="display:inline-block;margin:0;padding:2px 10px;"><a href="'+data[i]['comurl']+'" target="_blank">'+data[i]['username']+'</a></label>';
	 		} 
	 		$tr.find('.links2').html(labels); 
		}
	});
});
</script>