import { cookies } from 'next/headers';
import { getCookie, setCookie } from 'cookies-next';
import { Controller } from "../../../components/Controller";

export default function login(){
    async function handleSubmit(formData) {
        'use server';  

        class MemberTable extends Controller{
            constructor(table: string) {
                super(table);
            }

            checkMember(id: string, pw: string){
                let where = "WHERE `mem_id` = '"+ id + "' AND `mem_pw` = '"+ pw  +"'";
                return this.whereSQL(where);
            }
        }

        let id = formData.get('user_id');
        let pw = formData.get('user_password');
        let login = new MemberTable('member');
        let member = await login.checkMember(id, pw);

        if(member.length != 0){
            setCookie('no', member[0]['mem_no'], { cookies });
            setCookie('name', member[0]['mem_name'], { cookies });
            setCookie('state', member[0]['mem_state'], { cookies });
        }
    }

    return (
        <div className = "auth_page">
            <h1>로그인</h1>
            <form className = "auth_input" action={handleSubmit}>
                <input className="form-control" type="text" name="user_id" id="user_id" placeholder="아이디"/>
                <input className="form-control" type="password" name="user_password" id="user_password" placeholder="비밀번호"/>
                <input type="submit" className="btn btn-outline-primary" value='로그인'/><br/>
                <a href="/member/addupdate">아직 회원이 아니신가요?</a>
            </form>
        </div>
    );
}