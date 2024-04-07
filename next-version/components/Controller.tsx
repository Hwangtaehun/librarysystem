import { Assistance } from "./includes/Assistance";
import PDO from "./includes/Dbconnect";

export class Controller{
    private libTable: string[] = ['library', 'lib_no'];
    private bookTable: string[] = ['book', 'book_no'];
    private kindTable: string[] = ['kind', 'kind_no'];
    private memTable: string[] = ['member', 'mem_no'];
    private matTable: string[] = ['material', 'mat_no'];
    private resTable: string[] = ['reservation', 'res_no'];
    private lenTable: string[] = ['lent', 'len_no'];
    private dueTable: string[] = ['overdue', 'due_no'];
    private plaTable: string[] = ['place', 'pla_no'];
    private delTable: string[] = ['delivery', 'del_no'];
    private notTable: string[] = ['notification', 'not_no'];
    private listnum : number = 19;
    private url;
    private table : string;
    private keyField: string;
    private func : string;
    private m_get : string;
    private result: string[];

    constructor(table: string){
        this.table = table;
        this.keyField = this.getKey(table);
    }

    //page번호 달기 만들기위한 html제작
	private pagemanager(total_cnt: number, value: string): string{
        var pagenum: number = 19;
        var outStr: string;

        if(20 < total_cnt){
            var total_pages = Math.floor(total_cnt/this.listnum);
            var sp_pg = Math.ceil(total_pages/pagenum);
            var sup_pg: number;
            var m_page: number;

            if(this.url.get('sup_pg') != null){
                sup_pg = +this.url.get('sup_pg');
            }
            else{
                sup_pg = 0;
            }

            if(this.url.get('page') != null){
                m_page = +this.url.get('page');
            }
            else{
                m_page = 1;
            }
            
            if(value === '없음'){
                var go_pg: number;           
                outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center">';
                if(sup_pg != 0){
                    go_pg = sup_pg - 1;
                    outStr += '<li class="page-item"> <a class="page-link" href="/' + this.table + '/' + this.func + 'list?sup_pg=' + go_pg +
                              '&page=' + m_page + this.m_get + '" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>';
                }
                for (let i=0; i < 19 ; i++) { 
                    go_pg = sup_pg;
                    var page = sup_pg * 19 + i;

                    if(page <= total_pages - 1){
                        var num = page + 1;
                        var str_num: string;
                        if(num < 10){
                            str_num = '0' + num;
                        }else{
                            str_num = num.toString();
                        }

                        let start_num = page * this.listnum;
                        outStr += '<li class="page-item"><a class="page-link" href="/' + this.table + '/' + this.func + 'list?sup_pg=' + go_pg + 
                                  '&page=' + start_num + this.m_get + '">' + str_num + '</a></li>';
                    }
                }

                if(sup_pg != sp_pg - 1){
                    go_pg = sup_pg + 1;
                    outStr += '<li class="page-item"> <a class="page-link" href="/'+ this.table + '/' + this.func + 'list?sup_pg=' + go_pg + 
                              '&page=' + m_page + this.m_get + '" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                outStr += '</ul> </div> </div>';
            }else{
                outStr = '<div class="page"> <div aria-label="Page navigation example"> <ul class="pagination justify-content-center">';
                if(sup_pg != 0){
                    go_pg = sup_pg - 1;
                    outStr += '<li class="page-item"> <a class="page-link" href="/' + this.table + '/' + this.func + 'research?sup_pg=' + go_pg + 
                              '&page=' + m_page + '&value=' + value + this.m_get + '" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>';
                }
                for (let i = 0; i < 19 ; i++) { 
                    go_pg = sup_pg;
                    page = sup_pg * 19 + i;

                    if(page <= total_pages - 1){
                        num = page + 1;
                        if(num < 10){
                            str_num = '0' + num;
                        }else{
                            str_num = page.toString();
                        }

                        let start_num = page * this.listnum;
                        outStr += '<li class="page-item"> <a class="page-link" href="/'+ this.table + '/' + this.func + 'research?sup_pg=' + go_pg +
                                  '&page=' + start_num + '&value=' + value + this.m_get + '">' + str_num + '</a></li>';
                    }
                }

                if(sup_pg != sp_pg - 1){
                    go_pg = sup_pg + 1;
                    outStr += '<li class="page-item"> <a class="page-link" href="/' + this.table + '/' + this.func + 'research?sup_pg='+ go_pg + 
                              '&page=' + m_page + '&value=' + value + this.m_get + '" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>';
                }

                outStr += '</ul> </div> </div>';
            }
        }
        return outStr;
    }

    //페이지 번호 매기기에 맞는 sql제작
    private pagesql(where: string): string{
        var page: number;

        if(this.url.get('page') != null){
            page = +this.url.get('page');
        }
        else{
            page = 0;
        }

        var limit: string = " LIMIT " + page + "," + this.listnum;

        if(where == ''){
            where = limit;
        }else{
            where += limit;
        }

        return where;
    }

    protected insertUrl(url): void{
        this.url = url;
    }

    //함수 이름
    protected funName(func: string): void{
        this.func = func;
    }

    //get 파라미터 입력
    protected getValue(m_get: string): void{
        this.m_get = m_get;
    }

    //result 값 가져오는 함수
    protected getResult(){
        return this.result;
    }

    //문자가 정수인지 확인하는 함수
	protected isInteger(strValue: string | number): boolean {
	    return Number.isInteger(strValue);;
	}
	
	//문자가 실수인지 확인하는 함수
	protected isFloat(strValue: string): boolean {
        var num : number = +strValue;
        if(this.isInteger(Math.round(num))){
            if(!this.isInteger(num)){
                return true;
            }
        }
        return false;
	}

    //한 페이지에 보여지는 정보 크기
    protected listchange(num: number): void{
        this.listnum = num;
    }
	
	//날짜형식 확인하는 함수
	protected dateformat_check(date_string: string): boolean { 
		var bool: boolean = true;
		var year: number = 0;
		var month: number = 0;
		var day: number = 0;
		var max: number = 0;
		var date_array: string[] = date_string.split('-');
		
		if(date_array.length == 3) {
			if(this.isInteger(date_array[0])) {
				let temp: string = date_array[0];
				year = +temp;
				if(this.isInteger(date_array[1])) {
					temp = date_array[1];
					month =  +temp;
					if(this.isInteger(date_array[2])) {
						temp = date_array[2];
						day = +temp;
					}
				}
			}
		}
		
		if(year > 0 && month > 0 && day > 0) {
			if(month < 13) {
				if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) {
					max = 32;
				}
				else if(month == 4 || month == 6 || month == 9 || month == 11) {
					max = 31;
				}
				else {
					if(year % 400 == 0 || (year % 4 == 0 && year % 100 != 0)) {
						max = 30;
					}
					else {
						max = 29;
					}
				}
				
				if(date_array[0].length == 4) {
					if(day < max) {
						bool = false;
					}
				}
			}
		}
		
		return bool;
	}
	
	//쿼리 결과가 없는지 확인
	protected resultempty_check(rs: string[]) {
		var bool: boolean = false;
		
		if(rs.length === 0) {
            bool = true;
        }

		return bool;
	}

    //반납 날짜 계산 - 문자 반환
    protected estimateReturndate(lentdata: Date, extend: number): string{
        let assist = new Assistance();
        let date = assist.estimateReturndate(lentdata, extend);
        let str_date = date.getFullYear() + '-' + date.getMonth() + 1 + "-" + date.getDate();

        return str_date;
    }

    //검색 결과 모두 가져오기
    protected async selectAll(){
        const sql = 'SELECT * FROM `' + this.table + '`';
        const data = await PDO(sql, '');
        const getdata: string[] = JSON.parse(JSON.stringify(data));
        return getdata;
    }

    //선택한 primary key에 대한 결과 얻기
    protected async selectID(id: number){
        const sql = 'SELECT * FROM `' + this.table + '` WHERE `' + this.keyField + '` = ' + id;
        const data = await PDO(sql, '');
        const getdata: string[] = JSON.parse(JSON.stringify(data));
        return getdata;
    }

    //조인 쿼리를 사용할 때 사용하는 함수
    protected async joinSQL(sql: string){
        const data = await PDO(sql, '');
        const getdata: string[] = JSON.parse(JSON.stringify(data));
        return getdata;
    }

    //where절을 이용한 검색 함수
    protected async whereSQL(where: string){
        const sql = 'SELECT * FROM `' + this.table + '` ' + where;
        const data = await PDO(sql, '');
        const getdata: string[] = JSON.parse(JSON.stringify(data));
        return getdata;
    }

    //커스텀 sql - delupdateSQL()
    protected async customSQL(sql: string){
        const data = await PDO(sql, '');
        const getdata: string[] = JSON.parse(JSON.stringify(data));
        return getdata;
    }

    protected insertData(param: Map<string, string>): void{
        var sql = 'INSERT INTO `' + this.table + '` SET ';
        param.forEach((values, key) => {
            sql += '`' + key + '`= ' + values + ', ';
        });
        sql = sql.replace(/,\s*$/, '');
        PDO(sql, '');
    }

    protected deleteData(id: string): void{
        let sql = 'DELETE FROM `' + this.table + '` WHERE `' + this.keyField + '`= ' + id;
        PDO(sql, '');
    }

    protected updateData(param: Map<string, string>): void{
        var sql = 'UPDATE`' + this.table + '`SET ';
        param.forEach((value, key) => {
            sql += '`' + key + '`= ' + value + ', ';
        });
        sql = sql.replace(/,\s*$/, '');
        sql += ' WHERE `' + this.keyField + '`= ' + param[this.keyField];
        PDO(sql, '');
    }

    protected allupdataData(param: Map<string, string>, id: number): void{
        var sql = 'UPDATE`' + this.table + '`SET ';
        param.forEach((value, key) => {
            sql += '`' + key + '`= ' + value + ', ';
        });
        sql = sql.replace(/,\s*$/, '');
        sql += ' WHERE `' + this.keyField + '`= ' + id;
        PDO(sql, '');
    }

    protected updateNullData(param: Map<string, string>, id: number): void{
        var sql = 'UPDATE`' + this.table + '`SET ';
        param.forEach((value, key) => {
            sql += '`' + key + '`= NULL, ';
        });
        sql = sql.replace(/,\s*$/, '');
        sql += ' WHERE `' + this.keyField + '`= ' + id;
        PDO(sql, '');
    }

    //페이그멘테이션 만들기 -- 여기 부터
    protected async makePage(total_cnt: number, sql: string, iswhere: boolean){
        var pagi: string;
        var result: string[];
        var value: string = '없음';

        if(this.url.get('value') != null){
            value = this.url.get('value');
        }
        
        sql = this.pagesql(sql);

        if(iswhere){
            result = await this.whereSQL(sql);
            pagi = this.pagemanager(total_cnt, value);
        }else{
            result = await this.joinSQL(sql);
            pagi = this.pagemanager(total_cnt, value);
        }

        this.result = result;
        return pagi;
    }

    //대출이 가능한지 확인
    protected async lentpossible(mem_no: number){
        let m_table: string = this.table;
        let m_key: string = this.keyField;
        let mem_lent: number;
        let result: string[];
        let where: string;

        this.table = this.memTable[0];
        this.keyField = this.memTable[1];
        result = await this.selectID(mem_no);
        mem_lent = +result['mem_lent'];

        this.table = this.lenTable[0];
        this.keyField =  this.lenTable[1];
        where = "WHERE `mem_no` = $mem_no AND `len_re_date` IS NULL";
        result = await this.whereSQL(where);

        this.table = m_table;
        this.keyField = m_key;

        if(result.length > mem_lent){
            alert('대출가능수를 초과했습니다.');
            return false;
        }

        return true;
    }

    //자료가 있는지 확인
    protected async existMat(mat_no: number, mat_exist: number){
        var m_table: string = this.table;
        var m_key: string = this.keyField;
        var bool: boolean = true;

        if(mat_exist == 1){
            var where: string = "WHERE `mat_no` = $mat_no AND `len_re_st` = 0";
            this.table = this.lenTable[0];
            this.keyField = this.lenTable[1];
            var rs = await this.whereSQL(where);
            bool = this.resultempty_check(rs);

            this.table = this.delTable[0];
            this.keyField = this.delTable[1];

            if(bool){
                where = "WHERE `mat_no` =  $mat_no AND `del_app` = 1 AND `len_no` IS NULL";
                rs = await this.whereSQL(where);
                bool = this.resultempty_check(rs);
            }
            
            if(bool){
                where = "WHERE `mat_no` =  $mat_no AND `del_app` = 2 AND `del_arr_date` IS NULL";
                rs = await this.whereSQL(where);
                bool = this.resultempty_check(rs);
            }

            if(bool){
                bool = false;
            }else{
                bool = true;
            }
        }

        if(bool){
            let param = new Map<string, string>();
            param.set('mat_no', mat_no.toString());
            param.set('mat_exist', mat_exist.toString());
            this.table = this.matTable[0];
            this.keyField = this.matTable[1];
            this.updateData(param);
        }

        this.table = m_table;
        this.keyField = m_key;
    }

    //예약도서인지 확인 만약에 예약도서이면 현재 회원키와 예약도서 예약된 회원키를 같으면 대출 아니면 대출 거절
    protected async reservationCheck(res_no: string, mat_no: string, mem_no: string){
        var num: number;
        var where: string;
        var row: string[];
        var rs: boolean = false;
        var m_table: string = this.table;
        var m_key: string = this.keyField;

        this.table = this.resTable[0];
        this.keyField = this.resTable[1];

        if(res_no == null){
            where = "WHERE `mat_no` = " + mat_no;
            row = await this.whereSQL(where);
            num = row.length;
            
            if(num == 0){
                rs = true;
            }
            else{
                if(row['mem_no'] == mem_no){
                    rs = true;
                    res_no = row['res_no'];
                }
            }
        }
        else{
            row = await this.selectID(+res_no);//

            if(row['mem_no'] == mem_no){
                rs = true;
            }
            else{
                rs = false;
            }
        }
        
        if(rs == false){
            alert('다른 회원이 예약한 도서입니다.');
        }else{
            this.deleteData(res_no);
        }

        this.table = m_table;
        this.keyField = m_key;

        return rs;
    }

    protected getKey(table: string): string{
        var key: string;

        switch (table) {
            case this.libTable[0]:
                key = this.libTable[1];
                break;
            case this.bookTable[0]:
                key = this.bookTable[1];
                break;
            case this.kindTable[0]:
                key = this.kindTable[1];
                break;
            case this.memTable[0]:
                key = this.memTable[1];
                break;
            case this.matTable[0]:
                key = this.matTable[1];
                break;
            case this.resTable[0]:
                key = this.resTable[1];
                break;
            case this.lenTable[0]:
                key = this.lenTable[1];
                break;
            case this.dueTable[0]:
                key = this.dueTable[1];
                break;
            case this.plaTable[0]:
                key = this.plaTable[1];
                break;
            case this.delTable[0]:
                key = this.delTable[1];
                break;
            case this.notTable[0]:
                key = this.notTable[1];
                break;
            default:
                console.log("오류 발생");
                break;
        }

        return key;
    }
}