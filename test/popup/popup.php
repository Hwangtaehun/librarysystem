<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel = "stylesheet" herf = "../css/form.css">
    <title><?=$title?></title>
    <script>
        function researchMem() {
            url = "check.php"; //$controller
            window.open(url,"chkid","width=400,height=200");
        }

        function memValue(name, id){
            document.getElementById("id_key").value = name;
            document.getElementById("id_no").value = id;
        }
    </script>
</head>
<body>
    <form action="result.php" method="post">
        <fieldset id = form_fieldset>
            <ul><label for = "mem_id">아이디</label>
                <input type= "text" name="mem_id" id="id_key" value="">
                <input type="hidden" name="mem_no" id="id_no" value="<?=$row['mem_no']?>">
                <input type= "button" name="mem_check" id="mem_check" value="회원찾기" onclick="researchMem();"><br>
            </ul>
            <div class="form_class">
                <input type= "submit" value="입력">
                <input type= "reset" value='지우기'>
            </div>
        </fieldset>
    </form>
</body>
</html>