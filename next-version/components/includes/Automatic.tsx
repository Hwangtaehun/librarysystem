import PDO from "./Dbconnect";

class Automatic {
    private today: Date;
	
	public __construct() {
		this.today = new Date("Y-m-d");
		this.clearmember();
		this.overdue_manager();
		this.delreturn();
	}

    //반납일 예정일 만드는 함수
	protected estimateReturndate(lentdate: Date , extend: number): Date {
		var period: number = 15;

		period += extend;
		var date: Date;
        date.setDate(lentdate.getDate() + period);

		return date;
	}
	
	//연체 관리 함수
	private overdue_manager() {
        var today = this.today;
		var sql: string = "SELECT * FROM lent WHERE len_re_date is NULL";
		var data = PDO(sql, '');
        var result: Array<string> = JSON.parse(JSON.stringify(data)); 
		var num: Number = result.length;
		var count: number = 0;

		if(num != 0) {	
            var len_no_array : Array<string>;
            result.forEach(function (row) {
                //반납 추정일
                var estimate_date: Date = this.estimateReturndate(row['len_date'], row['len_re_st']);

                //반납 추정일이 지났으면 회원계정을 정지 계정으로 변환
                if(estimate_date < today ) {
                    len_no_array[count] = row['len_no'];
                    count++;
                    sql = "UPDATE member SET mem_state = 2 WHERE mem_no = $row->mem_no";
                    PDO(sql, '');
                }
            });

            //연체 테이블에 삽입
            for(let i = 0; i < count; i++) {
                sql = "SELECT * FROM overdue WHERE len_no = " + len_no_array[i];
                data = PDO(sql, '');
                result = JSON.parse(JSON.stringify(data));
                num = result.length;

                if(num == 0){
                    sql = "INSERT INTO overdue SET len_no = " + len_no_array[i];
                    PDO(sql, '');
                }
            }
		}
	}
	
	//연체 해제 함수
	private clearmember() {
		//연체 해제일 지났을때
		var str_today: string = this.today.getFullYear() + "-" + this.today.getMonth() + 1 + "-" + this.today.getDate();
		var sql: string = "SELECT * FROM lent INNER JOIN overdue ON lent.len_no = overdue.len_no WHERE overdue.due_exp <= '" + str_today +"'";
		var data = PDO(sql, '');
        var result: Array<string> = JSON.parse(JSON.stringify(data));
		var num: Number = result.length;

		if(num != 0) {
			var mem_no: Array<Number> = [];
			var due_no: Array<Number> = [];
			var cnt = 0;

				//해제할 회원과 연체 테이블 배열로 저장
			result.forEach(function (row) {
				mem_no[cnt] = row['mem_no'];
				due_no[cnt] = row['due_no'];
				cnt++;
			})
				
				//회원을 상태를 0으로 바꾸고 연체 테이블 삭제
				for(let i = 0; i < cnt; i++) {
					sql = "UPDATE member SET mem_state = 0 WHERE mem_no = " + mem_no[i];
					PDO(sql, '');
					sql = "DELETE FROM overdue WHERE due_no = " + due_no[i];
					PDO(sql, '');
					sql= "SELECT * FROM overdue, lent WHERE overdue.len_no = lent.len_no AND lent.mem_no = " + mem_no[i];
					let data = PDO(sql, '');
					result = JSON.parse(JSON.stringify(data));
					let count = result.length;

					if(count != 0){
						sql = "UPDATE member SET mem_state = 2 WHERE mem_no = " + mem_no[i];
						PDO(sql, '');
					}
				}
		}
	}

	//상호대차 도서 반송 함수
	private delreturn(){
		var date: Date;
        date.setDate(this.today.getDate() - 4);
		var date_str: string =  date.getFullYear() + "-" + date.getMonth() + 1 + "-" + date.getDate();

		var sql: string = "SELECT `del_no` FROM `delivery` WHERE len_no IS NULL AND `del_arr_date` < '"+ date_str +"'";
		var data = PDO(sql, '');
		var result: Array<string> = JSON.parse(JSON.stringify(data));
		var num: number = result.length;

		if(num != 0){
			var cnt = 0;
			var del_no: Array<string> = [];

			result.forEach(function (row) {
				del_no[cnt] = row['del_no'];
				cnt++;
			})

			for (let i=0; i < cnt; i++) { 
				sql = "UPDATE delivery SET del_app = 2 WHERE del_no = " + del_no[i];
				PDO(sql, '');
			}
		}
	}
}