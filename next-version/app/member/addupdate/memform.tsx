"use client";

import { useState } from "react";
import Member from "../member";
import Idcheck from "./idcheck";

export default function Memform(){
    const [idmes, setId] = useState("");
    const [pwmes, setPw] = useState("");
    const [pw, setpw] = useState("");
    const [idchk, setIdchk] = useState(false);
    const [pwchk, setPwchk] = useState(false);

    async function onChange(e){
        if(e.target.name == 'mem_id'){
            if(e.target.value.length < 4){
                setId("4자리 이상 작성해주세요.");
            }else{
                const res = await Idcheck(e.target.value);
                if(res.message){
                    setId("사용가능한 아이디");
                    setIdchk(true);
                }else{
                    setId("중복된 아이디");
                    setIdchk(false);
                }
            }
        }else if(e.target.name == 'mem_pw'){
            setpw(e.target.value);
        }else if(e.target.name == 'mem_pw_check'){
            if(e.target.value == pw){
                setPw("");
                setPwchk(true);
            }else{
                setPw("비밀번호가 다릅니다.");
                setPwchk(false);
            }
        }
    };
    
    function addressSearch() {
        eval("daumPostcode()");
    };

    async function sumbit(formData: FormData) {
        formData.forEach(function(value, key){
            if(value == null){
                if(key == 'mem_name'){
                    alert("이름을 입력해주세요.");
                }else if(key == 'mem_id'){
                    alert("아이디를 입력해주세요.");
                }else if(key == 'mem_pw'){
                    alert("비밀번호를 입력해주세요.");
                }else if(key == 'mem_pw_check'){
                    alert("비밀번호 확인을 입력해주세요.");
                }else if(key == 'mem_zip'){
                    alert("주소를 입력해주세요.");
                }
                return 0;
            }
        });

        if(idchk && pwchk){
            const res = await Member(formData);

            if(res[0] == 'fail'){
                console.log('ckeck');
            }else{
                location.href = "/";
            }
        }
    }

    return (
        <>
            <form action={sumbit}>
                <fieldset id = "form_fieldset">
                <h2>회원 가입</h2>
                <div className="form_text">
                    <ul>
                        <li>
                            <label htmlFor  = "id_name">이름</label><br/>
                            <input className="input" type= "text" name="mem_name" id="id_name" />
                        </li>
                        <li>
                            <label htmlFor  = "id_id">아이디</label><br/>
                            <div className="dynamic">
                                <input className="input" type= "text" name="mem_id" id="id_id" onChange={onChange} />
                                <div className="message">{idmes}</div>
                            </div>
                        </li>
                        <li>
                            <label htmlFor  = "id_pw">비밀번호</label><br/>
                            <input className="input" type= "password" name="mem_pw" id="id_pw" onChange={onChange}/>
                        </li>
                        <li><label htmlFor  = "id_pw_check">비밀번호 확인</label><br/>
                            <div className="dynamic">
                                <input className="input" type= "password" name="mem_pw_check" id="id_pw_check" onChange={onChange}/>
                                <div className="message">{pwmes}</div>
                            </div>
                        </li>
                        <li>
                            <label htmlFor  = "id_detail">주소</label><br/>
                            <input className="input" type= "text" name="mem_zip" id="id_zip" placeholder="우편번호" readOnly />
                            <input type = "button" onClick={addressSearch} value="우편번호 찾기"/>
                        </li>
                        <li>
                            <input className="input" type= "text" name="mem_add" id="id_add" placeholder="주소" readOnly />
                            <input className="input" type= "text" name="mem_detail" id="id_detail" placeholder="상세주소"/>
                        </li>
                        <input type="hidden" name="mem_no"/>
                        <div className="form_bt">
                            <input type= "submit" value="등록" />
                            <input type= "reset" value='지우기' />
                        </div>
                    </ul>
                </div>
                </fieldset>
            </form>
            <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
            <script src="/js/address.js"></script>
        </>
    );
}