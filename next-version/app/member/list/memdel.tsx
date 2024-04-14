"use server";

import { Controller } from "../../../components/Controller";

export default async function Memdel(formData){
    class Member extends Controller{
        constructor(table: string){
            super(table);
        }

        public memdelete(no: string){
            this.deleteData(no);
        }
    }

    const memtable = new Member('member');
    memtable.memdelete(formData.get('mem_no'));
    return {message: true};
}