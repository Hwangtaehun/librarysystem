<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/form-noaside.css">
    <?php
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

    if(isset($row['lib_add'])){
        $zip = $row['lib_zip'];
        $address = "[$zip] ".$row['lib_add'];

        if($row['lib_detail'] != 'null'){
            $address = $address.' '.$row['lib_detail'];
        }
    }
    ?>
</head>
<body>
    <fieldset id = form_fieldset>
        <h2><?=$title?></h2>
        <fieldset><?php if(isset($row)){echo $row['lib_name'];}?></fieldset>
            <ul>
                <li><label for  = "id_date">설립일</label>
                    <?=htmlspecialchars($row['lib_date'],ENT_QUOTES,'UTF-8');?></li>
                <li><label for  = "id_detail">주소</label>
                    <?=htmlspecialchars($address);?></li></li>
                <li><label>정기휴관일</label>
                    <?=htmlspecialchars($close);?></li></li>
                <li><label>약도</label>
                <?php if(isset($row)){ if($row['lib_url'] != ''){?>
                </li>
                <li>
                    <iframe src="<?php echo $row['lib_url']; ?>" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </li>
                <?php }}else{ ?>
                약도가 존재하지 않습니다.</li>
                <?php }?>
            </ul>
        <div class="form_class">
            <input type= "button" value="이전" onclick="javascript:history.back()">
        </div>
    </fieldset>
</body>
</html>