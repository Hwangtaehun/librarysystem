"use server";

import { Controller } from "../../components/Controller";

export default async function Member(formData){
    class Member extends Controller{
        constructor(table: string){
            super(table);
        }

        public async memid(no: string){
            return await this.selectID(+no);
        }

        public async add(mapData){
            this.insertData(mapData);
        }

        public async update(mapData){
            this.updateData(mapData);
        }
    }

    const memtable = new Member('member');
    
    if(typeof(formData) == 'string'){
        return await memtable.memid(formData);
    }else{
        let mapdata: Map<string, string> = new Map();

        for(let key of formData.keys()){
            mapdata.set(key, formData.get(key));
        }

        if(formData.mem_no == null){
            mapdata.delete('mem_no');
            memtable.add(mapdata);
        }else{
            memtable.update(mapdata);
        }
    }

    return ['fail'];
}