import PDO from "./Dbconnect";

class Assistance{
	#lib_sql = "SELECT * FROM `library`";
    #lib_index = 'lib_name';

    //도서관 이름 배열 만들기
	libraryarray(){
        var num = 1;
        var data = PDO(this.#lib_sql, '');
        var index = this.#lib_index
        var result = JSON.parse(JSON.stringify(data))
        var lib_array;

        lib_array[0] = ' ';
        result.forEach(function (row) {
            lib_array[num] = row[index];
            num++;
        });
        
        return lib_array;
    }

    //복권심볼 삭제
	removeSymbol(str) {
		var str_array = [];
        var str_fianl = "";

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
}