<head>
    <?php
    $state = 2;

    if(isset($_SESSION['mem_state'])){
        $state = $_SESSION['mem_state'];
    }

    if($state == 1){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
    }else{
        echo '<link rel="stylesheet" href="../css/form-noaside.css">';
    }
    ?>
    <script>
        var cnt = 1;
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
    <form action="/not/research" method="post" onsubmit="return checkResearch(this)">
        <div class="search">
            <input type="text" name="user_research" id="id_research" value = "" placeholder="제목을 입력하세요.">
            <button type="submit" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
    </form>
    <?php if(isset($result)){foreach($result as $row): ?>
    <fieldset id="fieldset_row">
        <?php if($state == 1){ ?>
        <div id="div_row">
            <?=htmlspecialchars($row['not_no'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['not_name'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['not_op_date'],ENT_QUOTES,'UTF-8');?>
            <?=htmlspecialchars($row['not_cl_date'],ENT_QUOTES,'UTF-8');?>
            <?php if(isset($row['not_pop_url'])){ ?>
                <?=htmlspecialchars($row['not_pop_wid'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['not_pop_hei'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['not_pop_x'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['not_pop_y'],ENT_QUOTES,'UTF-8');?>
            <?php } ?>
        </div>
        <form action="/not/delete" method="post">
            <input type="hidden" name="not_no" value="<?=$row['not_no']?>">
            <input type="submit" value="삭제">
            <a href="/not/addupdate?not_no=<?=$row['not_no']?>"><input type="button" value="수정"></a>
        </form>
        <?php }else{ ?>
        <div id="div_row">
            <a class="http" href="/not/addupdate?not_no=<?=$row['not_no']?>">
                <script>
                    document.write(cnt+" | ");
                    cnt++;
                </script>
                <?=htmlspecialchars($row['not_name'],ENT_QUOTES,'UTF-8');?>
                <?=htmlspecialchars($row['not_op_date'],ENT_QUOTES,'UTF-8');?>
            </a>
        </div>
        <?php } ?>
    </fieldset>
    <?php endforeach; }?>
</body>