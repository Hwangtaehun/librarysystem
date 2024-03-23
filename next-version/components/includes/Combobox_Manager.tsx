import PDO from "./Dbconnect";

export class Combobox_Manager {
	private pri: string[];
    private name: string[];
	private result: string[][];

	constructor(table: string, key: string, where: string, nothing: boolean) {
		var count: number = 0;
		var key_name: string = this.changenamekey(key);
        var sql: string;
		// echo '$key_name = '.$key_name.'<br>';
		if(where === ""){
			sql = "SELECT * FROM `" + table + "`";
		}
		else{
			sql = "SELECT * FROM `" + table + "` WHERE $where";
		}
		//echo '$sql = '.$sql.'<br>';
        var data = PDO(sql, '');
		var result: Array<string> = JSON.parse(JSON.stringify(data));

        result.forEach(function (row) {
            this.pri[count] = row[key];
            this.name[count] = row[key_name];
            count++;
        });

		if(nothing){
			this.result[0][0] = '0';
            this.result[0][1] = '없음';
			for (let i= 0; i < count ; i++) { 
				this.result[i+1][0] = this.pri[i];
                this.result[i+1][1] = this.name[i];
			}
		}
		else{
			for (let i=0; i < count ; i++) { 
				this.result[i][0] = this.pri[i];
                this.result[i][1] = this.name[i];
			}
		}
	}

	//테이블_no를 테이블_name으로 변경
	private changenamekey(key: string) :string {
		var str : string;
		var cnt : number = 0;
		var temp: string[] = key.split("");

		for(let i = 0; i < temp.length; i++) {
			if(temp[i] == '_') {
				cnt = i;
			}
		}

		for(let i = 0; i < cnt + 1; i++) {
			str += temp[i];
		}
		str += "name";
		
		return str;
	}

	public result_call(): string[][] {
		return this.result;
	}
}