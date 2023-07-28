<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
        <script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
    <?php
    for ($i=0; $i < 10; $i++) { 
        $super[$i] = $i.'00';
    }

    for ($i=0; $i < 10; $i++) { 
        $super[$i] = $i.'0';
    }

    for ($i=0; $i < 10; $i++) { 
        $super[$i] = $i;
    }
    ?>
    <form action = "combox_control.php" method = "POST">
            <select id = "s1" name = "hundred" onchange="hundard_change()">
                <?php
                for ($i=0; $i < sizeof($super); $i++) { 
                    echo "<option value = $i > $super[$i] </option>";
                }
                ?>
            </select>
            <select id = "s2" name = "ten" onchange="ten_change()">
                <?php
                for ($i=0; $i < sizeof($base); $i++) { 
                    echo "<option value = $i > $base[$i] </option>";
                }
                ?>
            </select>
            <select id = "s3" name = "one">
                <?php
                for ($i=0; $i < sizeof($sub); $i++) { 
                    echo "<option value = $i > $sub[$i] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
    </form>
        <script>
            function hundard_change() {
                var value = $('#s1').val();
                $('#s2').empty();
                <?php
                $parent_num = "document.write (value);";
                $base->insert_parent_num($parent_num);
                $base->makearray();
                $base_arr = $base->call_name_key();
                $count = sizeof($base_arr);
                for ($i=0; $i < $count ; $i++) { 
                    echo "\$('#s2').append('<option>' + $base_arr[$i] + '</option>' )";
                }
                ?>
            }

            function ten_change() {
                var value = $('#s2').val();
                $('#s3').empty();
                <?php
                $parent_num = "document.write (value);";
                $sub->insert_parent_num($parent_num);
                $sub->makearray();
                $sub_arr = $sub->call_name_key();
                $count = sizeof($sub_arr);
                for ($i=0; $i < $count ; $i++) { 
                    echo "\$('#s2').append('<option>' + $base_arr[$i] + '</option>' )";
                }
                ?>
            }
        </script>
    </body>
</html>