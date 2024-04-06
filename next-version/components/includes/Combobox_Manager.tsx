import PDO from "./Dbconnect";

export class Combobox_Manager {
	private table: string;
	private key: string;
	private where: string;
	private nothing: boolean;
	private result: string[][];

	constructor(table: string, key: string, where: string, nothing: boolean) {
		this.table = table;
		this.key = key;	
		this.where = where;
		this.nothing = nothing;
	}

	//테이블_no를 테이블_name으로 변경
	private changenamekey(key: string) :string {
		var str : string = "";
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

	public async getFetch(){
		var pri: string[]
		var name: string[]
		var count: number = 0;
		var key_name: string = this.changenamekey(this.key);
		var key =  this.key;
        var sql: string;

		if(this.where === ""){
			sql = "SELECT * FROM `" + this.table + "`";
		}
		else{
			sql = "SELECT * FROM `" + this.table + "` WHERE $where";
		}

        var data = await PDO(sql, '');
		var result: Array<string> = JSON.parse(JSON.stringify(data));

		pri = [];
		name = [];
		this.result = [];

        result.forEach(function (row) {
			pri.push(row[key].toString());
			name.push(row[key_name]);
			count++;
        });

		if (this.nothing) {
            this.result.push(['0', '없음']);
            for (let i = 0; i < count; i++) {
                this.result.push([pri[i], name[i]]);
            }
        } else {
            for (let i = 0; i < count; i++) {
                this.result.push([pri[i], name[i]]);
            }
        }
	}

	public result_call(): string[][] {
		return this.result;
	}
}