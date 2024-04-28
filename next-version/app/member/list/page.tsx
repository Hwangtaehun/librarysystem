"use server";

import Memlist from "../memlist";
import { cookies } from 'next/headers';
import { getCookie } from "cookies-next";
import { Controller } from "../../../components/Controller";

export default async function memList(props){
    class Member extends Controller{
        constructor(table: string, url){
            super(table);
            this.listchange(9);
            this.insertUrl(url);
        }

        public async allMember(){
            let where = "WHERE `mem_state` NOT LIKE 1";
            let result = await this.whereSQL(where);
            let total_cnt = result.length;
            return await this.makePage(total_cnt, where, true);
        }

        public async search(){
            let value = url.value;
            let where = "WHERE `mem_name` LIKE '" + value + "' OR `mem_id` LIKE '" + value + "' AND `mem_state` NOT LIKE 1";
            let result = await this.whereSQL(where);
            let total_cnt = result.length;
            return await this.makePage(total_cnt, where, true);
        }
    }

    const url = props.searchParams;
    const member = new Member('member', url);
    let value = url.value;
    let page: JSX.Element;
    let result: string[];
    let state = getCookie("state", {cookies});

    if(state == null){
        state = '2';
    }

    if(value == null){
        page = await member.allMember();
    }else{
        page = await member.search();
    }
    result = member.getResult();

    if(state != '1'){
        return(
            <>
                <link rel="stylesheet" href="/css/form-noaside.css" />
                <Memlist data={result} />
            </>
        );
    }else{
        return(
            <>
                <link rel="stylesheet" href="/css/form-base.css" />
                <Memlist data={result} />
            </>
        );
    }
}