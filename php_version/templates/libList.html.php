<head>
<?php
    //css따라 선택
    if($title == '도서관 현황'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/lib/research";
    }
    else if($title == '도서관 정보'){
        echo '<link rel="stylesheet" href="../css/form-noaside.css">';
        $ispop = false;
        $action = "/lib/research?title=$title";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/lib/research?title=$title&pop=true";
    }

    $state = 2;

    if(isset($_SESSION['mem_state'])) {
        $state = $_SESSION['mem_state'];
    }
?>
    <script>
        //검색 내용 확인
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
<form action="<?php echo $action; ?>" method="post" onsubmit="return checkResearch(this)">
    <div class="search">
        <input type="text" name="user_research" id="id_research" value = "" placeholder="도서관이름을 입력하세요.">
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
<?php if(isset($result)){foreach($result as $row): 
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
?>
        <div class="col">
            <div class="card" style="width: 16rem; height: 200px;">
                <div class="card-body">
                <h5 class="card-title">
                    <?=htmlspecialchars($row['lib_name'],ENT_QUOTES,'UTF-8');?>
                </h5>
                <p class="card-text">
                    설립일: <?=htmlspecialchars($row['lib_date'],ENT_QUOTES,'UTF-8');?><br>
                    주소: <?=htmlspecialchars($row['lib_add'],ENT_QUOTES,'UTF-8');?><br>
                    쉬는날: <?=htmlspecialchars($close,ENT_QUOTES,'UTF-8');?><br>
                </p>
                <?php
                    if($ispop){
                        echo '<form>';
                        $name = "'".$row['lib_name']."'";
                        $no = "'".$row['lib_no']."'";
                        echo '<input type=button value="선택" onclick="opener.parent.libValue('.$name.', '.$no.'); window.close();">';
                    }
                    else{ if($state == 1){
                ?>
                    <form action="/lib/delete" method="post">
                            <input type="hidden" name="mem_no" value="<?=$row['lib_no']?>">
                            <input type="submit" value="삭제">
                            <a href="/lib/addupdate?lib_no=<?=$row['lib_no']?>"><input type="button" value="수정"></a>
                <?php }else{ ?>
                    <form action="/lib/detail" method="post">
                            <input type="hidden" name="mem_no" value="<?=$row['lib_no']?>">
                            <input type="submit" value="상세 정보">
                <?php }} ?>
                    </form>
                </div>
            </div>
        </div>
<?php endforeach; }?>
    </div>
</div>