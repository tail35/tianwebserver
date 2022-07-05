$(function(){
	var imgBox=$(".img-box")[0];
	var one=getFirst(imgBox);
	var wheelBox=imgBox.parentNode;
	var iW=parseInt(getStyle(one,'width'));

	var index=0;
	var t=setInterval(wheel,2000);
	var flag=true;
	function wheel(){
		if(!flag){return;};
		flag=false;
		animate(imgBox,{marginLeft:-iW},300,function(){
			imgBox.appendChild(getFirst(imgBox));
			imgBox.style.marginLeft=0;
			flag=true;
		})
	}
	wheelBox.onmouseover=function(){
		clearInterval(t);
	}
	wheelBox.onmouseout=function(){
		t=setInterval(wheel,2000);
	}
	var rBtn=$('.right')[0];
	rBtn.onclick=function(){
		wheel();
	}
	var lBtn=$('.left')[0];

	lBtn.onclick=function(){
		if(!flag){
			return;
		}
		flag=false;
		imgBox.insertBefore(getLast(imgBox),getFirst(imgBox));
		imgBox.style.marginLeft=-iW+'px';
		animate(imgBox,{marginLeft:0},300,function(){
			flag=true;
		});
	}
})