import Member from "../member";

export default function Meminsert(){
    async function sumbit(formData: FormData) {
        const res = await Member(formData);

        if(res[0] == 'fail'){
            console.log('ckeck');
        }else{
            location.href = "/member/list";
        }
    }

    return (
        <>
            <form action={sumbit}>
                <fieldset id = "form_fieldset">
                <h2>회원 가입</h2>
                    <ul>
                        <li>
                            <label htmlFor  = "id_name">이름</label><br/>
                            <input className="input" type= "text" name="mem_name" id="id_name"></input>
                        </li>
                        <li>
                            <label htmlFor  = "id_id">아이디</label><br/>
                            <input className="input" type= "text" name="mem_id" id="id_id"></input>
                        </li>
                        <li>
                            <label htmlFor  = "id_pw">비밀번호</label><br/>
                            <input className="input" type= "password" name="mem_pw" id="id_pw"/>
                        </li>
                        <li><label htmlFor  = "id_pw_check">비밀번호 확인</label><br/>
                            <input className="input" type= "password" name="mem_pw_check" id="id_pw_check"/>
                        </li>
                        <li>
                            <label htmlFor  = "id_detail">주소</label><br/>
                            <input className="input" type= "text" name="mem_zip" id="id_zip" value="<?php if(isset($row)){echo $row['mem_zip'];}?>" placeholder="우편번호" readOnly />
                            <input type = "button" onClick="daumPostcode()" value="우편번호 찾기"/>
                        </li>
                        <li>
                            <input className="input" type= "text" name="mem_add" id="id_add" value="<?php if(isset($row)){echo $row['mem_add'];}?>" placeholder="주소" readOnly />
                            <input className="input" type= "text" name="mem_detail" id="id_detail" value="<?php if(isset($row)){echo $row['mem_detail'];}?>" placeholder="상세주소"/>
                        </li>
                        <input type="hidden" name="mem_no"/>
                        <div className="form_bt">
                            <input type= "submit" value="등록" />
                            <input type= "reset" value='지우기' />
                        </div>
                    </ul>
                </fieldset>
            </form>
            <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
            <script src="/js/address.js"></script>
        </>
    );
}