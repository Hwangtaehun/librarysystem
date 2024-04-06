import PDO from "./Dbconnect";

export class Assistance{
	private lib_sql: string = "SELECT * FROM `library`";
    private lib_index: string = 'lib_name';
	private lib_array: string[]

    //도서관 이름 배열 만들기
	public async libraryFetch(){
        var num: number = 1;
        var data = await PDO(this.lib_sql, '');
        var index: string = this.lib_index;
        var result: Array<string> = JSON.parse(JSON.stringify(data));

		this.lib_array = [];
        this.lib_array[0] = ' ';
        result.forEach(function (row) {
            this.lib_array.push(row[index]);
            num++;
        });
    }

    //복권심볼 삭제
	public removeSymbol(str: string): string {
		var str_array: Array<string> = [];
        var str_fianl: string = "";

		if(Number(str)) {
			str_fianl = "";
			return str_fianl;
		}
		
		str_array = str.split("");
		
		for(let i = 2; i < str_array.length; i++) {
			str_fianl = str_fianl + str_array[i];
		}

		return str_fianl;
	}

    //반납일 예정일 만드는 함수
	public estimateReturndate(lentdate: Date , extend: number): Date {
		var period: number = 15;

		period += extend;
		var date: Date;
        date.setDate(lentdate.getDate() + period);

		return date;
	}

	public libArray(){
		return this.libArray();
	}
}