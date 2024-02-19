<!DOCTYPE html>
<html>
<head>
    <?php
    $state = 2;

    if(isset($_SESSION['mem_state'])) {
        $state = $_SESSION['mem_state'];
    }

    if($state != 1){
        if(isset($row['lib_close'])){
            $close = '없음';
            switch ($row['lib_close']) {
                case 0:
                    $close = '일요일';
                    break;
                case 1:
                    $close = '월요일';
                    break;
                case 2:
                    $close = '화요일';
                    break;
                case 3:
                    $close = '수요일';
                    break;
                case 4:
                    $close = '목요일';
                    break;  
                case 5:
                    $close = '금요일';
                    break;
                case 6:
                    $close = '월요일';
                    break;
                default:
                    $close = '연중무휴';
                    break;
            }
        }
    
        if(isset($row['lib_add'])){
            $zip = $row['lib_zip'];
            $address = "[$zip] ".$row['lib_add'];
    
            if($row['lib_detail'] != 'null'){
                $address = $address.' '.$row['lib_detail'];
            }
        }
    }
    ?>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        //필수 입력 내용 확인하는 함수
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("이름을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_date.value.length <= 0){
                alert("설립일을 입력하세요.");
                myform.id_date.focus();
                return false;
            }
            if(myform.id_zip.value.length <= 0){
                alert("주소를 입력하세요.");
                myform.id_zip.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<?php if($state == 1){?>
    <form action="/lib/addupdate" method="post" onSubmit="return checkInput(this)">
        <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
        <fieldset>아래 내용을 <?= $title2 ?>하세요.</fieldset>
            <ul>
                <li><label for  = "id_name">이름</label>
                    <input class="input" type= "text" name="lib_name" id="id_name" value="<?php if(isset($row)){echo $row['lib_name'];}?>"></li>
                <li><label for  = "id_date">설립일</label>
                    <input type = "date" name="lib_date" id="id_date" value="<?php if(isset($row)){echo $row['lib_date'];}?>"></li>
                <li><label for  = "id_detail">주소</label>
                    <input class="input" type= "text" name="lib_zip" id="id_zip" value="<?php if(isset($row)){echo $row['lib_zip'];}else if(isset($zip)){echo $zip;}?>" placeholder="우편번호" readonly>
                    <input type = "button" onclick="daumPostcode()" value="우편번호 찾기"></li>
                <li><label></label>
                    <input class="input" type= "text" name="lib_add" id="id_add" value="<?php if(isset($row)){echo $row['lib_add'];}else if(isset($add)){echo $add;}?>" placeholder="주소" readonly></li>
                <li><label></label>
                    <input class="input" type= "text" name="lib_detail" id="id_detail" value="<?php if(isset($row)){echo $row['lib_detail'];}?>" placeholder="상세주소"></li>
                <li><label>정기휴관일</label>
                    <input type="radio" name="lib_close" id="id_sun" value="0"> 일요일
                    <input type="radio" name="lib_close" id="id_mon" value="1"> 월요일
                    <input type="radio" name="lib_close" id="id_tue" value="2"> 화요일
                    <input type="radio" name="lib_close" id="id_wed" value="3"> 수요일
                    <input type="radio" name="lib_close" id="id_thu" value="4"> 목요일
                    <input type="radio" name="lib_close" id="id_fri" value="5"> 금요일
                    <input type="radio" name="lib_close" id="id_sat" value="6"> 토요일
                    <input type="radio" name="lib_close" id="id_null" value="7"> 없음</li>
                <li><label>약도</label>
                    <input class="input" type= "text" name="lib_url" id="id_url" value="<?php if(isset($row)){echo $row['lib_url'];}?>"></li>
                <?php if(isset($row)){ if($row['lib_url'] != ''){?>
                <iframe src="<?php echo $row['lib_url']; ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <?php }}?>
            </ul>
            <input type="hidden" name="lib_no" value="<?php if(isset($row)){echo $row['lib_no'];}?>">
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        function daumPostcode() {
            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if(data.userSelectedType === 'R'){
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if(data.buildingName !== '' && data.apartment === 'Y'){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if(extraAddr !== ''){
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        // 조합된 참고항목을 해당 필드에 넣는다.
                        document.getElementById("id_detail").value = extraAddr;
                    
                    } else {
                        document.getElementById("id_detail").value = '';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('id_zip').value = data.zonecode;
                    document.getElementById("id_add").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("id_detail").focus();
                }
            }).open();
        }

        const sun = document.querySelector('#id_sun');
        const mon = document.querySelector('#id_mon');
        const tue = document.querySelector('#id_tue');
        const wed = document.querySelector('#id_wed');
        const thu = document.querySelector('#id_thu');
        const fri = document.querySelector('#id_fri');
        const sat = document.querySelector('#id_sat');
        const noting = document.querySelector('#id_null');
        
    <?php
    $lib_close = 7;
    
    if(isset($row['lib_close'])){ 
        $lib_close = $row['lib_close'];
    }

    if($lib_close == 0){
        echo "sun.checked = true;";
    }
    else if($lib_close == 1){
        echo "mon.checked = true;";
    }
    else if($lib_close == 2){
        echo "tue.checked = true;";
    }
    else if($lib_close == 3){
        echo "wed.checked = true;";
    }
    else if($lib_close == 4){
        echo "thu.checked = true;";
    }
    else if($lib_close == 5){
        echo "fri.checked = true;";
    }
    else if($lib_close == 6){
        echo "sat.checked = true;";
    }
    else{
        echo "noting.checked = true;";
    }
    ?>

    </script>
<?php }else{ ?>
    <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
        <fieldset><?php if(isset($row)){echo $row['lib_name'];}?></fieldset>
            <ul>
                <li><label for  = "id_date">설립일</label>
                    <?=htmlspecialchars($row['lib_date'],ENT_QUOTES,'UTF-8');?></li>
                <li><label for  = "id_detail">주소</label>
                    <?=htmlspecialchars($address);?></li></li>
                <li><label>정기휴관일</label>
                    <?=htmlspecialchars($close);?></li></li>
                <li><label>약도</label>
                <?php if(isset($row)){ if($row['lib_url'] != ''){?>
                </li>
                <li>
                    <iframe src="<?php echo $row['lib_url']; ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </li>
                <?php }}else{ ?>
                약도가 존재하지 않습니다.</li>
                <?php }?>
            </ul>
        <div class="form_class">
            <input type= "button" value="이전" onclick="javascript:history.back()">
        </div>
    </fieldset>
<?php } ?>
</body>
</html>