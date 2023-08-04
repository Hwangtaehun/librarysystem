<!doctyoe html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <script>
        function checkInput(myform){
            if(myform.user_id.value.length <= 0){
                alert("아이디를 입력하세요.");
                myform.user_name.focus();
                return false;
            }
            if(myform.user_password.value.length <= 0){
                alert("비밀번호를 입력하세요.");
                myform.user_password.focus();
                return false;
            }
            if(myform.user_password.value == myform.user_pw_check.value){
                alert("비밀번호와 비밀번화 확인과 다릅니다.");
                myform.user_password.focus();
                return false;
            }
            if(myform.user_zipcode.value.length <= 0){
                alert("주소를 입력하세요.");
                myform.user_password.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <header>
        <h1> <?=$title?></h1>
    </header>
    <form action="member_check.php" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <label for = "user_id">아이디</label>
        <input type= "text" name="user_id" id="user_id" value=""><br>
        <label for = "user_password">비밀번호</label>
        <input type= "password" name="user_password" id="user_password"><br>
        <label for = "user_pw_check">비밀번호 확인</label>
        <input type= "password" name="user_pw_check" id="user_pw_check"><br>
        <label for = "user_zipcode">우편번호</label>
        <input type= "text" name="user_zipcode" id="user_zipcode">
        <input type= "button" onclick="daumPostcode()" value="우편번호 찾기"><br>
        <label for = "user_address">주소</label>
        <input type= "text" name="user_address" id="user_address"><br>
        <label for = "user_detail">상세주소</label>
        <input type= "text" name="user_detail" id="user_detail">
        <input type= "text" name="user_extra" id="user_extra" placeholder="참고항목"><br>
        <input type= submit value='회원가입'>
        <input type= reset value='지우기'>
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
                        document.getElementById("user_extra").value = extraAddr;
                    
                    } else {
                        document.getElementById("user_extra").value = '';
                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    document.getElementById('user_zipcode').value = data.zonecode;
                    document.getElementById("user_address").value = addr;
                    // 커서를 상세주소 필드로 이동한다.
                    document.getElementById("user_detail").focus();
                }
            }).open();
        }
    </script>
</body>
</html>