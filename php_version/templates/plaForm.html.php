<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel = "stylesheet" herf = "../css/form.css">
        <title><?=$title?></title>
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
            <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
                <ul><label for = "pla_name">회원아이디</label>
                    <input type= "text" name="pla_id" id="id_name" value="<?php if(isset($_COOKIE['mem_id'])){echo $_COOKIE['mem_id'];}?>" disabled><br>
                    <label for = "pla_author">책이름</label>
                    <input type= "text" name="pla_name" id="id_author" value="<?php if(isset($_COOKIE['book_name'])){echo $_COOKIE['book_name'];}?>" disabled><br>
                    <label for = "pla_publish">대출날짜</label>
                    <input type= "text" name="pla_date" id="id_publish" value="<?php if(isset($_COOKIE['len_date'])){echo $_COOKIE['len_date'];}?>" disabled><br>
                    <label for = "pla_year">대출 도서관</label>
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
                    <label for = "pla_price">반납 도서관</label>
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
        echo "const li_len = document.getElementById('il_no_len');";
        $lib_no_len = $row['lib_no_len'];
        echo "var lib_no_len = $lib_no_len;";
        echo "li_len.value = lib_no_len;";

        echo "const li_re = document.getElementById('il_no_re');";
        $lib_no_re = $row['lib_no_re'];
        if($lib_no_re == ''){
            $lib_no_re = 0;
        }
        echo "var lib_no_re = $lib_no_re;";
        echo "li_re.value = lib_no_re;";
        ?>
    </script>
</html>