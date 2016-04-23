// JavaScript Document

//幻灯

var _bannerList=$('#banner_list .banner_box'),
	_status=$('#status span'),
	_listLength=_bannerList.length-1,
	_gbTime=1,
	_time=null,
	_noclick=false;
	
	/*Loading Delay*/
	function loadDelay(){
		_time=setInterval('fnTime()',5000);	
		_bannerList.eq(0).removeClass('on_delay');
	}
	var n = new Image();
	n.onload = function(){
		loadDelay();
	}
	n.src = "images/bg1_1.png";
	
	/*Click Event*/
		_status.bind('click',function(){
			var _index=$(this).index();
			if($(this).hasClass('on')||_noclick==true){
				return false;
			}else{
				clearInterval(_time);
				fnFocusAct(_index);			
			}
		})
	
/*Focus Image Play*/
function fnFocusAct(actNum){
		clearInterval(_time);
		_noclick=true;
		var _toHide=$('#banner_list').find('.on'),
			_statusAct=_status.eq(actNum),
			_toAct=_bannerList.eq(actNum);
		
		_statusAct.siblings().removeClass('on');
		_statusAct.addClass('on');
		
		_toAct.addClass('on2');
		_toHide.fadeTo(600,0,function(){
			_toHide.removeClass('on');
			_toAct.removeClass('on2');
			_toAct.siblings().css('opacity','1');
			_toAct.addClass('on');
			_noclick=false;
		})
		_gbTime=actNum;
		if(_gbTime==_listLength){
			_gbTime=0;
		}else{
			_gbTime++;	
		}
		_time=setInterval('fnTime()',5000)
}

function fnTime(){
	fnFocusAct(_gbTime);		
}

		








