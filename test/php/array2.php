<?php
    class SortType{
        public $type;
        public $num;
    }

    $stepCategoryJsonArray = [ // 해당 부분을 DB에서 읽어오는 것으로 응용 가능하다.
        'facebook' => ['f','a','c'],
        'google' => ['g','o','l','e']
    ];

    print_r($stepCategoryJsonArray);

    for ($i=0; $i < 10; $i++) { 
        $super[$i] = new SortType();
        $super[$i]->type = 'third';
        $super[$i]->num = $i.'00';
    }

    for ($i=0; $i < 10; $i++) { 
        $base[$i] = new SortType();
        $base[$i]->type = 'second';
        $base[$i]->num = '0'.$i.'0';
    }

    for ($i=0; $i < 10; $i++) { 
        $sub[$i] = new SortType();
        $sub[$i]->type = 'first';
        $sub[$i]->num = '00'.$i;
    }

    // for ($i=0; $i < 10; $i++) { 
    //     echo '$super[$i] = '.$super[$i].'<br>';
    // }

    // for ($i=0; $i < 10; $i++) { 
    //     echo '$base[$i] = '.$base[$i].'<br>';
    // }

    // for ($i=0; $i < 10; $i++) { 
    //     echo '$sub[$i] = '.$sub[$i].'<br>';
    // }

    $stepArray = ['hundred'=>$super, 'ten'=>$base, 'one'=>$sub];

    print_r($stepArray);
?>