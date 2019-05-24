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
	 //baiduproto();
}; 
// 提供jsonp服务的url地址（不管是什么类型的地址，最终生成的返回值都是一段javascript代码） 
var title=document.title;
var url = encodeURI(window.location.href); 
//var url = 'http://chengxin31520190505.cc/links?title='+title+'&url='+url;
var url = 'http://www.chengxin315.com/links?title='+title+'&url='+url;
// 创建script标签，设置其属性
var script = document.createElement('script');
script.setAttribute('src', url);
// 把script标签加入head，此时调用开始
document.getElementsByTagName('head')[0].appendChild(script);

function baiduproto(){
	console.log('baiduproto23');
	var canonicalURL, curProtocol;
	//Get the <link> tag
	var x=document.getElementsByTagName("link");
	//Find the last canonical URL
	if(x.length > 0){
		for (i=0;i<x.length;i++){
			if(x[i].rel.toLowerCase() == 'canonical' && x[i].href){
				canonicalURL=x[i].href;
			}
		}
	}
	//Get protocol
    if (!canonicalURL){ 
    	curProtocol = window.location.protocol.split(':')[0]; 
    }else{ 
    	curProtocol = canonicalURL.split(':')[0]; 
    }
    //Get current URL if the canonical URL does not exist
    if (!canonicalURL) canonicalURL = window.location.href;
    //Assign script content. Replace current URL with the canonical URL
    //push.js,修改r=canonicalURL
	!function(){var e=/([http|https]:\/\/[a-zA-Z0-9\_\.]+\.baidu\.com)/gi,r=canonicalURL,o=document.referrer;if(!e.test(r)){var n="//api.share.baidu.com/s.gif";o?(n+="?r="+encodeURIComponent(document.referrer),r&&(n+="&l="+r)):r&&(n+="?l="+r);var t=new Image;t.src=n}}(window);
   
}