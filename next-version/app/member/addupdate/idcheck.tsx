"use server"

import { Controller } from "../../../components/Controller";

export default async function Idcheck(id: string){
    class Idcheck extends Controller{
        constructor(table: string){
            super(table);
        }

        public async memberID(id: string){
            let where:string = "where mem_id = '" + id + "'";
            let result = await this.whereSQL(where);
            
            if(result.length == 0){
                return true;
            }else{
                return false;
            }
        }
    }

    let idcheck = new Idcheck('member');
    let bool = await idcheck.memberID(id);
    
    if(bool){
        return { message: true };
    }else{
        return { message : false };
    }
}