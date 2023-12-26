<form action="sj43write.php" method="post">
    <fieldset id = form_fieldset>
        <legend>아래 내용을 입력하세요.</legend>
        <ul>
            <li><label for="name">이 름</label>
                <input type="text" name="user_name" id="name" value=""></li>
            <li><label for="password">비밀번호</label>
                <input type="password" name="user_password" id="password" value=""></li>
            <li><label for="email">e-mail</label>
                <input type="text" name="user_email" id="email" value=""></li>
            <li><label for="comment">남 긴 글</label>
                <textarea name="user_comment" id="comment" cols="50" rows="9"></textarea></li>
        </ul>
        <div class="form_class">
            <input type="submit" value="입 력">
            <input type="reset" value="지우기">
            <a href="sj43list2.php">방명록 보기 화면으로</a>
        </div>
    </fieldset>
</form>