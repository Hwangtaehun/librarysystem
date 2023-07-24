<?php
    class NameAgeClass {
        private $name;
        private $age;
        private $birth;

        public function __construct(array $name, array $age, BirthClass $birth) {
            $this->name = $name;
            $this->age = $age;
            $this->birth = $birth;
            echo 'name의 데이터타입: '.gettype($this->name).'<br>';
            echo 'age의 데이터타입: '.gettype($this->age).'<br>';
        }

        public function __destruct() { }

        public function print() {
            echo 'birth의 데이터타입: '.gettype($this->birth).'<br>';

            for ($i = 0; $i < sizeof($this->name) ; $i++) { 
                echo '$name['.$i.'] = '.$this->name[$i].'<br>';
            }

            for ($i = 0; $i < sizeof($this->age) ; $i++) { 
                echo '$age['.$i.'] = '.$this->age[$i].'<br>';
            }

            $value = $this->birth->call();
            echo '$value = '.$value.'<br>';
        }
    }

    class BirthClass {
        private $birth;

        public function __construct() {
            $this->birth = '2000-01-01';
        }

        public function call() {
            return $this->birth;
        }
    }

    $nBir = new BirthClass();

    $name[0] = 'sejong';
    $name[1] = 'computer';

    $age[0] = 33;
    $age[1] = 22;

    echo 'name의 데이터타입: '.gettype($name).'<br>';
    echo 'age의 데이터타입: '.gettype($age).'<br>';

    $nAge = new NameAgeClass($name, $age, $nBir);
    $nAge->print();
?>