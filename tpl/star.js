function addstar(member_srl,document_srl,full_point,star_max,update_order,val, skin){
	/*exec_xml ( 모듈명, act명, arguments, callback_function, response_tags);*/
	var params = new Array();
	// document_srl 처럼 _(언더바)가 들어가면 오류남
	params['membersrl'] = member_srl;
	params['documentsrl'] = document_srl;
	params['fullpoint'] = full_point;
	params['starmax'] = star_max;
	params['updateorder'] = update_order;
	params['rating'] = val; //투표한 점수

	//params['updateorder'] = update_order;
	var response_tags = new Array('error','message','persons', 'average', 'html_code', 'converted_average', 'member_srl', 'document_srl', 'star_max','update_order','val');

	// 콜백 함수명을 가변화함, 여러가지 스킨이 섞여 표현될 때 함수명 중복으로 인한 충돌을 방지
	var call_back = 'callback_add_'+skin;

	// window[함수명] 함수명을 가변화 할 수 있는 해결책임
	exec_xml ('star_rating_config', 'star_rating_config_addstar', params, window[call_back], response_tags);
}


function removestar(member_srl,document_srl,full_point,star_max,update_order, skin){

	var params = new Array();

	params['membersrl'] = member_srl;
	params['documentsrl'] = document_srl;
	params['fullpoint'] = full_point;
	params['starmax'] = star_max;
	params['updateorder'] = update_order;

	//params['updateorder'] = update_order;
	var response_tags = new Array('error','message','persons','average','html_code','converted_average','member_srl','document_srl','star_max','update_order');

	var call_back = 'callback_remove_'+skin;

	// window[함수명] 함수명을 가변화 할 수 있는 해결책임
	exec_xml ('star_rating_config', 'star_rating_config_removestar', params, window[call_back], response_tags);
}
