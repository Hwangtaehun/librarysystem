import { getCookie } from 'cookies-next';
import { Controller } from '../../components/Controller'
import { Combobox_Manager } from '../../components/includes/Combobox_Manager'
import Calender from './calendar';

class Home_table extends Controller {
    private today: Date;
    private sort: string;

    constructor(table: string) {
        super(table);
        this.today = new Date();

        if(table == "notification"){
            this.sort = "ORDER BY not_no DESC";
        }
    }

    public async getLib_info(no: number){
        return await this.selectID(no);
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
}

export default async function home(props){
    const url = props.searchParams;
    var result: string[];
    var state = getCookie("state");
    var lib = new Home_table('library');
    var not = new Home_table('notification');
    var not_slider;
    var not_board;
    var cnt = 1;
    var rest: string;
    var lib_man = new Combobox_Manager("library", "lib_no", "", true);
    var lib_data: string[][];
    var option = [];
    var cal_option = [];
    
    await lib_man.getFetch();

    if(state == null){
        state = '2';
    }

    //도서관 정보
    var lib_no = '1';
    if(url.no != null){
        lib_no = url.no;
    }
    result = await lib.getLib_info(+lib_no);


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
        not_board.push(<div id="div_row"><a className="http" href={m_url}>{cnt} {result[i]['not_name']} {result[i]['not_op_date']}</a></div>);
    }

    lib_data = lib_man.result_call();
    for(let i = 0; i < lib_data.length; i++){
        option.push(<option value={lib_data[i][0]}>{lib_data[i][1]}</option>);
    }
    for(let i = 1; i < lib_data.length; i++){
        var m_url = "/?no=" + lib_data[i][0]
        if(lib_no == lib_data[i][0]){
            cal_option.push(<option value={m_url} selected>{lib_data[i][1]}</option>);
        }else{
            cal_option.push(<option value={m_url}>{lib_data[i][1]}</option>);
        }
    }

    if(state != '1'){
        return (
            <>
            <form action="/mat/search" method="post">
                <div className="search">
                    <select id="s1" name="lib_search">
                        {option}
                    </select>
                    <input type="text" name="user_search" id="id_search" value="" placeholder="도서 이름을 입력해주세요." />
                    <button type="submit" className="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </form>
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
            <Calender cal_option={cal_option}/>
            </>
        );
    }
    else{

    }
}