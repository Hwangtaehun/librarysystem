<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
    </head>
    <body>
        <?php
        class Combobox_Inheritance {
            private $nothing = false;
            private $child_manager;
            private $child_sentence; //데이터 타입: array

            public function __construct(Combox_manager $cm, array $cs) {
                $this->child_manager = $cm;
                $this->child_sentence = $cs;
                $this->child_manager->exist_parent();
            }

            public function insert_nothing(bool $bool) {
                $this->nothing = $bool;
            }

            public function call_nothing() {
                return $this->nothing;
            }
        }

        class Combox_manager { //0~99, 100~199 ... 900~999
            private $pdo;
            private $fk_array;
            //private $table;
            //private $key;
            //private $sql;
            //private $key_name;
            private $parent_num;
            private $name_key;
            private $rs;
            private $ci;
            private $ci_exist = false;
            private $pa_exist = false;
            private $dialog = false;
            
            // public function __construct(string $table, string $key, string $where, bool $bool) {}

            public function __construct() {
                $this->name_key[0] = "0";
                $this->name_key[1] = "100";
                $this->name_key[2] = "200";
                $this->name_key[3] = "300";
                $this->name_key[4] = "400";
                $this->name_key[5] = "500";
                $this->name_key[6] = "600";
                $this->name_key[7] = "700";
                $this->name_key[8] = "800";
                $this->name_key[9] = "900";
            }

            public function __destruct() {}

            public function makearray() {
                if($this->pa_exist === false){
                    $this->name_key[0] = "0";
                    $this->name_key[1] = "100";
                    $this->name_key[2] = "200";
                    $this->name_key[3] = "300";
                    $this->name_key[4] = "400";
                    $this->name_key[5] = "500";
                    $this->name_key[6] = "600";
                    $this->name_key[7] = "700";
                    $this->name_key[8] = "800";
                    $this->name_key[9] = "900";
                }
                else{
                    if($this->ci_exist){
                        if(empty($parent_num)){
                            $this->name_key[0] = '0';
                            $this->name_key[1] = '10';
                            $this->name_key[2] = '20';
                            $this->name_key[3] = '30';
                            $this->name_key[4] = '40';
                            $this->name_key[5] = '50';
                            $this->name_key[6] = '60';
                            $this->name_key[7] = '70';
                            $this->name_key[8] = '80';
                            $this->name_key[9] = '90';
                        }
                        else {
                            $this->name_key[0] = $parent_num.'0';
                            $this->name_key[1] = $parent_num.'10';
                            $this->name_key[2] = $parent_num.'20';
                            $this->name_key[3] = $parent_num.'30';
                            $this->name_key[4] = $parent_num.'40';
                            $this->name_key[5] = $parent_num.'50';
                            $this->name_key[6] = $parent_num.'60';
                            $this->name_key[7] = $parent_num.'70';
                            $this->name_key[8] = $parent_num.'80';
                            $this->name_key[9] = $parent_num.'90';
                        }
                    }
                    else{
                        if(empty($parent_num)){
                            $this->name_key[0] = '0';
                            $this->name_key[1] = '1';
                            $this->name_key[2] = '2';
                            $this->name_key[3] = '3';
                            $this->name_key[4] = '4';
                            $this->name_key[5] = '5';
                            $this->name_key[6] = '6';
                            $this->name_key[7] = '7';
                            $this->name_key[8] = '8';
                            $this->name_key[9] = '9';
                        }
                        else {
                            $this->name_key[0] = $parent_num.'0';
                            $this->name_key[1] = $parent_num.'1';
                            $this->name_key[2] = $parent_num.'2';
                            $this->name_key[3] = $parent_num.'3';
                            $this->name_key[4] = $parent_num.'4';
                            $this->name_key[5] = $parent_num.'5';
                            $this->name_key[6] = $parent_num.'6';
                            $this->name_key[7] = $parent_num.'7';
                            $this->name_key[8] = $parent_num.'8';
                            $this->name_key[9] = $parent_num.'9'; 
                        }
                    }
                }
            }

            // private function makearray(string $str, bool $bool) {
            //     if(empty($str) === false){
            //         $where = $str;

            //         if($where == '없음') {
            //             $where = '';
            //         }

            //         if($bool) {
            //             $sentence = "없음-";
            //         }
            //         $this->key_name = $this->change_namekey();
            //         $this->sql = "SELECT `$this->keyname` FROM `$this->table` $where";
            //         $result = $this->pdo->query($this->sql);
            //         try {
            //             $count = 0;

            //             while($row = $result->fetchObject()) {
            //                 $sentence = $sentence.$row->$this->key_name;
            //                 $sentenct = $sentence.'-';

            //                 $fk_array[$count] = $row->$this->key;
            //                 $count++;
            //             }

            //             $this->name_key = explode('-', $sentence);
            //         }
            //         catch(PDOException $e){
            //             $strMsg = 'DB 오류: '.$e->getMessage().'<br>오류 발생 파일 : '.$e->getFile().'<br>오류 발생 행:'.$e->getLine();
            //         }
            //     }
            // }

            // private function change_namekey() {
            //     $cnt = 0;
            //     $array = str_split($this->key);

            //     for ($i = 0; $i < sizeof($array); $i++) { 
            //         if($array[$i] == '_') {
            //             $cnt = $i;
            //         }
            //     }
            //     for($i = 0; $i < $cnt + 1; $i++) {
            //         $str = $str.$array[$i];
            //     }
            //     $str.'name';

            //     return $str;
            // }

            public function ci_insert(Combobox_Inheritance $ci) {
                $this->ci = $ci;
                $this->ci_exist = true;
            }

            public function insert_parent_num(string $num) {
                $this->parent_num = $num;
            }

            public function exist_parent() {
                $this->pa_exist = true; 
            }

            public function call_name_key() {
                return $this->name_key;
            }
        }

        $super = new Combox_manager();
        $base = new Combox_manager();
        $sub = new Combox_manager();

        $super_arr = $super->call_name_key();
        $base_arr = $base->call_name_key();
        $sub_arr = $sub->call_name_key();

        $super_to_base = new Combobox_Inheritance($base, $base_arr);
        $super->ci_insert($super_to_base);
        $base_to_sub = new Combobox_Inheritance($sub, $sub_arr);
        $base->ci_insert($base_to_sub);

        $super_arr = $super->call_name_key();
        $base->makearray();
        $base_arr = $base->call_name_key();
        $sub->makearray();
        $sub_arr = $sub->call_name_key();
        ?>

        <form action = "combox_control.php" method = "POST">
            <select name = "hundred">
                <?php
                for ($i=0; $i < sizeof($super_arr); $i++) { 
                    echo "<option value = $i > $super_arr[$i] </option>";
                }
                ?>
            </select>
            <select name = "ten">
                <?php
                for ($i=0; $i < sizeof($base_arr); $i++) { 
                    echo "<option value = $i > $base_arr[$i] </option>";
                }
                ?>
            </select>
            <select name = "one">
                <?php
                for ($i=0; $i < sizeof($sub_arr); $i++) { 
                    echo "<option value = $i > $sub_arr[$i] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
        </form>
    </body>
</html>