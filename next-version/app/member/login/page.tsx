'use client'

import checklogin from "./checklogin";
import Navigation from "../../../components/layout/navigation";

export default function login(){
    async function handleSubmit(formData: FormData) {
        const res = await checklogin(formData)
        const rs = res.message

        if(rs){
            location.href = "/";
        }else{
            alert("아이디와 비밀번호가 잘못되었습니다.");
        }
    }

    return (
        <>
            <link rel="stylesheet" href="/css/form-noaside.css" />
            <Navigation />
            <main>
                <div className="auth_page">
                    <h1>로그인</h1>
                    <form className="auth_input" action={handleSubmit}>
                        <input className="form-control" type="text" name="user_id" id="user_id" placeholder="아이디" />
                        <input className="form-control" type="password" name="user_password" id="user_password" placeholder="비밀번호" />
                        <input type="submit" className="btn btn-outline-primary" value='로그인' /><br />
                        <a href="/member/addupdate">아직 회원이 아니신가요?</a>
                    </form>
                </div>
            </main>
        </>
    );
}