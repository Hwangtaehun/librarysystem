<head>
    <?php
    // 웹페이지 맞는 css설정
    if($title == '예약 현황'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/res/research";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/res/research?title=$title&pop=true";
    }

    $mem_state = $_SESSION['mem_state'];
    ?>
    <script>
        //검색 내용 확인 함수
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }

        //회원 팝업창 띄우는 함수
        function checkmem() {
            url = "/member/list?title=회원찾기&pop=true";
            window.open(url,"chkbk","width=310,height=445");
        }

        //회원 팝업창 내용을 가져오는 함수
        function memValue(no, name, state){
            document.querySelector("#id_mem").value = no;
            document.querySelector("#id_research").value = name;
        }
    </script>
</head>
<body>
<?php if(!$ispop){ ?>
    <div class="dynamic_search">
<?php } ?>
        <?php if($mem_state == 1){ ?>
        <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
            <div class="search">
                <input type="button" class="srbt" id="ie_research" value="회원찾기" onclick="checkmem();">
                <input type="text" name="user_research" id="id_research" value = "" readonly>
                <input type="hidden" id="id_mem" name="mem_no" value="">
                <button type="submit" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        <?php }else{ ?>
        <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
            <div class="search">
                <input type="text" name="user_research" id="id_research" value = "" placeholder="책이름을 입력하세요.">
                <button type="submit" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        <?php } ?>
        </form>
<?php if(!$ispop){ ?>
    </div>
<?php } ?>
    <div class="container text-center">
        <div class="row row-cols-auto">
    <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 260px;">
                    <div class="card-body">
                    <?php $symbol = $row['kind_no'].' '.$row['mat_symbol'].' '.$row['mat_many'].' '.$row['mat_overlap']?>
                        <p class="card-text">
                            도서관 이름: <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?><br>
                            책이름: <?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?><br>
                            책번호: <?=htmlspecialchars($symbol,ENT_QUOTES,'UTF-8');?><br>
                            예약일: <?=htmlspecialchars($row['res_date'],ENT_QUOTES,'UTF-8');?><br>
                        </p>
                        <?php
                            if($ispop){
                                echo '<form>';
                                $mem = "'".$row['mem_no']."'";
                                $id = "'".$row['mem_id']."'";
                                $state = "'".$row['mem_state']."'";
                                $mat = "'".$row['mat_no']."'";
                                $book = "'".$row['book_name']."'";
                                $lib = "'".$row['lib_no']."'";
                                echo '<input type=button value="선택" onclick="opener.parent.resValue('.$mem.', '.$id.','.$state.','.$mat.','.$book.','.$lib.'); window.close();">';
                            }
                            else{
                        ?>
                        <form action="/res/delete" method="post">
                                <input type="hidden" name="res_no" value="<?=$row['res_no']?>">
                                <input type="submit" value="삭제">
                        <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
    <?php endforeach; }?>
        </div>
    </div>
    <script src="../js/search.js"></script>
</body>