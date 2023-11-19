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
        <div class="search">
            <input type="text" name="user_research" id="id_research" value = "" placeholder="책이름을 입력하세요.">
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