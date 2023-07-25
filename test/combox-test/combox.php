<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset = "utf-8">
        <title>combox 연습</title>
    </head>
    <body>
        <?php
        class Combobox_Inheritance {
            private $parent_name;
            private $nothing = false;
            private $child_manager;
            private $child_sentence; //데이터 타입: array

            public function __construct(string $pn, Combo_manager $cm, array $cs) {
                $this->parent = pn;
                $this->child_manager = cm;
                $this->child_sentence = cs;
            }

            public function insert_nothing(bool $bool) {
                $this->nothing = $bool;
            }

            public function call_parent_name() {
                return $this->parent_name;
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
                if($pa_exist === false) {
                    $name_key[0] = "0";
                    $name_key[1] = "100";
                    $name_key[2] = "200";
                    $name_key[3] = "300";
                    $name_key[4] = "400";
                    $name_key[5] = "500";
                    $name_key[6] = "600";
                    $name_key[7] = "700";
                    $name_key[8] = "800";
                    $name_key[9] = "900";
                }
                else {

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

            public function exist_parent(string $num) {
                $this->pa_exist = true;
                $this->parent_num = $num; 
            }

            public function call_name_key() {
                return $this->name_key;
            }
        }

        $combox = new Combox_manager();
        $arr = $combox->call_name_key();

        ?>

        <form action = "combox_control.php" method = "POST">
            <select name = "hundred">
                <?php
                for ($i=0; $i < sizeof($arr); $i++) { 
                    echo "<option value = $i > $arr[$i] </option>";
                }
                ?>
            </select>
            <input type="submit" value="등록" />
        </form>
    </body>
</html>