<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/form-base.css">
        <script>
            //쿠키 받는 함수
            function getCookie(key){
                key = new RegExp(key + '=([^;]*)');
                return key.test(document.cookie) ? unescape(RegExp.$1) : '';
            }
        </script>
    </head>
    <?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $lib_len = $lib_man->result_call();
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", true);
    $lib_re = $lib_man->result_call();
    ?>
    <body>
        <form action="/etc/addupdate" method="post" onSubmit="return checkInput(this)">
            <fieldset id = form_fieldset>
            <h2><?=$title?></h2>
            <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
                <ul><label for  = "pla_id">회원아이디</label>
                    <input class="input" type= "text" name="pla_id" id="id_id" value="" disabled><br>
                    <label for  = "pla_name">책이름</label>
                    <input class="input" type= "text" name="pla_name" id="id_name" value="" disabled><br>
                    <label for  = "pla_date">대출날짜</label>
                    <input class="input" type= "text" name="pla_date" id="id_date" value="" disabled><br>
                    <label for = "pla_len">대출 도서관</label>
                    <select id ="il_no_len" name="lib_no_len">
                        <?php
                        for($z = 0; $z < sizeof($lib_len); $z++){
                            $no[$z] = $lib_len[$z][0]; 
                            $name[$z] = $lib_len[$z][1];
                        }
                        for($z = 0;$z < sizeof($lib_len); $z++){
                            echo "<option  value = $no[$z] > $name[$z] </option>";
                        }
                        ?>
                    </select><br>
                    <label for = "pla_re">반납 도서관</label>
                    <select id ="il_no_re" name="lib_no_re">
                        <?php
                        for($z = 0; $z < sizeof($lib_re); $z++){
                            $no[$z] = $lib_re[$z][0]; 
                            $name[$z] = $lib_re[$z][1];
                        }
                        for($z = 0;$z < sizeof($lib_re); $z++){
                            echo "<option  value = $no[$z] > $name[$z] </option>";
                        }
                        ?>
                    </select><br>
                    <input type="hidden" name="pla_no" value="<?php if(isset($row)){echo $row['pla_no'];}?>">
                </ul>
                <div class="form_class">
                    <input type= "submit" value="<?=$title2 ?>">
                    <input type= "reset" value='지우기'>
                </div>
            </fieldset>
        </form>
    </body>
    <script>
        <?php
        //대출 장소
        echo "const li_len = document.querySelector('#il_no_len');";
        $lib_no_len = $row['lib_no_len'];
        echo "var lib_no_len = $lib_no_len;";
        echo "li_len.value = lib_no_len;";

        //반납 장소
        echo "const li_re = document.querySelector('#il_no_re');";
        $lib_no_re = $row['lib_no_re'];
        //대출 반납하면 false, 대출 중은 ture
        if($lib_no_re == ''){
            $lib_no_re = 0;
            echo "li_re.disabled = true;";
        }
        else{
            echo "var lib_no_re = $lib_no_re;";
            echo "li_re.value = lib_no_re;";
        }
        ?>

        document.querySelector("#id_id").value = getCookie('mem_id');
        document.querySelector("#id_name").value = getCookie('book_name');
        document.querySelector("#id_date").value = getCookie('len_date');
    </script>
</html>