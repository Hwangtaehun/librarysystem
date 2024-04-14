"use server";

import { Controller } from "../../../components/Controller";
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
    let value = url.value;
    let page: JSX.Element;
    let result: string[];

    if(value == null){
        page = await member.allMember();
    }else{
        page = await member.search();
    }
    result = member.getResult();

    return (
        <Memlist data={result}/>
    )
}