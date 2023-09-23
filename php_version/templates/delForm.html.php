<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <script>
        <?php
        $mem_state = $_SESSION['mem_state'];
        ?>

        function checkInput(myform) {
            if(myform.ib_name.value.length <= 0){
                alert("책 정보를 찾아주세요.");
                myform.id_name.focus();
                return false;
            }
            return true;
        }

        function checkmat() {
            url = "/len/matpop";
            window.open(url,"chkbk","width=400,height=200");
        }

        function matValue(no, name){
            document.querySelector("#id_mem").value = no;
            document.querySelector("#ib_name").value = name;
        }
    </script>
</head>
<?php
    include_once __DIR__.'/../includes/Combobox_Manager.php';
    $lib_man = new Combobox_Manager($pdo, "library", "lib_no", "", false);
    $lib = $lib_man->result_call();
?>
<body>
    <form action="/del/addupdate" method="post" onSubmit="return checkInput(this)" onReset="return checkReset()">
        <fieldset id = form_fieldset>
        <legend>아래 내용을 <?= $title2 ?>하세요.</legend>
            <ul><label for ="book_name">책이름</label>
                <input type="text" name="book_name" id="ib_name" value="<?php if(isset($row)){echo $row['book_name'];}else if(isset($_COOKIE['mat_no'.$_GET['mat_no']])){echo $_COOKIE['mat_no'.$_GET['mat_no']];}?>" readonly>
                <?php if(!isset($_GET['mat_no'])){ ?>
                    <input type="button" name="mat_check" id="mat_check" value="자료 찾기" onclick="checkmat();">
                <?php } ?>
                <br>
                <?php if(isset($_GET['lib_no'])) {
                    $lib_arr[0] = '없음';
                    for ($z=0; $z < sizeof($lib); $z++) { 
                        $lib_arr[$z+1] = $lib[$z][1];
                    }
                    $value = $lib_arr[$_GET['lib_no']]; ?>
                    <label for ="org_name">소장도서관</label>
                    <input type="text" value="<?php $value ?>" readonly>
                <?php } ?>
                <label for ="lib_name">수신도서관</label>
                <select id ="il_no" name="lib_no_arr">
                    <?php
                    for($z = 0; $z < sizeof($lib); $z++){
                        $no[$z] = $lib[$z][0]; 
                        $name[$z] = $lib[$z][1];
                    }
                    for($z = 0;$z < sizeof($lib); $z++){
                        echo "<option  value = $no[$z] > $name[$z] </option>";
                    }
                    ?>
                </select><br>
                <?php if(isset($row)){ ?>
                <label for ="len_arr_date">도착일</label>
                <input type="date" name="den_arr_date" id="id_arr_date" value="<?php echo $row['del_arr_date']; ?>"><br>
                <label for ="del_app">상태</label>
                <input type="radio" name="del_app" id="id_de" value="0"> 거절
                <input type="radio" name="del_app" id="id_ap" value="1"> 승인
                <input type="radio" name="del_app" id="id_re" value="2"> 반송 <br>
                <?php }?> 
                <input type="hidden" name="len_no" value="<?php if(isset($row)){echo $row['len_no'];}?>">
                <input type="hidden" id="id_mem" name="mem_no" value="<?php if(isset($row)){echo $row['mem_no'];}else if($mem_state == 0){echo $_SESSION['mem_no'];}?>">
                <input type="hidden" id="id_mat" name="mat_no" value="<?php if(isset($row)){echo $row['mat_no'];}else if(isset($_GET['mat_no'])){echo $_GET['mat_no'];}?>">
                <input type="hidden" name="del_no" value="<?php if(isset($row)){echo $row['del_no'];}?>">
            </ul>
            <div class="form_class">
                <input type= "submit" value="<?= $title2 ?>">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
</body>
<script>
    <?php
    if(isset($row['lib_no_arr'])){
        echo "const li = document.querySelector('#il_no');";
        $lib_no = $row['lib_no_arr'];
        echo "var lib_no = $lib_no;";
        echo "li.value = lib_no;";
    }

    if(isset($row['del_app'])){ ?>
        const de = document.querySelector('#id_de');
        const ap = document.querySelector('#id_ap');
        const re = document.querySelector('#id_re');
    <?php
        $del_app = $row['del_app'];
        if($del_app == 0){
            echo "de.checked = true;";
        }
        else if($del_app == 1){
            echo "ap.checked = true;";
        }
        else{
            echo "re.checked = true;";
        }
    }?>
        
</script>
</html>