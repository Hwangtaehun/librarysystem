<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <title>Form Tag 사용</title>
    </head>
    <?php
    function img_uplode($file, $key_name, $cnt){
        $split = explode("_", $key_name);
        $filename = $split[1].$cnt;
        $tempFile = $file[$key_name]['tmp_name'];
        $fileTypeExt = explode("/", $file[$key_name]['type']);
        $fileType = $fileTypeExt[0];
        $fileExt = $fileTypeExt[1];
        $extStatus = false;

        switch($fileExt){
            case 'jpeg':
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
                $extStatus = true;
                $filename .= '.'.$fileExt;
                break;
            default:
                echo "이미지 전용 확장자(jpg, bmp, gif, png)외에는 사용이 불가합니다."; 
                exit;
                break;
        }
        echo '$filename = '.$filename.'<br>';
        if($fileType == 'image'){
            if($extStatus){
                $resFile = "../img/$filename";
                $imageUpload = move_uploaded_file($tempFile, $resFile);
                
                if($imageUpload == true){
                    echo "파일이 정상적으로 업로드 되었습니다. <br>";
                    echo "<img src='{$resFile}' width='100' />";
                    return $resFile;
                }else{
                    echo "파일 업로드에 실패하였습니다.";
                }
            }
            else {
                echo "파일 확장자는 jpg, bmp, gif, png 이어야 합니다.";
                exit;
            }	
        }	
        else {
            echo "이미지 파일이 아닙니다.";
            exit;
        }
    }
    ?>
    <body>
        <h2>입력 내용 확인</h2>
        <?php
            print_r($_FILES);
            
            $_POST['not_pop_url'] = img_uplode($_FILES, 'not_pop_url', 1);
            $_POST['not_ban_url'] = img_uplode($_FILES, 'not_ban_url', 1);
            $p_url = $_POST['not_pop_url'];
            $b_url = $_POST['not_ban_url'];
            $context = $_POST['not_detail'];

            echo "<p>From에서 전달된 내용입니다. </p>";
            echo "<p>not_ban_url: $b_url<br>";
            echo "not_pop_url: $p_url<br>";
            echo "context: $context<br></p>";
        ?>
    </body>
</html>