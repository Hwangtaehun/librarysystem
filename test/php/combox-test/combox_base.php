<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
    </head>
    <body>
    <?php
    class SortType{
        public $type;
        public $num;
    }
    
    for ($z=0; $z < 10; $z++) { 
        $super[$z] = $z.'00';
    }

    for ($z=0; $z < 10; $z++) { 
        $base[$z] = '0'.$z.'0';
    }

    for ($z=0; $z < 10; $z++) { 
        $sub[$z] = '00'.$z;
    }
    ?>
    <form action = "combox_control.php" method = "POST">
            <select id = "s1" name = "hundred" onchange='firstChange(this)'>
                <?php
                for ($z=0; $z < sizeof($super); $z++) { 
                    echo "<option value = $super[$z] > $super[$z] </option>";
                }
                ?>
            </select>
            <select id = "s2" name = "ten" onchange='secondChange(this)'>
                <?php
                for ($z=0; $z < sizeof($base); $z++) { 
                    echo "<option value = $base[$z] > $base[$z] </option>";
                }
                ?>
            </select>
            <select id = "s3" name = "one">
                <?php
                for ($z=0; $z < sizeof($sub); $z++) { 
                    echo "<option value = $sub[$z] > $sub[$z] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
            <?php
             for ($z=0; $z < 10; $z++) { 
                $a[$z] = '0'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $aa[$z] = '00'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ab[$z] = '01'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ac[$z] = '02'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ad[$z] = '03'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ae[$z] = '04'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $af[$z] = '05'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ag[$z] = '06'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ah[$z] = '07'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ai[$z] = '08'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $aj[$z] = '09'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $b[$z] = '1'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $ba[$z] = '10'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bb[$z] = '11'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bc[$z] = '12'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bd[$z] = '13'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $be[$z] = '14'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bf[$z] = '15'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bg[$z] = '16'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bh[$z] = '17'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bi[$z] = '18'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $bj[$z] = '19'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $c[$z] = '2'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
                $ca[$z] = '20'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cb[$z] = '21'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cc[$z] = '22'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cd[$z] = '23'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ce[$z] = '24'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cf[$z] = '25'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cg[$z] = '26'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ch[$z] = '27'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $ci[$z] = '28'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $cj[$z] = '29'.$z;
             }
             for ($z=0; $z < 10; $z++) { 
                $d[$z] = '3'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $da[$z] = '30'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $db[$z] = '31'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $dc[$z] = '32'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $dd[$z] = '33'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $de[$z] = '34'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $df[$z] = '35'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $dg[$z] = '36'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $dh[$z] = '37'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $di[$z] = '38'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $dj[$z] = '39'.$z;
            }
             for ($z=0; $z < 10; $z++) { 
                $e[$z] = '4'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $ea[$z] = '40'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $eb[$z] = '41'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ec[$z] = '42'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ed[$z] = '43'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ee[$z] = '44'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ef[$z] = '45'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $eg[$z] = '46'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $eh[$z] = '47'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ei[$z] = '48'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ej[$z] = '49'.$z;
            }
             for ($z=0; $z < 10; $z++) { 
                $f[$z] = '5'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $fa[$z] = '50'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fb[$z] = '51'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fc[$z] = '52'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fd[$z] = '53'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fe[$z] = '54'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ff[$z] = '55'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fg[$z] = '56'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fh[$z] = '57'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fi[$z] = '58'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $fj[$z] = '59'.$z;
            }
             for ($z=0; $z < 10; $z++) { 
                $g[$z] = '6'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $ga[$z] = '60'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gb[$z] = '61'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gc[$z] = '62'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gd[$z] = '63'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ge[$z] = '64'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gf[$z] = '65'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gg[$z] = '66'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gh[$z] = '67'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gi[$z] = '68'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $gj[$z] = '69'.$z;
            }
             for ($z=0; $z < 10; $z++) { 
                $h[$z] = '7'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $ha[$z] = '70'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hb[$z] = '71'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hc[$z] = '72'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hd[$z] = '73'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $he[$z] = '74'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hf[$z] = '75'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hg[$z] = '76'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hh[$z] = '77'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hi[$z] = '78'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $hj[$z] = '79'.$z;
            }
             for ($z=0; $z < 10; $z++) { 
                $i[$z] = '8'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $ia[$z] = '80'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ib[$z] = '81'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ic[$z] = '82'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $id[$z] = '83'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ie[$z] = '84'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $if[$z] = '85'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ig[$z] = '86'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ih[$z] = '87'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ii[$z] = '88'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ij[$z] = '89'.$z;
            }
             for ($z=0; $z < 10; $z++) { 
                $j[$z] = '9'.$z.'0';
             }
             for ($z=0; $z < 10; $z++) { 
               $ja[$z] = '90'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jb[$z] = '91'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jc[$z] = '92'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jd[$z] = '93'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $je[$z] = '94'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jf[$z] = '95'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jg[$z] = '96'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jh[$z] = '97'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $ji[$z] = '98'.$z;
            }
            for ($z=0; $z < 10; $z++) { 
               $jj[$z] = '99'.$z;
            }
             $SecondArray = [
                '000' => $a,
                '100' => $b,
                '200' => $c,
                '300' => $d,
                '400' => $e,
                '500' => $f,
                '600' => $g,
                '700' => $h,
                '800' => $i,
                '900' => $j
             ];

             $ThirdArray = [
               '000' => $aa,
               '010' => $ab,
               '020' => $ac,
               '030' => $ad,
               '040' => $ae,
               '050' => $af,
               '060' => $ag,
               '070' => $ah,
               '080' => $ai,
               '090' => $aj,
               '100' => $ba,
               '110' => $bb,
               '120' => $bc,
               '130' => $bd,
               '140' => $be,
               '150' => $bf,
               '160' => $bg,
               '170' => $bh,
               '180' => $bi,
               '190' => $bj,
               '200' => $ca,
               '210' => $cb,
               '220' => $cc,
               '230' => $cd,
               '240' => $ce,
               '250' => $cf,
               '260' => $cg,
               '270' => $ch,
               '280' => $ci,
               '290' => $cj,
               '300' => $da,
               '310' => $db,
               '320' => $dc,
               '330' => $dd,
               '340' => $de,
               '350' => $df,
               '360' => $dg,
               '370' => $dh,
               '380' => $di,
               '390' => $dj,
               '400' => $ea,
               '410' => $eb,
               '420' => $ec,
               '430' => $ed,
               '440' => $ee,
               '450' => $ef,
               '460' => $eg,
               '470' => $eh,
               '480' => $ei,
               '490' => $ej,
               '500' => $fa,
               '510' => $fb,
               '520' => $fc,
               '530' => $fd,
               '540' => $fe,
               '550' => $ff,
               '560' => $fg,
               '570' => $fh,
               '580' => $fi,
               '590' => $fj,
               '600' => $ga,
               '610' => $gb,
               '620' => $gc,
               '630' => $gd,
               '640' => $ge,
               '650' => $gf,
               '660' => $gg,
               '670' => $gh,
               '680' => $gi,
               '690' => $gj,
               '700' => $ha,
               '710' => $hb,
               '720' => $hc,
               '730' => $hd,
               '740' => $he,
               '750' => $hf,
               '760' => $hg,
               '770' => $hh,
               '780' => $hi,
               '790' => $hj,
               '800' => $ia,
               '810' => $ib,
               '820' => $ic,
               '830' => $id,
               '840' => $ie,
               '850' => $if,
               '860' => $ig,
               '870' => $ih,
               '880' => $ii,
               '890' => $ij,
               '900' => $ja,
               '910' => $jb,
               '920' => $jc,
               '930' => $jd,
               '940' => $je,
               '950' => $jf,
               '960' => $jg,
               '970' => $jh,
               '980' => $ji,
               '990' => $jj,
             ];
            ?>
    </form>
        <script>
            function firstChange(e){
               var stepCategoryJsonArray = <?php echo json_encode($SecondArray) ?>;
               var target = document.getElementById("s2");
               target.innerHTML = "";
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i];
                  target.appendChild(opt);
               }
               var stepCategoryJsonArray = <?php echo json_encode($ThirdArray) ?>;
               var target = document.getElementById("s3");
               target.innerHTML = "";
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i];
                  target.appendChild(opt);
               }
            }

            function secondChange(e){
               var stepCategoryJsonArray = <?php echo json_encode($ThirdArray) ?>;
               var target = document.getElementById("s3");
               target.innerHTML = "";
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i];
                  target.appendChild(opt);
               }
            }
        </script>
    </body>
</html>