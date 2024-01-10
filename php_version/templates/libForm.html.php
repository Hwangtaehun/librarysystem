<!DOCTYPE html>
<html>
<head>
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
    </script>
</body>
</html>