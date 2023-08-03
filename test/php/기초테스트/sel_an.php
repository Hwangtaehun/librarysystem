<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="http://code.jquery.com/jquery-1.12.1.js"></script>
  </head>
  <body>
    <!-- onchange를 통해서 변경되는 event가 발생하면 categoryChange 함수를 호출한다.-->
    <select id='step1' onchange='categoryChange(this)' >
      <option value='facebook'>facebook</option>
      <option value='google'>google</option>
    </select>
    <!-- 변화가 생기기 전에 select box에서 기본적으로 표시될 부분.-->
    <!-- 이 부분도 동적으로 하고 싶으면, DB에서 값을 읽어와서 php echo를 통해 뿌려주는 방법으로 처리.-->
    <select id='step2'>
      <option value='f'>f</option>
      <option value='a'>a</option>
      <option value='c'>c</option>
    </select>
    <?php
      $stepCategoryJsonArray = array( // 해당 부분을 DB에서 읽어오는 것으로 응용 가능하다.
        'facebook' => array('f','a','c'),
        'google' => array('g','o','l','e')
      );
     ?>
     <script>
      function categoryChange(e){ // 인자로 호출된 값을 받는다.
        var stepCategoryJsonArray = <?php echo json_encode($stepCategoryJsonArray) ?>; // php에서 json으로 가공한 값을 js에서 json 으로 encode
        console.log(stepCategoryJsonArray[e.value].length); // 호출된 json 배열의 크기
        $("select#step2 option").remove(); // jQuery 를 이용하여 기존의 step2 option 모두 제거 -> 없으면 선택한 step2들이 계속 누적된다.

        var target = document.getElementById("step2"); // step2의 요소들을 가져온다.
        for(var i=0; i<stepCategoryJsonArray[e.value].length; i++){
          console.log(stepCategoryJsonArray[e.value][i]); // 현재 값을 log로 출력
          var opt = document.createElement('option'); // option 이라는 태그를 사용할 것이라 선언
          opt.value = stepCategoryJsonArray[e.value][i]; // option의 value를 추가
          opt.innerHTML = stepCategoryJsonArray[e.value][i]; // option의 inner 부분을 추가
          target.appendChild(opt); // 객체로 생성(위에서 가공한 것을 기반으로, 실질적으로 html 코드가 생성되는 부분)
        }
      }
     </script>
  </body>
</html>

<!-- https://kingle1024.tistory.com/182 -->