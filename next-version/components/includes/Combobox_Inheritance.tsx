import { Combobox_Manager } from "./Combobox_Manager";

class Combobox_Inheritance{
	private where_array: string[];
	private result = new Map<string, string[][]>;

	constructor(table: string, key: string, where: string, nothing: boolean) {
        var max: number;
		var count: number = this.where_edit(where);
		var word_front: string = this.where_array[0] + ' ' + this.where_array[1];

		//$count가 1일이면 중분류 배열만들기, $count가 2일이면 대분류 배열 만들기
		if(count === 1){
			max = 10;
			for (let i=0; i < max; i++) { 
				let word_back = i + this.where_array[2];
				let base_where = word_front + " '" + word_back + "'";
				//echo '$base_where = '.$base_where;
				let base_man = new Combobox_Manager(table, key, base_where, nothing);
				base_man.getFetch();
				let name = i + '00';
                this.result.set(name, base_man.result_call());
			}
		}
		else if(count === 2){
			max = 100;
			for (let i = 0; i < max; i++) { 
				let str_i = this.intTostr(i);
				let word_back = str_i + this.where_array[2];
				let sub_where = word_front + " '" + word_back + "'";
				//echo '$sub_where = '.$sub_where;
				let sub_man = new Combobox_Manager(table, key, sub_where, nothing);
				sub_man.getFetch();
				let name = str_i + '0';
                this.result.set(name, sub_man.result_call());
			}
		}
		else{
			console.log('where에 ?가 없습니다.');
		}

		//print_r(this.result);
	}

	//대분류, 중분류, 소분류 분리
	private where_edit(where: string): number{
		var rest: string;
		var cnt: number = 0;
        var temp: string[];
		this.where_array = where.split(" ");
		temp = this.where_array[this.where_array.length - 1].split("");

		for(let i = 0; i < temp.length; i++) {
			if(temp[i] === '?') {
				cnt++;
			}
			else if(temp[i] === "'"){}
			else{
				rest = rest + temp[i];
			}
		}
		this.where_array[this.where_array.length - 1] = rest;

		return cnt;
	}

	//정수를 문자로 변환
	private intTostr(num: number): string{
        var str: string;
		if(num < 10){
			str = '0' + num.toString();
		}
		else{
			str = num.toString();
		}

		return str;
	}

	public call_result(){
		return this.result;
	}
}