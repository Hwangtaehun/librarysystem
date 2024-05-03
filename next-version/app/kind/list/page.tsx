"use server";

import Kindlist from "../kindlist";
import { Controller } from "../../../components/Controller";
import { Combobox_Manager } from "../../../components/includes/Combobox_Manager";
import Combobox_Inheritance from "../../../components/includes/Combobox_Inheritance";

export default async function kindList(props){
    class Kind extends Controller{
        constructor(table: string, url){
            super(table);
            this.insertUrl(url);
        }

        public async allKind(){
            let where = '';
            let result = await this.selectAll();
            let total_cnt = result.length;
            return await this.makePage(total_cnt, where, true);
        }

        public async search(){
            let value = url.value;
            let where = "WHERE `kind_no` LIKE '" + value + "'";
            let result = await this.whereSQL(where);
            let total_cnt = result.length;
            return await this.makePage(total_cnt, where, true);
        }
    }

    const url = props.searchParams;
    const kind = new Kind('kind', url);
    let value = url.value;
    let page: JSX.Element;
    let result: string[];
    let super_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '_00'", true);
    let base_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '0_0'", true);
    let sub_man = new Combobox_Manager("kind", "kind_no", "`kind_no` LIKE '00_'", true);
    let inherit1 = new Combobox_Inheritance("kind", "kind_no", "`kind_no` LIKE '?_0'", true);
    let inherit2 = new Combobox_Inheritance("kind", "kind_no", "`kind_no` LIKE '??_'", true);
    await super_man.getFetch();
    await base_man.getFetch();
    await sub_man.getFetch();
    await inherit1.getFetch();
    await inherit2.getFetch();
    let sup = super_man.result_call();
    let base = base_man.result_call();
    let sub = sub_man.result_call();
    let basearray = inherit1.call_result();
    let subarray = inherit2.call_result();

    if(value == null){
        page = await kind.allKind();
    }else{
        page = await kind.search();
    }
    result = kind.getResult();

    return(
        <>
            <link rel="stylesheet" href="/css/form-base.css" />
            <Kindlist data={result} sup={sup} base={base} sub={sub} basearray={basearray} subarray={subarray} />
        </>
    );
}