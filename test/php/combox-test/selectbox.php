<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
        <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
    <?php
    include_once __DIR__.'/Combobox_Manager.php';

    $super_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '_00'");
    $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '0_0'");
    $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '00_'");

    $super = $super_man->result_call();
    $base = $base_man->result_call();
    $sub = $sub_man->result_call();
    ?>
    <form action = "selectbox_control.php" method = "POST">
            <select id = "s1" name = "super" onchange='superChange(this)'>
                <?php
                for ($z=0; $z < sizeof($super); $z++) { 
                    $no[$z] = $super[$z][0];
                    $name[$z] = $super[$z][1];
                }
                for ($z=0; $z < sizeof($super); $z++) { 
                    echo "<option value = $no[$z] > $name[$z] </option>";
                }
                ?>
            </select>
            <select id = "s2" name = "base" onchange='baseChange(this)'>
                <?php
                for ($z=0; $z < sizeof($base); $z++) { 
                    $no[$z] = $base[$z][0];
                    $name[$z] = $base[$z][1];
                }
                for ($z=0; $z < sizeof($base); $z++) { 
                    echo "<option value = $no[$z] > $name[$z] </option>";
                }
                ?>
            </select>
            <select id = "s3" name = "sup">
                <?php
                for ($z=0; $z < sizeof($sub); $z++) { 
                    $no[$z] = $sub[$z][0];
                    $name[$z] = $sub[$z][1];
                }
                for ($z=0; $z < sizeof($sub); $z++) { 
                    echo "<option value = $no[$z] > $name[$z] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
            <?php
             $a = $base;
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '1_0'");
             $b = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '2_0'");
             $c = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '3_0'");
             $d = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '4_0'");
             $e = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '5_0'");
             $f = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '6_0'");
             $g = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '7_0'");
             $h = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '8_0'");
             $i = $base_man->result_call();
             $base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '9_0'");
             $j = $base_man->result_call();

             $aa = $sub;
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '01_'");
             $ab = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '02_'");
             $ac = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '03_'");
             $ad = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '04_'");
             $ae = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '05_'");
             $af = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '06_'");
             $ag = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '07_'");
             $ah = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '08_'");
             $ai = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '09_'");
             $aj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '10_'");
             $ba = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '11_'");
             $bb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '12_'");
             $bc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '13_'");
             $bd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '14_'");
             $be = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '15_'");
             $bf = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '16_'");
             $bg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '17_'");
             $bh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '18_'");
             $bi = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '19_'");
             $bj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '20_'");
             $ca = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '21_'");
             $cb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '22_'");
             $cc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '23_'");
             $cd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '24_'");
             $ce = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '25_'");
             $cf = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '26_'");
             $cg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '27_'");
             $ch = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '28_'");
             $ci = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '29_'");
             $cj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '30_'");
             $da = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '31_'");
             $db = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '32_'");
             $dc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '33_'");
             $dd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '34_'");
             $de = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '35_'");
             $df = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '36_'");
             $dg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '37_'");
             $dh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '38_'");
             $di = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '39_'");
             $dj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '40_'");
             $ea = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '41_'");
             $eb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '42_'");
             $ec = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '43_'");
             $ed = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '44_'");
             $ee = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '45_'");
             $ef = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '46_'");
             $eg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '47_'");
             $eh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '48_'");
             $ei = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '49_'");
             $ej = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '50_'");
             $fa = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '51_'");
             $fb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '52_'");
             $fc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '53_'");
             $fd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '54_'");
             $fe = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '55_'");
             $ff = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '56_'");
             $fg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '57_'");
             $fh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '58_'");
             $fi = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '59_'");
             $fj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '60_'");
             $ga = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '61_'");
             $gb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '62_'");
             $gc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '63_'");
             $gd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '64_'");
             $ge = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '65_'");
             $gf = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '66_'");
             $gg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '67_'");
             $gh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '68_'");
             $gi = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '69_'");
             $gj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '70_'");
             $ha = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '71_'");
             $hb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '72_'");
             $hc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '73_'");
             $hd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '74_'");
             $he = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '75_'");
             $hf = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '76_'");
             $hg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '77_'");
             $hh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '78_'");
             $hi = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '79_'");
             $hj = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '80_'");
             $ia = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '81_'");
             $ib = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '82_'");
             $ic = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '83_'");
             $id = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '84_'");
             $ie = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '85_'");
             $if = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '86_'");
             $ig = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '87_'");
             $ih = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '88_'");
             $ii = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '89_'");
             $ij = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '90_'");
             $ja = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '91_'");
             $jb = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '92_'");
             $jc = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '93_'");
             $jd = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '94_'");
             $je = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '95_'");
             $jf = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '96_'");
             $jg = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '97_'");
             $jh = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '98_'");
             $ji = $sub_man->result_call();
             $sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '99_'");
             $jj = $sub_man->result_call();

             $basearray = [
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

             $subarray = [
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
               '990' => $jj
             ];
            ?>
    </form>
        <script>
            function superChange(e){
               var stepCategoryJsonArray = <?php echo json_encode($basearray) ?>;
               $("select#s2 option").remove();
               var target = document.getElementById("s2");
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i][0];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                  target.appendChild(opt);
               }
               var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
               $("select#s3 option").remove();
               var target = document.getElementById("s3");
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i][0];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                  target.appendChild(opt);
               }
            }

            function baseChange(e){
               var stepCategoryJsonArray = <?php echo json_encode($subarray) ?>;
               $("select#s3 option").remove();
               var target = document.getElementById("s3");
               for(var i = 0; i < stepCategoryJsonArray[e.value].length; i++){
                  var opt = document.createElement('option');
                  opt.value = stepCategoryJsonArray[e.value][i][0];
                  opt.innerHTML = stepCategoryJsonArray[e.value][i][1];
                  target.appendChild(opt);
               }
            }
        </script>
    </body>
</html>