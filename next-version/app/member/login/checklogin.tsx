"use server"

import { cookies } from 'next/headers';
import { setCookie } from 'cookies-next';
import { Controller } from "../../../components/Controller";

export default async function checklogin(formData) {
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
        return { message: true }
    }else{
        return { message: false }
    }
}