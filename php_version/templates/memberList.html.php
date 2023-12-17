<head>
    <?php
    // 웹페이지 맞는 css설정
    if($title == '회원 현황'){
        echo '<link rel="stylesheet" href="../css/form-noaside.css">';
        $ispop = false;
        $action = "/member/research";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/member/research?title=$title&pop=true";
    }
    ?>
    <script>
        //검색 내용확인하는 함수
        function checkResearch(myform) {
            if(myform.user_research.value.length <= 0){
                alert("검색할 내용을 입력해주세요.");
                myform.user_research.focus();
                return false;
            }
            return true;            
        }
    </script>
</head>
<body>
    <form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
        <div class="search">
            <input type="text" name="user_research" id="id_research" value = "" placeholder="검색할 회원 이름을 입력해주세요.">
            <button type="submit" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
    </form>
    <div class="container text-center">
    <?php if($ispop){ ?>
        <div class="row">
    <?php }else{ ?>
        <div class="row row-cols-3">
    <?php }?>
        <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 260px;">
                    <div class="card-body">
                    <?php
                        $m_state = $row['mem_state'];

                        if($m_state == 0){
                            $mem_state = '일반';
                        }
                        else if($m_state == 1){
                            $mem_state = '관리자';
                        }
                        else{
                            $mem_state = '정지';
                        }
                    ?>
                        <h5 class="card-title"><?=htmlspecialchars($row['mem_name'],ENT_QUOTES,'UTF-8');?></h5>
                        <p class="card-text">
                            아이디: <?=htmlspecialchars($row['mem_id'],ENT_QUOTES,'UTF-8');?><br>
                            비밀번호: <?=htmlspecialchars($row['mem_pw'],ENT_QUOTES,'UTF-8');?><br>
                            <?php if(isset($row['mem_add'])){ ?>
                            주소: <?=htmlspecialchars($row['mem_add'],ENT_QUOTES,'UTF-8');?><br>
                            <?php } ?>
                            상태: <?=htmlspecialchars($mem_state,ENT_QUOTES,'UTF-8');?><br>
                        </p>
                        <?php
                            if($ispop){
                                echo '<form>';
                                $no = "'".$row['mem_no']."'";
                                $name = "'".$row['mem_id']."'";
                                $state = "'".$row['mem_state']."'";
                                if($state != 1){
                                    echo '<input type=button value="선택" onclick="opener.parent.memValue('.$no.','.$name.','.$state.'); window.close();">';
                                }
                            }
                            else{
                        ?>
                        <form action="/member/delete" method="post">
                                <input type="hidden" name="mem_no" value="<?=$row['mem_no']?>">
                                <input type="submit" value="삭제">
                                <a href="/member/addupdate?mem_no=<?=$row['mem_no']?>"><input type="button" value="수정"></a>
                        <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
    <?php endforeach; }?>
        </div>
    </div>
</body>