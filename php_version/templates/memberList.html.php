<head>
    <?php
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
        <input type="text" name="user_research" id="id_research" value = "" placeholder="검색할 회원 이름을 입력해주세요.">
        <input type="submit" value = "검색">
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