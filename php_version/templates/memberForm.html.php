<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <script>
        <?php
        if(isset($row)){
            echo 'var check = true';
            $bool = false;
        }
        else{
            echo 'var check = false';
            $bool = true;
        }
        ?>

        function checkInput(myform) {
            if(check == false){
                alert("아이디 중복체크를 해주세요.");
                myform.id_check.focus();
                return false;
            }
            if(myform.id_name.value.length <= 0){
                alert("이름을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_id.value.length <= 0){
                alert("아이디를 입력하세요.");
                myform.id_id.focus();
                return false;
            }
            if(myform.id_pw.value.length <= 0){
                alert("비밀번호를 입력하세요.");
                myform.id_pw.focus();
                return false;
            }
            if(myform.id_pw_check.value.length <= 0){
                alert("비밀번호 확인을 입력하세요.");
                myform.id_pw_check.focus();
                return false;
            }
            if(myform.id_pw.value != myform.id_pw_check.value){
                alert("비밀번호와 비밀번화 확인과 다릅니다.");
                myform.id_pw.focus();
                return false;
            }
            if(myform.id_zip.value.length <= 0){
                alert("주소를 입력하세요.");
                myform.id_zip.focus();
                return false;
            }
            document.getElementById("id_id").readOnly = true;
            return true;
        }

        function checkid() {
            check = false;
            var userid = document.getElementById("id_id").value;

            if(userid)
            {
                url = "/member/idCheck?userid="+userid;
                window.open(url,"chkid","width=400,height=200");
            } else {
                alert("아이디를 입력하세요.");
            }
        }

        function checkReset() {
            check = false;
            document.getElementById("id_id").readOnly = false;
        }

        function decide() {
            check = true;
            document.getElementById("id_id").readOnly = true;
            document.getElementById("id_check").value = "아이디 변경"
            document.getElementById("id_check").setAttribute("onclick", "change()");
        }

        function change() {
            check = false;
            document.getElementById("id_id").readOnly = false;
            document.getElementById("id_check").value = "아이디 중복"
            document.getElementById("id_check").setAttribute("onclick", "checkid()")
        }
    </script>
</head>
<body>
    <?php
        if($bool){
            echo '<header><h1> '.$title.'</h1></header>';
        }
    ?>
    <form action="/member/addupdate" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <fieldset id = form_fieldset>
            <ul><label for = "mem_name">이름</label>
                <input type= "text" name="mem_name" id="id_name" value="<?php if(isset($row)){echo $row['mem_name'];}?>"><br>
                <label for = "mem_id">아이디</label>
                <input type= "text" name="mem_id" id="id_id" value="<?php if(isset($row)){echo $row['mem_id'];}?>">
                <input type= "button" name="id_check" id="id_check" value="아이디 중복" onclick="checkid();"><br>
                <label for = "mem_pw">비밀번호</label>
                <input type= "password" name="mem_pw" id="id_pw" value="<?php if(isset($row)){echo $row['mem_pw'];}?>"><br>
                <label for = "mem_pw_check">비밀번호 확인</label>
                <input type= "password" name="mem_pw_check" id="id_pw_check" value="<?php if(isset($row)){echo $row['mem_pw'];}?>"><br>
                <label for = "mem_zip">우편번호</label>
                <input type= "text" name="mem_zip" id="id_zip" value="<?php if(isset($row)){echo $row['mem_zip'];}?>" readonly>
                <input type= "button" onclick="daumPostcode()" value="우편번호 찾기"><br>
                <label for = "mem_add">주소</label>
                <input type= "text" name="mem_add" id="id_add" value="<?php if(isset($row)){echo $row['mem_add'];}?>" readonly><br>
                <label for = "mem_detail">상세주소</label>
                <input type= "text" name="mem_detail" id="id_detail" value="<?php if(isset($row)){echo $row['mem_detail'];}?>"><br>
                <input type="hidden" name="mem_no" value="<?php if(isset($row)){echo $row['mem_no'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value='지우기'>
                <?php
                if($bool){
                    echo "<a href='/'><input type='button' value='홈'></a>";
                }
                ?>
            </div>
        </fieldset>
    </form>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        if(check){
            decide();
        }
        else{
            change();
        }

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