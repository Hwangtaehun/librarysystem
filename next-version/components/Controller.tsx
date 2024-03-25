import { Assistance } from "./includes/Assistance";

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
    private notTable: string[] = ['notfication', 'not_no'];
    private listnum : number = 19;
    private url;
    private table : string = 'kind';
    private func : string = '';
    private m_get : string = '';
    protected maintable: string[];

    constructor(table: string){
        this.table = table;

        switch (table) {
            case this.libTable[0]:
                this.maintable = this.libTable;
                break;
            case this.bookTable[0]:
                this.maintable = this.bookTable;
                break;
            case this.kindTable[0]:
                this.maintable = this.kindTable;
                break;
            case this.memTable[0]:
                this.maintable = this.memTable;
                break;
            case this.matTable[0]:
                this.matTable = this.matTable;
                break;
            case this.resTable[0]:
                this.maintable = this.resTable;
                break;
            case this.lenTable[0]:
                this.maintable = this.lenTable;
                break;
            case this.dueTable[0]:
                this.maintable = this.dueTable;
                break;
            case this.plaTable[0]:
                this.maintable = this.plaTable;
                break;
            case this.delTable[0]:
                this.maintable = this.delTable;
                break;
            case this.notTable[0]:
                this.maintable = this.notTable;
                break;
            default:
                console.log("오류 발생");
                break;
        }
    }

    private insertUrl(url): void{
        this.url = url;
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

        var limit: string = " LIMIT $page,this.listnum";

        if(where == ''){
            where = limit;
        }else{
            where += limit;
        }

        return where;
    }

    //함수 이름
    protected funName(func: string): void{
        this.func = func;
    }

    //get 파라미터 입력
    protected getValue(m_get: string): void{
        this.m_get = m_get;
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
					if(year%400 == 0 || (year % 4 == 0 && year % 100 != 0)) {
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

    
    protected estimateReturndate(lentdata: Date, extend: number): string{
        let assist = new Assistance();
        let date = assist.estimateReturndate(lentdata, extend);
        let str_date = date.getFullYear() + '-' + date.getMonth() + 1 + "-" + date.getDate();

        return str_date;
    }

    //페이그멘테이션 만들기
    protected makePage(TableManager $mainTable, int $total_cnt, string $sql, bool $iswhere){
        $value = '없음';

        if(isset($_GET['value'])){
            $value = $_GET['value'];
        }
        
        $sql = this.pagesql($sql);

        if($iswhere){
            $stmt = $mainTable->whereSQL($sql);
            $result = $stmt->fetchAll();
            $pagi = this.pagemanager($total_cnt, $value);
        }else{
            $stmt = $mainTable->joinSQL($sql);
            $result = $stmt->fetchAll();
            $pagi = this.pagemanager($total_cnt, $value);
        }

        this.result = $result;
        return $pagi;
    }

    //대출이 가능한지 확인
    protected lentpossible(int $mem_no, TableManager $memTable, TableManager $lenTable){
        $result = $memTable->selectID($mem_no);
        $mem_lent = $result['mem_lent'];

        $where = "WHERE `mem_no` = $mem_no AND `len_re_date` IS NULL";
        $rs = $lenTable->whereSQL($where);
        $num = $rs->rowCount();

        if($num > $mem_lent){
            echo "<script>alert('대출가능수를 초과했습니다.');</script>";
            return false;
        }

        return true;
    }

    //자료가 있는지 확인
    protected existMat(int $mat_no, int $mat_exist, TableManager $lenTable, TableManager $delTable, TableManager $matTable){
        $bool = true;

        if($mat_exist == 1){
            $where = "WHERE `mat_no` = $mat_no AND `len_re_st` = 0";
            $rs = $lenTable->whereSQL($where);
            $bool = this.resultempty_check($rs);

            if($bool){
                $where = "WHERE `mat_no` =  $mat_no AND `del_app` = 1 AND `len_no` IS NULL";
                $rs = $delTable->whereSQL($where);
                $bool = this.resultempty_check($rs);
            }
            
            if($bool){
                $where = "WHERE `mat_no` =  $mat_no AND `del_app` = 2 AND `del_arr_date` IS NULL";
                $rs = $delTable->whereSQL($where);
                $bool = this.resultempty_check($rs);
            }

            if($bool){
                $bool = false;
            }else{
                $bool = true;
            }
        }

        if($bool){
            $param = ['mat_no'=>$mat_no,'mat_exist'=>$mat_exist];
            $matTable->updateData($param);
        }
    }

    //예약도서인지 확인 만약에 예약도서이면 현재 회원키와 예약도서 예약된 회원키를 같으면 대출 아니면 대출 거절
    protected reservationCheck(int $res_no, int $mat_no, TableManager $resTable){
        $rs = false;

        if($res_no == ''){
            $where = "WHERE `mat_no` = $mat_no";
            $stmt = $resTable->whereSQL($where);
            $num = $stmt->rowCount();
            
            if($num == 0){
                $rs = true;
            }
            else{
                $row = $stmt->fetch();
                if($row['mem_no'] == $_POST['mem_no']){
                    $rs = true;
                    $res_no = $row['res_no'];
                }
            }
        }
        else{
            $row = $resTable->selectID($res_no);//

            if($row['mem_no'] == $_POST['mem_no']){
                $rs = true;
            }
            else{
                $rs = false;
            }
        }
        
        if($rs == false){
            echo "<script>alert('다른 회원이 예약한 도서입니다.');</script>";
        }else{
            $resTable->deleteData($res_no);
        }

        return $rs;
    }
}