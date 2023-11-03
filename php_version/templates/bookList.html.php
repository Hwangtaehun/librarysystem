<head>
    <?php
    if($title == '책 현황'){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
        $ispop = false;
        $action = "/book/research";
    }
    else{
        echo '<link rel="stylesheet" href="../css/form-popup.css">';
        $ispop = true;
        $action = "/book/research?title=$title&pop=true";
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
        <input type="text" name="user_research" id="id_research" value = "" placeholder="책이름을 입력하세요.">
        <input type="submit" value = "검색">
    </form>
    <div class="container text-center">
        <div class="row">
    <?php if(isset($result)){foreach($result as $row): ?>
            <div class="col">
                <div class="card" style="width: 16rem; height: 260px;">
                    <div class="card-body">
                        <h5 class="card-title"><?=htmlspecialchars($row['book_name'],ENT_QUOTES,'UTF-8');?></h5>
                        <p class="card-text">작가:<?=htmlspecialchars($row['book_author'],ENT_QUOTES,'UTF-8');?><br>
                                            출판사:<?=htmlspecialchars($row['book_publish'],ENT_QUOTES,'UTF-8');?><br>
                                            출판년도:<?=htmlspecialchars($row['book_year'],ENT_QUOTES,'UTF-8');?>년<br>
                                            가격:<?=htmlspecialchars($row['book_price'],ENT_QUOTES,'UTF-8');?>원
                        </p>
                        <?php
                            if($ispop){
                                echo '<form>';
                                $name = "'".$row['book_name']."'";
                                $no = "'".$row['book_no']."'";
                                $aut = "'".$row['book_author']."'";
                                echo '<input type=button value="선택" onclick="opener.parent.bookValue('.$no.', '.$name.','.$aut.'); window.close();">';
                            }
                            else{
                        ?>
                        <form action="/book/delete" method="post">
                            <input type="hidden" name="mem_no" value="<?=$row['book_no']?>">
                            <input type="submit" value="삭제">
                            <a href="/book/addupdate?book_no=<?=$row['book_no']?>"><input type="button" value="수정"></a>
                        <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
    <?php endforeach; }?>
        </div>
    </div>
</body>