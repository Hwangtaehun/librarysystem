<head>
    <link rel="stylesheet" href="../css/form-base.css">
    <script>
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        function checkdue() {
            url = "/etc/mempop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function memValue(no, name, state){
            document.querySelector("#id_mem").value = no;
            document.querySelector("#id_research").value = name;
        }
    </script>
</head>
<?php
include_once __DIR__.'/../includes/Assistance.php';
$assist = new Assistance();
$lib_array = $assist->libraryarray($pdo);
?>
<body>
    <form action="/etc/dueresearch" method="post" onsubmit="return checkResearch(this)">
        <div class="search">
            <input type="button" id="ie_research" class="srbt" value="회원찾기" onclick="checkdue();">
            <input type="text" name="user_research" id="id_research" value = "" readonly>
            <input type="hidden" id="id_mem" name="mem_no" value="">
            <button type="submit" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
    </form>
    <div class="container text-center">
        <div class="row row-cols-3">
    <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 300px;">
                    <div class="card-body">
                    <?php
                    $kind = $row['kind_no'];
                    $symbol = $row['mat_symbol'];
                    $many = $row['mat_many'];
                    $overlap = $row['mat_overlap'];
                    $book = $kind.' '.$symbol.' '.$many.' '.$overlap;

                    if($row['len_re_date'] == ''){
                        $len_re_date = '없음';
                    }
                    else{
                        $len_re_date = $row['len_re_date'];
                    }
                    if($row['due_exp'] == ''){
                        $due_exp = '';
                    }
                    else{
                        $due_exp = $row['due_exp'];
                    }
                    ?>
                    <h5 class="card-title"><?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?></h5>
                    <p class="card-text">
                        책이름: <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?><br>
                        소장 도서관: <?=htmlspecialchars($lib_array[$row['lib_no']],ENT_QUOTES,'UTF-8');?><br>
                        책번호: <?=htmlspecialchars($book,ENT_QUOTES,'UTF-8');?><br>
                        대출일: <?=htmlspecialchars($row['len_date'],ENT_QUOTES,'UTF-8');?><br>
                        반납일: <?=htmlspecialchars($len_re_date,ENT_QUOTES,'UTF-8');?><br>
                        해제일: <?=htmlspecialchars($due_exp,ENT_QUOTES,'UTF-8');?><br>
                    </p>
                    <?php if($row['due_exp'] != ''){ ?>
                        <form action="/etc/delete" method="post">
                            <input type="hidden" name="due_no" value="<?=$row['due_no']?>">
                            <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                            <input type="submit" value="삭제">
                            <a href="/etc/addupdate?due_no=<?=$row['due_no']?>"><input type="button" value="수정"></a>
                        </form>
                    <?php } ?>
                    </div>
                </div>
            </div>
    <?php endforeach; } ?>
        </div>
    </div>
</body>