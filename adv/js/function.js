/*
	通过类名方式获取元素
	getClass(类名,获取范围)
	参数1 classnmae  类名
	参数2 obj  默认值 document
*/
/*
	$("#box")
	$(".box") $('.box',context)
	$("div")

	$(function(){})


	$("<div>")
*/

function $(selector,context){
	if(typeof selector=="string"){
		context=context||document;
		if(selector.charAt(0)=="#"){
			return document.getElementById(selector.substr(1));
		}else if(selector.charAt(0)=="."){
			return getClass(selector.substring(1),context);
		}else if(/^[a-zA-Z][A-Za-z1-6]*$/.test(selector)){
			return context.getElementsByTagName(selector);
		}else if(/^<[a-zA-Z][A-Za-z1-6]{0,10}>$/.test(selector)){
			//"<div>"
			return document.createElement(selector.slice(1,-1));
		}
	}
	if(typeof selector=="function"){
		window.onload=function(){
			selector();
		}
	}
}

function getClass(classname,obj){
	obj=obj||document;
	if(document.getElementsByClassName!=undefined){
		return obj.getElementsByClassName(classname);
	}else{
		var arr=[];
		var all=obj.getElementsByTagName('*');
		for(var i=0;i<all.length;i++){
			//check(all[i].classname,classname)
			if(check(all[i].className,classname)){
				arr.push(all[i])
			}
		}
		return arr;
	}
}
function check(oldclass,newclass){
	//old  "box list one"
	//new   "list"
	var arr=oldclass.split(" ");
	for(var i=0;i<arr.length;i++){
		if(arr[i]==newclass){
			return true;
		}
	}
	return false;
}
/*
	text(obj,val)
	text(box)
	text(box,"你好")
*/
function text(obj,val){
	if(val==undefined){
		if(obj.innerText){
			return obj.innerText;
		}else{
			return obj.textContent;
		}
	}else{
		if(obj.innerText){
			obj.innerText=val;
		}else{
			obj.textContent=val;
		}
	}
}

/*
	获取行内样式 和外部样式
	getStyle(obj,attr)
*/
function getStyle(obj,attr){
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,null)[attr];
	}
}

/*

	type :   a       需要文本
	         b默认   不需要文本  获取所有标签

	childs[i].nodeType==1  获取标签

	childs[i].nodeType==3&&trim(childs[i].nodeValue,'a')!=""    获取文本

childs[i].nodeType==1 || (childs[i].nodeType==3&&trim(childs[i].nodeValue,'a')!="" )

*/

function getParent(obj){
	return obj.parentNode;
}


//获取子节点
function getChilds(obj,type){
	type=type||'b';
	var childs=obj.childNodes;
	var newarr=[];
	if(type=='b'){
		for(var i =0;i<childs.length;i++){
			if(childs[i].nodeType==1){
				newarr.push(childs[i]);
			}
		}
	}
	if(type=='a'){
		for(var i =0;i<childs.length;i++){
			if(childs[i].nodeType==1||(childs[i].nodeType==3&&trim(childs[i].nodeValue)!="")){
				newarr.push(childs[i]);
			}
		}
	}
	return newarr;
}

function getFirst(parent,type){
	return getChilds(parent,type)[0]
}
function getNum(parent,index,type){
	return getChilds(parent,type)[index]
}
function getLast(parent,type){
	var all=getChilds(parent,type);
	return all[all.length-1];
}

//获取兄弟节点
function getNext(obj){
	var next=obj.nextSibling;
	if(next==null){
		return false;
	}
	while(next.nodeType==8||(next.nodeType==3&&trim(next.nodeValue)=="")){
		next=next.nextSibling;
		if(next==null){
			return false;
		}
	}
	return next;
}
function getUp(obj){
	var up=obj.previousSibling;
	if(up==null){
		return false;
	}
	while(up.nodeType==8||(up.nodeType==3&&trim(up.nodeValue)=="")){//
		up=up.previousSibling;
		if(up==null){
			return false;
		}
	}
	return up;
}


/*
	去除字符串的空格
	type ：参数   a  l  r  lr默认


	string.trim()  IE6-8
*/
function trim(str,type){
	type=type||'lr';
	if(type=='a'){//all
		return str.replace(/\s*/g,"");
	}
	if(type=='l'){//left
		return str.replace(/^\s*/g,"");
	}
	if(type=='r'){//right
		return str.replace(/\s*$/g,"");
	}
	if(type=='lr'){//leftright
		return str.replace(/^\s*|\s*$/g,"");
	}
}


/*

	obj 要插入的对象
	afterObj 之后的对象
*/
function insertAfter(obj,afterObj){
	var next=getNext(afterObj);
	if(next==false){
		afterObj.parentNode.appendChild(obj);
	}else{
		afterObj.parentNode.insertBefore(obj,next);
	}
}