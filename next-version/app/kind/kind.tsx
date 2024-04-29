"use server";

import { Controller } from "../../components/Controller";
import Wrongcon from "../wrongcon";

export default async function Kind(formData){
    class Kind extends Controller{
        constructor(table: string){
            super(table);
        }

        private async makeKey(str: string, bool: boolean){
            let text: string = '중분류에 등록 수가 초과로 인해 등록이 불가능합니다.';

            if(bool){
                let array: string[] = str.split("");
                let num =  +array[2];
                if(num > 8){
                    return text;
                }
                num++;
                text = array[0] + array[1] + num;
            }else{
                let key: string = str + '%';
                let sql: string = `WHERE kind_no LIKE '${key}'`;
                let row = await this.whereSQL(sql);
                let num = row.length;
                text = row[num - 1]['kind_no'];

                if(this.isInteger(text)){
                    text = text + ".1";
                }else{
                    if(this.isFloat(text)){
                        let array = text.split(".");
                        num = +array[1];
                        num++;
                        text = array[0] + "." + num;
                    }else{
                        text = "문제발생";
                    }
                }
            }
            return text;
        }

        public async kindid(no: string){
            return await this.selectID(+no);
        }

        public async add(mapData){
            this.insertData(mapData);
        }

        public async update(mapData){
            this.updateData(mapData);
        }

        public async keySort(formData){
            let key: string;
            let kind_no: string;
        
            key = formData.get('sup');
            if(key == '0'){
                let num: string;
                let row: string[];
                let where: string;
                let array: string[];

                key = formData.get('base');
                array = key.split("");
                num = array[0] + array[1] + '_';
                where = `Where kind_no LIKE '${num}'`;
                row = await this.whereSQL(where);

                for (let i = 0; i < row.length; i++) {
                    num = row[i]['kind_no'];
                    array = num.split("");
                    if(i != +array[2]){
                        key = num;
                        break;
                    }
                    key = num;
                }

                kind_no = await this.makeKey(key, true);
            }else{
                kind_no = await this.makeKey(key, false);
            }

            return kind_no;
        }
    }

    const kindtable = new Kind('kind');
    
    if(typeof(formData) == 'string'){
        return await kindtable.kindid(formData);
    }else{
        let kind_no = await this.kindtable.keySort(formData);

        if(kind_no == '문제발생' || kind_no == '중분류'){
            return (
                <Wrongcon message={kind_no}/>
            )
        }
        else{
            let mapdata: Map<string, string> = new Map();
            
            mapdata.set('kind_no', kind_no);
            mapdata.set('kind_name', formData.get('kind_name'));
            
            if(formData.mem_no == null){
                kindtable.add(mapdata);
            }else{
                kindtable.update(mapdata);
            }
        }
    }

    return ['fail'];
}