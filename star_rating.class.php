<?php
    /**
     * @class star_rating
     * @author 1sam.kr (csh@korea.com)
     * @brief 회원 별점
     **/

    class star_rating extends WidgetHandler {
        /**
         * @brief 위젯의 실행 부분
         *
         * ./widgets/위젯/conf/info.xml 에 선언한 extra_vars를 args로 받는다
         * 결과를 만든후 print가 아니라 return 해주어야 한다
         **/
        
		/* 기본 위젯 코드 생성시의 값
		 <img class="zbxe_widget_output" widget="star_rating" skin="default" colorset="white" widget_sequence="59174" widget_cache="5" markup_type="table" star_max="10" display_zero="true" able_anonymous="true" with_group="1" without_group="1" />
		 // $args는 이 클래스 내의 전역 변수임
		 // $args->skin
		 // $args->colorset
		 // $args->widget_sequence
		 // $args->widget_cache
		 */
		 
		// 위젯 표현의 1차 실행 함수
		function proc($args) {
			$current_module_info = Context::get('current_module_info');
			// 별점 설정 모듈에서 불러온 설정값
			$oModuleModel = getModel('module');
			$star_rating_config = $oModuleModel->getModulePartConfig('star_rating_config',$current_module_info->module_srl);
			//설정값 재설정
			$args->available = $star_rating_config['star_available_'.$this->module_skin_style];
			//별점 사용 여부
			if($args->available == 'N') return;




			// 테스트 코드
			//file_put_contents('somefile.txt', print_r($current_module_info, true));

			/*x// 모듈 비교
			if (array_search($current_module_info, explode(',',$args->module_srls))) {
				return;
			}*/
							
			//$this->document_srl = Context::get('document_srl');
			//$oDocumentModel = getModel('document');
			//if(!$this->document_srl) $oDocument = $oDocumentModel->getDocument(0);
			
			//$args는 view_document일때, 본문 아래에 리스트가 같이 출력되면 아래 리스트의 $args값을 가져와 버리는 버그가 발생함. 따라서 위젯 코드 생성할 때 필히 document_srl="{$document->document_srl}"|cond="$document_srl!=$document->document_srl" 변수를 상황에 맞추어야 함. 리스트일 경우에만 사용해야함.
			
			// 해당 별위젯의 각 글번호 구하기
			/*if($args->document_srl) { 
				$widget_info->document_srl = $args->document_srl;
			} elseif($this->document_srl) {
				$widget_info->document_srl = $this->document_srl;
			} else {
				return;
			}*/
			/*$widget_info->document_srl = $args->document_srl | Context::get('document_srl');
			if(!$widget_info->document_srl) return;*/

			$document_srl = Context::get('document_srl');
			$is_overlaped = Context::get('is_overlaped');
			if($document_srl && !$is_overlaped) { //본문보기의 별과 리스트에 해당 글 **중복상태임
				// 중복회피을 위해 중복 확인용 전역변수 추가
				Context::set('is_overlaped', $document_srl);
				$this->module_skin_style = 'view';
				$widget_info->document_srl = $document_srl;
			
			} else { // 리스트로 나타나는 별
				$this->module_skin_style = $this->module_info->star_skin_.$current_module_info->default_style;
				$widget_info->document_srl = $args->document_srl;
				
				// 중복 회피를 위한 해결책입니다. 1과 2중에서 선택하세요.
				// 1. 리스트에 해당글보기의 문서가 표시되지 않음
				//if($is_overlaped == $widget_info->document_srl) return;
				// 2. 투표 UI 표시만 하지 않도록 함
				$args->able_rate = ($is_overlaped == $widget_info->document_srl) ? 'N' :$star_rating_config['star_able_rate_'.$this->module_skin_style];
				
				
			}
			
			if(!$widget_info->document_srl) return;


			// 오류가 생기면 그냥 무시, 문서번호값이 없다는 뜻임
			// 게시판 리스트에서는 문서값을 위젯코드에 있는 document_srl 변수로 받아 오고
			// $args->document_srl 에 저장함
            //if($this->document_srl && $args->document_srl) continue;


			/*$columnList = array('module_srl', 'mid', 'browser_title','module','skin');
			$mid_list = $oModuleModel->getMidList(null, $columnList);
			Context::set('mid_list', $mid_list);*/



			//Context::set('star_rating_config', $star_rating_config);
			
			// 게시판 보기 상태 구분 view, gallery, webzine, blog 등등
			
			//$listStyle=Context::get('listStyle');

			/*// 전역변수 선언
			// document_srl 을 'is_overlaped' 전역변수로 중복여부를 확인
			if(Context::get('is_overlaped')) {
				if($overlaped == $widget_info->document_srl) {
					$this->module_skin_style = 'view';
					//$widget_info->ccc = '중복';//$this->module_info->star_skin_.$current_module_info->default_style;//$ccc;
				} //else {
					//$widget_info->ccc = '중복아님';
				//}
			} else {
				Context::set('is_overlaped', $widget_info->document_srl);
				//$ccc= "전역변수값 없음";
				$widget_info->ccc = '처음';
			}*/

			/*if(!$args->document_srl){// && $listStyle) {
				// 전역변수 선언
				// document_srl 을 'is_overlaped' 전역변수로 중복여부를 확인
				if(Context::get('is_overlaped')) {
					//if($overlaped == $widget_info->document_srl) {
						$this->module_skin_style = $this->module_info->star_skin_.$current_module_info->default_style;
					//}
				} else {
					Context::set('is_overlaped', $widget_info->document_srl);
					$this->module_skin_style = 'view';
				}

			} else {
				$this->module_skin_style = $this->module_info->star_skin_.$current_module_info->default_style;
			}*/



			
			$args->skin = $star_rating_config['star_skin_'.$this->module_skin_style];
			$args->star_max = $star_rating_config['star_max_'.$this->module_skin_style];
			$args->full_point = $star_rating_config['star_full_point_'.$this->module_skin_style];
			// 중복회피용으로 위에서 정의함
			//$args->able_rate = $star_rating_config['star_able_rate_'.$this->module_skin_style];
			$args->display_rated_list = $star_rating_config['star_display_rated_list_'.$this->module_skin_style];
			$args->display_rated_info = $star_rating_config['star_display_rated_info_'.$this->module_skin_style];
			$args->decimal_point = $star_rating_config['star_decimal_point_'.$this->module_skin_style];
			$args->display_zero = $star_rating_config['star_display_zero_'.$this->module_skin_style];
			$args->able_anonymous = $star_rating_config['star_able_anonymous_'.$this->module_skin_style];
			$args->update_order = $star_rating_config['star_last_update_'.$this->module_skin_style];
			


			// 유저 로그인 정보
			// 별점을 준 사람을 걸러냄
			$oMemberModel = getModel('member');

   	        $member_srl = Context::get('member_srl');
       	    if(!$member_srl && Context::get('is_logged')) {
           	    $logged_info = Context::get('logged_info');
               	$member_srl = $logged_info->member_srl;
            }

			if(!$member_srl) {
				if($args->able_anonymous) { //비로그인 사용 가능
					// 익명의 사용자에게 음수값의 member_srl을 제공
					$member_srl=-hexdec(substr(md5($_SERVER['REMOTE_ADDR']),0,4));
				} else {
        	        $member_srl = 0; //비로그인 첫 사용자만 가능
        		}
			}
			$args->member_srl = $member_srl;
			$widget_info->member_srl = $member_srl;


			// 별 한 개 표시
			// $args 는 설정 값, 위젯 코드 생성할 때의 변수로 다양한 값이 들어 옴
			// $mid_list = explode(",",$args->mid_list); 여러개가 콤마로 연속된 변수값
			// $widget_info 는 위젯 스킨에 넘겨줄 데이터

			$widget_info->star_max = $args->star_max; //표현될 별의 개수

			if($widget_info->star_max == 1) {
				$average = $this->getStarRatedAverage($widget_info->document_srl);
				
				$widget_info->star_rating_list = $this->getStarRatedList(1,$widget_info->document_srl); //별 1개 - 참여자 표시 위함

				// 평점이 0일때, 0점별의 표시 여부 확인
				if($average < 1 && $args->display_zero != "Y") return;

				$widget_info->average = number_format($average,$args->decimal_point);//round($average, $args->decimal_point); //일쌤 number_format
				
				//투표여부
				$widget_info->is_starrated = $this->getStarRatedIs($args,$widget_info->document_srl);

			} else { // 2개 이상의 별
				// 평균점수 구하기
				// db->documents->rateval 에 저장되어 있음
				// 해당 글의 별점 리스트 호출
				$widget_info->star_rating_list = $this->getStarRatedList(1,$widget_info->document_srl); //1점이상으로 매겨진 글의 점수 
				
				$average = $this->getStarRatedAverage($widget_info->document_srl);
				$widget_info->rateaverage = number_format($average, $args->decimal_point);//round($average, $args->decimal_point);
				$widget_info->percent_average = number_format($average * $args->star_max / 10, $args->decimal_point);//round($average * $args->star_max / 10,$args->decimal_point);
		
				// 10개의 별, 5개의 별을 계산해서 넘김
				
				// 표시될 별의 개수에 맞는 만점 숫자 표시 선택해아함, full_point는 만점 표시 수치
				// 스킨에서 직접 처리하도록 했음
				// $html_codes =  $this->getStarsHtml_code($widget_info->rateaverage, $args->star_max, count($star_rating_point), $widget_info->document_srl, $args->full_point);
				//$widget_info->starshtml_code1 = $html_codes[0]; //평점 별
				//$widget_info->starshtml_code2 = $html_codes[1]; //채점자 리스트

	            /**********
				// star.js 에서 url: './widgets/star_rating/tpl/removerating.php'으로 대체하였음
				// 템플릿 컴파일
				$conflen= 0;//strlen('star_rating');
				// 설치된 위치 구하기
				$B=substr(__FILE__,0,strrpos(__FILE__,'/'));
				$A=substr($_SERVER['DOCUMENT_ROOT'], strrpos($_SERVER['DOCUMENT_ROOT'], $_SERVER['PHP_SELF']));
				$C=substr($B,strlen($A));
				$posconf=strlen($C)-1;
				$D=substr($C,1,$posconf);
				//http https 절대 주소를 찾기 위함
				if($_SERVER['HTTPS'] == "on") {
					$host='https://'.$_SERVER['SERVER_NAME'].'/'.$D;
				} else {
				$host='http://'.$_SERVER['SERVER_NAME'].'/'.$D;
				}
			
				$widget_info->installed_folder = $host; //star.js 에 넘겨주고 addrating.php와 removerating.php의 절대 위치를 지정해줌
				**********/
				
				if($args->full_point != '10') { // 10점 만점의 평균점수 표시, 별8개 표시의 만점은 10점
					$args->full_point = $args->star_max;
				}

				/****				
				//위젯 스킨의 star.php에서 별 표시 함수를 로드합니다.
				require_once $_SERVER['DOCUMENT_ROOT'].'/widgets/star_rating/skins/'.$args->skin.'/star.php';

				//보안상 문제가 될 수 있으나 가변함수를 사용함
				
				$func_name = 'get_star_html_code_'.$args->skin;
				$func_name2 = 'get_star_extra_html_code_'.$args->skin;
				
				// 평균점수를 표현하는 별 코드 구하기; 별표최대표시 개수와 평균점수 대입
				//$widget_info->star_html_code = get_star_html_code($args->star_max, $widget_info->rateaverage);
				$widget_info->star_html_code = $func_name($args->star_max, $widget_info->rateaverage);
				
				// 별이외의 부가 정보 코드 구하기
				//$widget_info->star_extra_html_code = get_star_extra_html_code($args->star_max, $widget_info->rateaverage, count($widget_info->star_rating_list), $document_srl, $args->full_point);
				$widget_info->star_extra_html_code = $func_name2($args->star_max, $widget_info->rateaverage, count($widget_info->star_rating_list), $document_srl, $args->full_point);
				*****/
				
				$widget_info->full_point = $args->full_point; //만점 숫자 표시
				$widget_info->able_rate = $args->able_rate; //별점 UI 표시
				$widget_info->display_rated_list = $args->display_rated_list; //별점 참여자 리스트 표시
				$widget_info->display_rated_info = $args->display_rated_info; //별점 평균과 참여자 수 표시
				
				
				$widget_info->widget_skin = $args->skin;
				$widget_info->update_order = $args->update_order;
				$widget_info->module_srls = explode(',',$args->module_srls);
				//투표여부
				$widget_info->is_starrated = $this->getStarRatedIs($args,$widget_info->document_srl); //NULL 또는 1
			}

            // $widget_info 저장
			Context::set('widget_info', $widget_info);

            // 템플릿의 스킨 경로를 지정 (skin, colorset에 따른 값을 설정)
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
            Context::set('colorset', $args->colorset);//기본은 layout, white, black

			// 템플릿 파일을 지정
   	        $tpl_file = 'star';
       	    // 템플릿 컴파일
           	$oTemplate = &TemplateHandler::getInstance();
           	$output = $oTemplate->compile($tpl_path, $tpl_file);


			$skinx = Context::get('skin');

			return $output;
		}

	
		/**
		* @brief 추천/비추천인 리스트를 구함
		**/
		function getStarRatedList($rateval,$document_srl) {

			//if(!$this->document_srl) return;
			//if($this->isSecret() && !$this->isGranted()) return
			$args->document_srl = $document_srl;
			
			//!!! 0점으로 평점이 데이터 베이스에 복사된 것을 위해 임시로 0점도 출력하게 하였슴.
		    $args->rateval = 0;//$rateval; //1점이상인 사람만 가져옴 
			$output = executeQueryArray('widgets.star_rating.getStarRatedList', $args);
			//return new Object(0, print_r($output));
			return $output->data;
		}

		 /**
		 * @brief member_srl에 해당하는 nick_name을 구함
		 **/
		function getNickNameByMemberSrl($member_srl) {
			$args->member_srl = $member_srl;
		    $output = executeQuery('widgets.star_rating.getNickName', $args);
		    return $output->data->nick_name;
		 }


		// document_srl 로 평균값 구하기
		function getStarRatedAverage($document_srl) {
		    $args->document_srl = $document_srl;
		    $output = executeQuery('widgets.star_rating.getStarRatedAverage', $args);
			/*// 평균점수 기록을 초기화 했을 때 사용하세요.
			$oStar_rating_configControll =  getController('star_rating_config');
			
			$average =$oStar_rating_configControll->get_star_average($document_srl);
			$oStar_rating_configControll->update_star_average($document_srl, $average);*/

			return $output->data->rate_average ? $output->data->rate_average : 0;//$output->data['rate_average'];
		 }

		// 별점을 주었는지를 bool로 리턴
		function getStarRatedIs($args, $document_srl) {
		    $args->document_srl = $document_srl;
		    $output = executeQuery('widgets.star_rating.getStarRatedIs', $args);
			//$args->member_srl = $member_srl;
			if($args->member_srl == $output->data->member_srl) {
			   return true;
			} else {
			   return false;
			}
		}


		/*
		// 무의미함; 죽은 함수임
		// 평균값으로 별모양 개수 출력 코드 생성
		function getStarsHtml_code($staraverage, $star_max, $rated_count, $document_srl, $full_point) {
			$html_codes = array();
			
			$html_code = NULL;
			//백분률 평균점수
			$star_average = $staraverage * $star_max /10; // 별표시개수에 따른 백분률 평점, 별8개 표시의 만점은 8점

			if($full_point != '10') { // 10점 만점의 평균점수 표시, 별8개 표시의 만점은 10점
				//만점은 백분률
				//별개수는 백분률
				$staraverage = $star_average;
				$full_point = $star_max;
			}
			
			//별의 게이지가 차는 것은 백분률 평균점수인 $star_average 사용
			for($i=1;$i<=$star_max;$i++) {
		      	if($star_average>=1)	{
					$html_code .= '<svg class="star-icon-10 star-icon-10-result" viewBox="0 0 40 40"><use xlink:href="#icon-star-full" filter="url(#drop-shadow)"></use></svg>';
		            $star_average=$star_average-1;
	    	    } else if($star_average>=0.5) {
					$html_code .= '<svg class="star-icon-10 star-icon-10-result" viewBox="0 0 40 40"><use xlink:href="#icon-star-half-o" filter="url(#drop-shadow)"></use></svg>';
					$star_average=$star_average-1;
	        	} else if ($star_average<0.5 && $star_average>0) {
	    	        $html_code .= "<i class='fa fa-star-o'></i>";
    	    	    $star_average=$star_average-1;
		        } else if($star_average<=0) {
		            $html_code .= '<svg class="star-icon-10 star-icon-10-result" viewBox="0 0 40 40"><use xlink:href="#icon-star-o" filter="url(#drop-shadow)"></use></svg>';
		        }
			}
			
			// 별게이지와 보조 정보를 구분하여 배열로 리턴함
			$html_codes[0] = $html_code;
			

			if ($rated_count > 0){
				// 평균값과 참여자 수 정보
				$html_code .= '<strong><span class="btn-primary btn-xs">
				<svg class="star-icon-10-users" viewBox="0 0 40 40"><use xlink:href="#icon-users" filter="url(#drop-shadow)"></use></svg>
				<span class="s_average" id="s_average_'.$document_srl.'"><i>'.$staraverage.' / '.$full_point.'</i></span></span></strong><span class="s_persons" id="s_persons_'.$document_srl.'">'.$rated_count.'</span>명 참여';
			} else {
				//첫 투표자
				$html_code .= '<strong><span class="btn-primary btn-xs">
				<svg class="star-icon-10-user" viewBox="0 0 40 40"><use xlink:href="#icon-user-o" filter="url(#drop-shadow)"></use></svg>
				<span class="s_average" id="s_average_'.$document_srl.'"></span></span></strong><span class="s_persons" id="s_persons_'.$document_srl.'">'.$rated_count.'</span>명 참여';
			}
			
			$html_codes[1] = $html_code;

			// 배열로 리턴하도록 수정
			//htmlspecialchars($html_code); 어레이 출력때만 사용해야함 실제표시는 안됨
			return $html_codes;
		}
		*/
		
    }
