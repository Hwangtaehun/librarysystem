<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        function setCookie(key, value, expiredays) {
            let todayDate = new Date();
            todayDate.setDate(todayDate.getDate() + expiredays);
            document.cookie = key + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
        }

        function getCookie(key){
            key = new RegExp(key + '=([^;]*)');
            return key.test(document.cookie) ? unescape(RegExp.$1) : '';
        }

        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        function checklen() {
            url = "/etc/lenpop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function lenValue(no, mem, mat, date){
            setCookie('mem_id', mem, 1);
            setCookie('book_name', mat, 1);
            setCookie('len_date', date, 1);
            document.querySelector("#id_len").value = no;
            document.querySelector("#id_research").value = mem + ' ' + mat + ' ' + date;
        }
    </script>
</head>
<?php
include_once __DIR__.'/../includes/Assistance.php';
$assist = new Assistance();
$lib_array = $assist->libraryarray($pdo);
?>
<body>
    <form action="/etc/plaresearch" method="post" onsubmit="return checkResearch(this)">
        <input type="text" name="user_research" id="id_research" value = "" readonly>
        <input type="button" id="ie_research" value="대출찾기" onclick="checklen();"></a>
        <input type="hidden" id="id_len" name="len_no" value="">
        <input type="submit" value = "검색">
    </form>
    <div class="container text-center">
        <div class="row">
        <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 260px;">
                    <div class="card-body">
                        <p class="card-text">
                            <script>
                                var mem_id = getCookie('mem_id');
                                var book_name = getCookie('book_name');
                                var len_date = getCookie('len_date');
                                document.write("회원아이디: " + mem_id + "<br>");
                                document.write("책이름: " + book_name + "<br>");
                                document.write("대출일: " + len_date + "<br>");
                            </script>
                            대출 도서관: <?=htmlspecialchars($lib_array[$row['lib_no_len']],ENT_QUOTES,'UTF-8');?><br>
                            <?php $lib_no_re = $row['lib_no_re']; if($lib_no_re == ''){$lib_name = "없음";}else{$lib_name = $lib_array[$row['lib_no_re']];}?>
                            반납 도서관: <?=htmlspecialchars($lib_name,ENT_QUOTES,'UTF-8');?><br>
                        </p>
                        <form>
                            <a href="/etc/addupdate?pla_no=<?=$row['pla_no']?>"><input type="button" value="수정"></a>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; }else{ ?>
            <hr>
            검색을 통해서 필요한 대출 장소 내역을 출력해주세요.
            <hr>
        <?php } ?>
        </div>
    </div>
</body>