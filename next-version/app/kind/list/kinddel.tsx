"use server";

import { Controller } from "../../../components/Controller";

export default async function Kinddel(formData){
    class Kind extends Controller{
        constructor(table: string){
            super(table);
        }

        public kinddelete(no: string){
            this.deleteData(no);
        }
    }

    const kindtable = new Kind('kind');
    kindtable.kinddelete(formData.get('kind_no'));
    return {message: true};
}