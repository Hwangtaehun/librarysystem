<form action="/student/addupdate" method="post">
  <fieldset id = form_fieldset>
    <legend>아래 내용을 <?=$title2 ?>하세요.</legend>
    <ul><li><label for="id_no">번호</label>
            <input type="text" name="stu_no" id="id_no"
                   value="<?=$row['stu_no'] ?? ''?>"></li>
        <li><label for="id_name">이름</label>
            <input type="text" name="stu_name" id="id_name"
                   value="<?=$row['stu_name'] ?? ''?>"></li>
        <li><label for="id_addr">주소</label>
            <input type="text" name="stu_address" id="id_addr"
                   value="<?=$row['stu_address'] ?? ''?>"></li>
        <li><label for="id_bday">생일</label>
            <input type="text" name="stu_birthday" id="id_bday"
                   value="<?=$row['stu_birthday'] ?? ''?>"></li>
            <input type="hidden" name="stu_id" 
                   value="<?=$row['stu_id'] ?? ''?>">
    </ul>
    <div class="form_class">
      <input type="submit" value="<?=$title2 ?>">
    </div>
  </fieldset>
</form>
