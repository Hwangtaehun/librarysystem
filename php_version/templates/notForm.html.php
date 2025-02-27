<!DOCTYPE html>
<html>
<head>
    <?php
    $state = 2;

    if(isset($_SESSION['mem_state'])){
        $state = $_SESSION['mem_state'];
    }

    // 웹페이지 맞는 css설정
    if($state == 1){
        echo '<link rel="stylesheet" href="../css/form-base.css">';
    }else{
        $title = '공지사항 내용';
        echo '<link rel="stylesheet" href="../css/form-noaside.css">';
    }
    ?>
    <script>
        //필수 내용 확인하는 함수
        function checkInput(myform) {
            if(myform.id_name.value.length <= 0){
                alert("제목을 입력하세요.");
                myform.id_name.focus();
                return false;
            }
            if(myform.id_detail.length <= 0){
                alert("내용을 입력하세요.");
                myform.id_detail.focus();
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <form action="/not/addupdate" method="post" onSubmit="return checkInput(this)" enctype="multipart/form-data">
        <fieldset id = fieldset_not>
        <?php if($state == 1){ ?>
        <h2><?=$title?></h2>
            <ul>
                <li><label for  = "id_name">제목</label>
                    <input class="input" type= "text" name="not_name" id="id_name" value="<?php if(isset($row)){echo $row['not_name'];}?>"></li>
                <li><label for  = "id_op_date">시작일시</label>
                    <input type="date" name="not_op_date" id="id_op_date" value="<?php if(isset($row)){echo $row['not_op_date'];}?>">
                    <label for  = "id_cl_date">종료일시</label>
                    <input type="date" name="not_cl_date" id="id_cl_date" value="<?php if(isset($row)){echo $row['not_cl_date'];}?>"></li>
                <li><label for  = "id_context">내용</label></li>
                <li><textarea class="context" name="not_detail" id="id_context" cols="30" rows="10"><?php if(isset($row)){echo $row['not_detail'];}?></textarea></li>
                <li><label for  = "id_det">내용 이미지</label>
                    <input type= "file" name="not_det_url" id="id_det" value="">
                    <input class="input file_name" type= "text" id="file_det" value="" readonly>
                    <label class="lb" for="id_det">파일찾기</label>
                    <input type="hidden" name="not_det_url" value="<?php if(isset($row)){echo $row['not_det_url'];}?>"></li>
                <li><div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckBan" onclick="ban_box(this)">
                        <label class="form-check-label" for="flexCheckBan">배너</label>
                    </div>
                    <label for  = "id_ban">배너이미지</label>
                    <input type= "file" name="not_ban_url" id="id_ban" value="" disabled>
                    <input class="input file_name" type="text" id="file_ban" value="" readonly disabled>
                    <label class="lb" for="id_ban">파일찾기</label>
                    <input type="hidden" name="not_ban_url" value="<?php if(isset($row)){echo $row['not_ban_url'];}?>"></li>
                <li><div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckPop" onclick="pop_box(this)">
                        <label class="form-check-label" for="flexCheckPop">팝업</label>
                    </div>
                    <label for  = "id_pop">팝업이미지</label>
                    <input type= "file" name="not_pop_url" id="id_pop" value="" disabled>
                    <input class="input file_name" type="text" id="file_pop" value="" readonly disabled>
                    <label class="lb" for="id_pop">파일찾기</label>
                    <input type="hidden" name="not_pop_url" value="<?php if(isset($row)){echo $row['not_pop_url'];}?>"></li>
                <li><label for  = "id_pop_x">팝업 좌측 위치</label>
                    <input class="input number" type= "number" name="not_pop_x" id="id_pop_x" value="<?php if(isset($row)){echo $row['not_pop_x'];}?>" disabled>
                    <label for  = "id_pop_y">팝업 상단 위치</label>
                    <input class="input number" type= "number" name="not_pop_y" id="id_pop_y" value="<?php if(isset($row)){echo $row['not_pop_y'];}?>" disabled>
                    <label for  = "id_pop_wid">팝업 넓이</label>
                    <input class="input number" type= "number" name="not_pop_wid" id="id_pop_wid" value="<?php if(isset($row)){echo $row['not_pop_wid'];}?>" disabled>
                    <label for  = "id_pop_hei">팝업 높이</label>
                    <input class="input number" type= "number" name="not_pop_hei" id="id_pop_hei" value="<?php if(isset($row)){echo $row['not_pop_hei'];}?>" disabled></li>
            </ul>
            <input type="hidden" name="not_no" value="<?php if(isset($row)){echo $row['not_no'];}?>">
            <div class="form_class">
                <input type= "submit" value="<?=$title2 ?>">
                <input type= "reset" value="지우기">
            </div>
        <?php }else{?>
            <h2><?=$title?></h2>
            <ul>
                <li><label for  = "id_name">제목</label>
                    <input class="input" type= "text" name="not_name" id="id_name" value="<?php if(isset($row)){echo $row['not_name'];}?>" readonly></li>
                <li><label for  = "id_context">내용</label></li>
                <li class="notcontext">
                    <a href="<?php if(isset($row)){echo '.'.$row['not_det_url'];}?>">
                    <img src="<?php if(isset($row)){echo '.'.$row['not_det_url'];}?>" alt="" style="width:100%">
                    </a>
                    <textarea class="context" name="not_detail" id="id_context" cols="30" rows="10" readonly>
<?php if(isset($row)){echo $row['not_detail'];}?>
                    </textarea>
                </li>
            </ul>
            <div class="form_class">
                <input type="button" value="이전" onclick="javascript:history.back()">
                <a href="/not/list"><input type="button" value="목록"></a>
            </div>
        <?php } ?>
        </fieldset>
    </form>
    <script>
        const cb_id = document.getElementById('flexCheckBan');
        const cp_id = document.getElementById('flexCheckPop');
        const bu_id = document.getElementById('id_ban');
        const pu_id = document.getElementById('id_pop');
        const px_id = document.getElementById('id_pop_x');
        const py_id = document.getElementById('id_pop_y');
        const pw_id = document.getElementById('id_pop_wid');
        const ph_id = document.getElementById('id_pop_hei');
        const tb_id = document.getElementById('file_ban');
        const tp_id = document.getElementById('file_pop');

    <?php
        $ban = false;
        $pop = false;
        if(isset($row)){
            if(isset($row['not_ban_url'])){
                $ban = true;
            }
            if(isset($row['not_pop_url'])){
                $pop = true;
            }

            //url마지막 내용만 확인
            $det_url = explode("/", $row['not_det_url']);
            $ban_url = explode("/", $row['not_ban_url']);
            $pop_url = explode("/", $row['not_pop_url']);

            $end = end($det_url);
            echo "document.getElementById('file_det').value = '$end';";

            $end = end($ban_url);
            echo "tb_id.value = '$end';";
            
            $end = end($pop_url);
            echo "tp_id.value = '$end';";
        }

        //정보가 있으면 활성화되도록 변환
        if($ban){
    ?>
            cb_id.checked = true;
            bu_id.disabled = false;
            tb_id.disabled = false;
    <?php
        }

        if($pop){
    ?>
            cp_id.checked = true;
            pu_id.disabled = false;
            tp_id.disabled = false;
            px_id.disabled = false;
            py_id.disabled = false;
            pw_id.disabled = false;
            ph_id.disabled = false;
    <?php        
        }
    ?>
        //배너 체크 활성화/비활성화
        function ban_box(checkbox) {
            bu_id.disabled = checkbox.checked ? false : true;
            tb_id.disabled = checkbox.checked ? false : true;

            if(bu_id.disabled) {
                bu_id.value = null;
                tb_id.value = null;
            }else{
                bu_id.focus();
            }
        }

        //팝업 체크 활성화/비활성화
        function pop_box(checkbox) {
            pu_id.disabled = checkbox.checked ? false : true;
            tp_id.disabled = checkbox.checked ? false : true;
            px_id.disabled = checkbox.checked ? false : true;
            py_id.disabled = checkbox.checked ? false : true;
            pw_id.disabled = checkbox.checked ? false : true;
            ph_id.disabled = checkbox.checked ? false : true;

            if(pu_id.disabled) {
                pu_id.value = null;
                tp_id.value = null;
                px_id.value = null;
                py_id.value = null;
                pw_id.value = null;
                ph_id.value = null;
            }else{
                pu_id.focus();
            }
        }

        // 파일 업로드 했을때 변경사항
        // 내용 이미지
        document.getElementById('id_det').addEventListener('change', function(e){
            if(document.getElementById('id_det').value != ''){
                document.getElementById('file_det').value = document.getElementById('id_det').value;
            }
        })

        // 배너 이미지
        bu_id.addEventListener('change', function(e){
            if(bu_id.value != ''){
                tb_id.value = bu_id.value;
            }
        })

        // 팝업 이미지
        pu_id.addEventListener('change', function(e){
            if(pu_id.value != ''){
                tp_id.value = pu_id.value;
            }
        })
    </script>
</body>
</html>