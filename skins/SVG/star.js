jQuery(document).ready(function(){
	// 위젯 최상위 부모 div에 적용된 overflow: hidden 속성 제거
	// [ 별 1개 스킨 ] ribonicon 등 과의 조화를 위해 display: inline-block 추가
	//jQuery( ".star-rate" ).parent( "div" ).parent( "div" ).parent( "div" ).css({overflow: "", display: "inline-block", verticalAlign: "super"});
	// [ 별 10개 스킨 ]
	//jQuery( "#outline" ).parent( "div" ).parent( "div" ).css({overflow: ""});
	
	// 툴팁
	//jQuery("div.rated_users span").tooltip();
	jQuery('[data-toggle="tooltip"]').tooltip();
	// 셀렉터를 rating i, a, img 태그로 하였으며 추가 가능함
	jQuery('.rating use,.rating i,.rating a,.rating img').hover(function(){
		var uid = this.id;
		var uids = uid.split("_");

		jQuery('#rateit_'+uids[1]).css({visibility: "hidden"});
		for(var x=1;x<=uids[0];x++){jQuery('#'+x+'_'+uids[1]).css('fill', '#FFD600');}

		switch(uids[0]){
			case '1':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "red"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 1 > 내 시간...');
			//jQuery('#rateit_'+uids[1]+' #s_p1').css({visibility: "visible"});
			break;
			case '2':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "red"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 2 > 이게 뭐야...');
			break;
			case '3':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "#b8860b"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 3 > 감독의 의도는?');
			break;
			case '4':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "#b8860b",});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 4 > 1회용...');
			break;
			case '5':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "green"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 5 > 그냥 그렇군');
			break;
			case '6':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "green"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 6 > 그럭저럭');
			break;
			case '7':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "blue"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 7 > 볼만하네');
			break;
			case '8':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "orange"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 8 > 괜찮네');
			break;
			case '9':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "#f88"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 9 > 잘 만들었군');
			break;
			case '10':
			jQuery('#rateit_'+uids[1]).css({visibility: "visible", color: "#9B70F0"});
			jQuery('#rateit_'+uids[1]).html('&nbsp;< 10 > 또 봐야지!');
		}
	}),

	jQuery('.rating use,.rating i,.rating a,.rating img').mouseout(function() {
		var uid = this.id;
		var uids = uid.split("_");
		jQuery('#rateit_'+uids[1]).css({visibility: "hidden"});
		for(var x=1;x<=uids[0];x++){jQuery('#'+x+'_'+uids[1]).css('fill', 'gray');}
	})
});

// 별점 부과
function callback_add_SVG(result){

	var user = 'rate_' + result['member_srl'];
  		//user2 변수를 제대로 인식되도록 수정 해야함
	var user2 = 'onclick=\"removestar(\"' + user + '\") ';
	user2 ='';

	// 링크값 수정해야함
	// 평점 준 사람 목록을 출력함
	var adder = '<a ' + 'id=\"' + user + '\" class=\"label label-success\" ' + 'href=\"#\" ' + user2 + '> 내 별점 <i class="fa fa-star"></i><i>' + result['val'] + '</i></a>';

	if(result['message'] == "success"){

				var star_html_code = get_star_html_SVG(result['star_max'],result['converted_average'],result['document_srl']);
		//alert(star_html_code);
		jQuery("#final_"+result['document_srl']).html(star_html_code);
		jQuery(adder).appendTo("#rated_users_"+result['document_srl']); // 평점 준사람 출력
				jQuery("#ment_"+result['document_srl']).html('<svg class="star-icon-10" viewBox="0 0 40 40"><use xlink:href="#icon-user-full" filter="url(#drop-shadow)"></use></svg> :');
		jQuery("#s_average_"+result['document_srl']).html(result['average']); //부가 점수
		jQuery("#s_persons_"+result['document_srl']).html(result['persons']);
				jQuery('#res').css({opacity: 0.0, visibility: "visible"});

				var already = ("감사합니다.");

 				jQuery("#second_s_"+result['document_srl']).fadeOut(99);
				jQuery("#already_"+result['document_srl']).css({visibility: "visible"});
				jQuery("#already_"+result['document_srl']).fadeIn(100);
				jQuery("#already_"+result['document_srl']).html(already);
				jQuery("#already_"+result['document_srl']).fadeOut(8000);
				
	}else if(result['message'] == 'already'){
				var already = ("이미 별점을 주셨습니다.");
		
				jQuery('#res').css({opacity: 0.0, visibility: "visible"});
		jQuery("#already_"+result['document_srl']).css({visibility: "visible"});
		jQuery("#already_"+result['document_srl']).fadeIn(100);
		jQuery("#already_"+result['document_srl']).html(already);
		jQuery("#already_"+result['document_srl']).fadeOut(5000);
	}else {
		alert("오류");
	}
} // 코드 버그 ; 표 없앰
	
// 별점 삭제
function callback_remove_SVG(result){
	var user_div = 'rate_'+ result['member_srl']+'_'+result['document_srl'];//반영될 div의 아디값
	//var star_max = document.getElementById('star_max').value;
	//var full_point = document.getElementById('full_point').value
	//var widget_skin = document.getElementById('widget_skin').value

	if(result['message'] == 'success'){
				//별코드
		var star_html_code = get_star_html_SVG(result['star_max'], result['converted_average'],result['document_srl']);

		jQuery("#final_"+result['document_srl']).html(star_html_code);

				jQuery("#ment_"+result['document_srl']).html('<svg class="star-icon-10" viewBox="0 0 40 40"><use xlink:href="#icon-star-checked-full" filter="url(#drop-shadow)"></use></svg> :');

		jQuery("#s_average_"+result['document_srl']).html(result['average']); //부가정보
		jQuery("#s_persons_"+result['document_srl']).html(result['persons']);
				var already = ("별점을 삭제 했습니다.");
				//jQuery("#"+user_div).html('');
				jQuery("#"+user_div).css({display: "none"});
		jQuery("#second_s_"+result['document_srl']).fadeOut(99);
				jQuery("#already_"+document_srl).css({visibility: "visible"});
		jQuery("#already_"+result['document_srl']).fadeIn(100);
		jQuery("#already_"+result['document_srl']).html(already);
		jQuery("#already_"+result['document_srl']).fadeOut(8000);

	}else if(result['message'] == 'already'){
				var already = ("이미 별점을 주셨습니다.");

		jQuery("#already_"+result['document_srl']).css({visibility: "visible"});
		jQuery("#already_"+result['document_srl']).fadeIn(100);
		jQuery("#already_"+result['document_srl']).html(already);
		jQuery("#already_"+result['document_srl']).fadeOut(5000);
	}
}


// 별의 게이지가 차는 것은 백분률 평균점수인 $converted_average 사용
// 코드를 수정할 때는 $html_code += 의 뒷부분만 변경하세요.
// 이미지일 경우 루트경로 필수!! "./widgets/star_rating/skins/스킨폴더/images/sample.png"
function get_star_html_SVG(star_max, star_percent_average, document_srl){
	// star_max = 10;
	var html_code ='<div class="final" id="final_'+document_srl+'">';
	for(i=1;i<=star_max;i++) {
	   	if(star_percent_average>=1)	{
			//꽉 찬 별
			html_code += '<svg class="star-icon-10 star-icon-10-result" viewBox="0 0 40 40"><use xlink:href="#icon-star-full" filter="url(#drop-shadow)"></use></svg>';
	        star_percent_average-=1;
        } else if(star_percent_average>=0.5) {
			//반쪽 별
			html_code += '<svg class="star-icon-10 star-icon-10-result" viewBox="0 0 40 40"><use xlink:href="#icon-star-half-o" filter="url(#drop-shadow)"></use></svg>';
			star_percent_average-=1;
       	} else if (star_percent_average<0.5 && star_percent_average>0) {
			//빈 별
            html_code += '<i class="fa fa-star-o"></i>';
   	   	    star_percent_average-=1;
	    } else if(star_percent_average<=0) {
			//빈 별
	        html_code += '<svg class="star-icon-10 star-icon-10-result" viewBox="0 0 40 40"><use xlink:href="#icon-star-o" filter="url(#drop-shadow)"></use></svg>';
		}
	}
	html_code +='<div>';
	return html_code;
}
