"use server";

import { cookies } from 'next/headers';
import { getCookie } from "cookies-next";
import { Controller } from "../../../components/Controller";
import Navigation from "../../../components/layout/navigation";
import Aside from '../../../components/layout/aside';
import Memlist from "../memlist";

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
    const search_check = <input type="checkbox" id="searchicon" />;
    let value = url.value;
    let page: JSX.Element;
    let result: string[];
    let state = getCookie("state", {cookies});
    let nav = navsearch();

    function navsearch(){
        return(
            <>
                {search_check}
                <label htmlFor="searchicon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                    </svg>
                </label>
            </>
        );
    }

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
        return (
        <>
            <link rel="stylesheet" href="/css/form-noaside.css" />
            <Navigation navsearch={nav} />
            <main>
                <Memlist data={result} checkid={search_check}/>
            </main>
        </>  
        );
    }else{
        return(
        <>
            <link rel="stylesheet" href="/css/form-base.css" />
            <Navigation navsearch={nav} />
            <Aside id={'기타'} />
            <main>
                <Memlist data={result} checkid={search_check} />
            </main>
        </>
        );
    }
}