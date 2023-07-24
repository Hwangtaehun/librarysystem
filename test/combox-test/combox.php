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

        class Combox_manager {
            private $pdo;
            private $fk = 1;
            private $table;
            private $key;
            private $key_name;
            private $parent_num;
            private $sql;
            private $arraystring;
            private $rs;
            private $ci;
            private ci_exist = false;
            private pa_exist = false;
            private dialog = false;
            
        }

        ?>
        <form action = "combox_control.php" method = "POST">
            <select name = "combox">
                <option value = "청원">청원도서관</option>
                <option value = "흥덕">흥덕도서관</option>
                <option value = "금빛">금빛도서관</option>
                <option value = "상당">상당도서관</option>
            </select>
            <input type="submit" value="등록" />
        </form>
    </body>
</html>