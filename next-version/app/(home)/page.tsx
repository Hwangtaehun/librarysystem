import { cookies } from 'next/headers';
import { getCookie } from 'cookies-next';
import { Controller } from '../../components/Controller'
import { Combobox_Manager } from '../../components/includes/Combobox_Manager'
import Calender from './calendar';
import Libselect from './libselect';
import Searchmat from './searchmat';

class Home_table extends Controller {
    private today: Date;
    private sort: string;
    private lib_no: string;

    constructor(table: string) {
        super(table);
        this.today = new Date();

        if(table == "notification"){
            this.sort = "ORDER BY not_no DESC";
        }
    }

    private setSQL(tab: string){
        let sql: string;

        if(tab == 'res'){
            sql = "SELECT * FROM reservation, material, member, library, book, kind WHERE reservation.mat_no = material.mat_no AND reservation.mem_no = member.mem_no AND material.kind_no = kind.kind_no AND material.book_no = book.book_no AND material.lib_no = library.lib_no"
                + " AND library.lib_no = " + this.lib_no + " ORDER BY book.book_name";
        }else{
            sql = "SELECT * FROM delivery, material, member, library, book WHERE delivery.mat_no = material.mat_no AND delivery.mem_no = member.mem_no AND material.book_no = book.book_no AND material.lib_no = library.lib_no AND del_app = 2 AND del_arr_date IS NULL"
                + " AND lib_no_arr = " + this.lib_no + " ORDER BY book.book_name";
        }

        return sql;
    }

    public getNotBaner(){
        let date = this.today.getFullYear() + "-" + (this.today.getMonth() + 1) + "-" + this.today.getDate();
        return this.whereSQL("WHERE `not_op_date` <= '" + date +"' AND `not_cl_date` > '"+ date +"' " + this.sort);
    }

    public getNotList(){
        let date = this.today.getFullYear() + "-" + (this.today.getMonth() + 1) + "-" + this.today.getDate();
        return this.whereSQL("WHERE `not_op_date` <= '" + date + "' "+ this.sort);
    }

    public setOption(url, listnum: number, m_get: string){
        this.insertUrl(url);
        this.listchange(listnum);
        this.getValue(m_get);
    }

    public async getClose(lib_no: string){
        let where = "WHERE lib_no = " + lib_no;
        let result = await this.whereSQL(where);
        return result[0]['lib_close'];
    }

    public async makeBoard(tab: string, lib_no: string){
        let result: string[];
        let sql: string;
        let total_cnt: number;

        this.lib_no = lib_no;
        sql = this.setSQL(tab);
        result = await this.joinSQL(sql);
        total_cnt = result.length;

        return this.makePage(total_cnt, sql, false);
    }

    public getDate(){
        return this.today;
    }
}

function booknumber(row: string[], index: number): string{
    let booksymbol: string;

    if(row[index]['kind_no'] != null && row[index]['mat_symbol'] != null){
        booksymbol = row[index]['kind_no'] + "-" + row[index]['mat_symbol'];
        if(row[index]['mat_many'] != 0){
            booksymbol += booksymbol + "=" + row[index]['mat_many'];
        }

        if(row['mat_overlap'] != 'c.1'){
            booksymbol += booksymbol + "=" + row[index]['mat_overlap'];
        }
    }

    return booksymbol;
}

function makeCard(row: string[]): JSX.Element[] {
    var card: JSX.Element[] = [];
    for(let i = 0; i < row.length; i++){
        let booksymbol = booknumber(row, i);
        card.push(
            <div className="card">
                <img src={row[i]['book_url']} className='card-img-top' alt={row[i]['book_name']}/>
                <div className="card-body">
                    <h5 className="card-title">{row[i]['book_name']}</h5>
                    <p className="card-text">
                        저자 {row[i]['book_author']}<br/>
                        출판사 {row[i]['book_publish']}<br/>
                        발행년도 {row[i]['book_year']}<br/>
                        소장기관 {row[i]['lib_name']}<br/>
                        청구기호 {booksymbol}<br/>
                    </p>
                </div>
            </div>
        );
    }
    return card;
}

async function holiday(lib_no: string){
    let CDate: Date = new Date();
    let rest: number = 5;
    let lib = new Home_table('library');
    if(lib_no != '1'){
        rest = await lib.getClose(lib_no);
    }
}

export default async function home(props){
    const url = props.searchParams;
    var result: string[];
    var state = getCookie("state", {cookies});
    var not = new Home_table('notification');
    var mat = new Home_table('material');
    var not_slider;
    var not_board;
    var cnt = 1;
    var lib_man = new Combobox_Manager("library", "lib_no", "", true);
    var lib_data: string[][];
    var option = [];
    var select_option = [];
    
    await lib_man.getFetch();

    if(state == null){
        state = '2';
    }

    //도서관 정보
    var lib_no = '1';
    if(url.no != null){
        lib_no = url.no; 
    }

    lib_data = lib_man.result_call();
    for(let i = 0; i < lib_data.length; i++){
        option.push(<option value={lib_data[i][0]}>{lib_data[i][1]}</option>);
    }
    for(let i = 1; i < lib_data.length; i++){
        var m_url = "/?no=" + lib_data[i][0]
        select_option.push(<option value={m_url}>{lib_data[i][1]}</option>);
    }

    if(state != '1'){
        //슬라이드랑 공지사항 게시판
        result = await not.getNotBaner();
        not_slider = [];
        for(let i = 0; i < result.length; i++){
            let m_url = "/not/addupdate?not_no=" + result[i]['not_no'];
            not_slider.push(<div><a href={m_url}><img src={result[i]['not_ban_url']} alt="" /></a></div>);
        }

        result = await not.getNotList();
        not_board = [];
        for(let i = 0; i < result.length; i++){
            let m_url = "/not/addupdate?not_no=" + result[i]['not_no'];
            let m_date = result[i]['not_op_date'].slice(0, 10);
            not_board.push(<div id="div_row"><a className="http" href={m_url}>{cnt} {result[i]['not_name']} {m_date}</a></div>);
            cnt++;
        }

        return (
            <>
            <Searchmat option={option}/>
            <div className="main_context">
                <div className="slide slide_wrap">
                    {not_slider}
                    <div className="slide_tool">
                        <div className="slide_prev_button slide_button"></div>
                        <div className="slide_next_button slide_button"></div>
                    </div>
                    <ul className="slide_pagination"></ul>
                </div>
                <div className="board">
                    <h3>공지사항</h3>
                    <fieldset id="fieldset_row">
                        {not_board}
                    </fieldset>
                </div>
            </div>
            <div className="quickmenu">
                <div id="context">
                    <h2>자주찾는 메뉴</h2>
                    <h5>필요한 정보를<br/>
                        빠르게 찾아보세요.</h5>
                </div>
                <div className="quick" id="menu1">
                    <a href="/not/list">
                        <img src="/img/icon/icon3.png" alt=""/>
                    </a>
                    <h6>공지사항</h6>
                </div>
                <div className="quick" id="menu2">
                    <a href="/lib/list">
                        <img src="/img/icon/icon10.png" alt=""/>
                    </a>
                    <h6>도서관</h6>
                </div>
                <div className="quick" id="menu3">
                    <a href="/len/memLent">
                        <img src="/img/icon/icon6.png" alt=""/>
                    </a>
                    <h6>대출중도서</h6>
                </div>
                <div className="quick" id="menu4">
                    <a href="/res/list">
                        <img src="/img/icon/icon4.png" alt=""/>
                    </a>
                    <h6>예약내역</h6>
                </div>
                <div className="quick" id="menu5">
                    <a href="/del/list">
                        <img src="/img/icon/icon9.png" alt=""/>
                    </a>
                    <h6>상호대차내역</h6>
                </div>
            </div>
            <Calender cal_option={select_option} value={lib_no}/>
            </>
        );
    }
    else{
        var m_get: string;
        var url_del: string;
        var url_res: string;
        var result: string[];
        var cardlist: JSX.Element[];
        var page: JSX.Element;
        var tab: string = 'del';

        if(url.tab != null){
           tab = url.tab;
        }

        m_get = "&lib_no"+lib_no+"&tab="+tab;
        url_del = "/?lib_no=" + lib_no + "&tab=del";
        url_res = "/?lib_no=" + lib_no + "&tab=res";
        mat.setOption(url, 4, m_get);
        page = await mat.makeBoard(tab, lib_no);
        result = mat.getResult();

        if(result != null){
            cnt = result.length;
            cardlist = makeCard(result);
        }

        return(
            <>
            <h2>자주찾는 메뉴</h2>
            <div className="quickmenu">
                <div className="quick" id="menu1">
                    <a href="/not/list">
                        <img src="/img/icon/icon3.png" alt=""/>
                    </a>
                    <h6>공지사항관리</h6>
                </div>
                <div className="quick" id="menu2">
                    <a href="/not/addupdate">
                        <img src="/img/icon/icon11.png" alt=""/>
                    </a>
                    <h6>공지사항추가</h6>
                </div>
                <div className="quick" id="menu3">
                    <a href="/len/addupdate">
                        <img src="/img/icon/icon4.png" alt=""/>
                    </a>
                    <h6>대출추가</h6>
                </div>
                <div className="quick" id="menu4">
                    <a href="/len/returnLent">
                        <img src="/img/icon/icon7.png" alt=""/>
                    </a>
                    <h6>반납추가</h6>
                </div>
                <div className="quick" id="menu5">
                    <a href="/etc/plalist">
                        <img src="/img/icon/icon8.png" alt=""/>
                    </a>
                    <h6>대출장소관리</h6>
                </div>
            </div>
            <div className="quickmenu">
                <div className="quick" id="menu6">
                    <a href="/del/aprelist">
                        <img src="/img/icon/icon2.png" alt="" />
                    </a>
                    <div className="long"><h6>상호대차승인거절</h6></div>
                </div>
                <div className="quick" id="menu7">
                    <a href="/del/addlist">
                            <img src="/img/icon/icon9.png" alt="" />
                    </a>
                    <div className="long"><h6>상호대차도착일추가</h6></div>
                </div>
                <div className="quick" id="menu8">
                    <a href="/mat/addupdate">
                        <img src="/img/icon/icon1.png" alt="" />
                    </a>
                    <h6>자료추가</h6>
                </div>
                <div className="quick" id="menu9">
                    <a href="/etc/duelist">
                        <img src="/img/icon/icon12.png" alt=""/>
                    </a>
                    <h6>연체관리</h6>
                </div>
                <div className="quick" id="menu10">
                    <a href="/member/list">
                            <img src="/img/icon/icon5.png" alt=""/>
                    </a>
                    <h6>회원관리</h6>
                </div>
            </div>
            <div className="blank"></div>
            <div className="list_head">
                <Libselect lib_option={select_option} value={lib_no}/>
            </div>
            <div className="list_title">
                <div className="list_click">
                    <a href={url_del}><h2>반송도서</h2></a>
                    <a href={url_res}><h2>예약도서</h2></a>
                </div>
                <h4>총{cnt}권</h4>
            </div>
            <div className="booklist">
                {cardlist}
                {page}
            </div>
            </>
        )
    }
}