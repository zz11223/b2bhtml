var flightHandler = function(data){ 
	 var body= document.body;             
	 var div = document.createElement("div");  
	 div.setAttribute("style", "clear:both;width:100%;text-align:center;margin:0 auto;padding:10px;");  
	 
	 var label = document.createElement("label");
	 label.setAttribute("style", "display:inline-block;padding:5px;");  
	 label.appendChild(document.createTextNode('友情链接：')); 
	 div.appendChild(label); 
	 var a;
	 for(var i in data){
		 label = document.createElement("label");
		 a=document.createElement("a");
		 label.setAttribute("style", "display:inline-block;padding:5px;");  
		 a.setAttribute("href", data[i]['linkurl']); 
		 a.setAttribute("target", '_blank'); 
		 a.appendChild(document.createTextNode(data[i]['title'])); 
		 label.appendChild(a); 
		 div.appendChild(label); 
     } 
	 body.appendChild(div); 
}; 
// 提供jsonp服务的url地址（不管是什么类型的地址，最终生成的返回值都是一段javascript代码） 
var title=document.title;
var url = encodeURI(window.location.href); 
var url = 'http://www.chengxin315.com/links?title='+title+'&url='+url;
// 创建script标签，设置其属性
var script = document.createElement('script');
script.setAttribute('src', url);
// 把script标签加入head，此时调用开始
document.getElementsByTagName('head')[0].appendChild(script);