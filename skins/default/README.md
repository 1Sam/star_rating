<star.html>

스킨에 star.js 는 필수 요소입니다.
star.js의 get_star_html_code() 함수와 star.html의 코드는 모양이 잘 맞아야 합니다.

스킨의 디자인 요소를 알맞게 수정하세요.
id와 class 명은 유지하기 바라며, star_rating.css를 변경해 보세요.

글 열람시에 아래에 리스트로 나타나는 글목록의 경우,
마우스 오버로 점수를 부여하려할 때에 열람중인 글과 글목록의 별점부여(마우스오버)가 중복되기에
열람 중인 글에 마우스 오버효과가 적용됩니다.



<$widget_info 변수 참고>

stdClass Object ( [document_srl] => 53707 [member_srl] => 4 [star_max] => 5 [star_rating_list] => Array ( [0] => stdClass Object ( [member_srl] => 4 [rateval] => 9 ) ) [rateaverage] => 9 [percent_average] => 5 [full_point] => 5 [able_rate] => Y [display_rated_list] => N [display_rated_info] => N [widget_skin] => default [update_order] => Y [module_srls] => Array ( [0] => ) ) 


.widgets/star_rating/tpl/js/star.js 의 addstar() 함수와 관련입니다.
            addstar() 함수로 건네주는 마지막 변수의 "default" 문자는 현재 스킨의 폴더명입니다. 꼭 포함해야합니다."
            exec_xml() 함수의 call_back 함수인 addstar_default()를 가리킵니다.
            이러한 방식은 본문보기에서 하단의 리스트로 표시된 글이 섞인 상태에서, 별점 표현의 자바스크립트 함수가 뒤섞이지 않게 합니다.

&lt;i class="fa fa-star" onClick="addstar({$widget_info-&gt;member_srl},{$widget_info-&gt;document_srl},{$widget_info-&gt;full_point},{$widget_info-&gt;star_max},'{$widget_info-&gt;update_order}',{round(10/$widget_info-&gt;star_max*$i)}, '<span style="color: rgb(255, 255, 255); background-color: rgb(255, 0, 0);">default</span>')" id="{round(10/$widget_info-&gt;star_max*$i)}_{$widget_info-&gt;document_srl}"&gt;&lt;/i&gt;


<br/>
<br/>
<br/>

<h5>별점위젯을 게시판 스킨에 삽입하는 방법</h5>
&lt;div .... loop="$document_list=&gt;$no,$document"&gt;<br />&nbsp;&nbsp; &lt;별점위젯/&gt;<br />&lt;/div&gt;
 
