import { getSession } from "./session";

export class menu{
    public state;
    private menus: string[][][];

    public constructor(){
        var session = JSON.stringify(getSession());
        var data = JSON.parse(session);

        if(data.state != null){
            this.state = data.state;
        }else{
            this.state = '2';
        }

        if(this.state == '1'){
            this.menus = [[['공지사항추가', '/not/addupdate'], ['공지사항관리', '/not/list']],
                          [['책추가', '/book/addupdate'], ['책관리', '/book/list']],
                          [['종류추가', '/kind/addupdate'], ['종류관리', '/kind/list']],
                          [['도서관추가', '/lib/addupdate'], ['도서관관리', '/lib/list']],
                          [['자료추가', '/mat/addupdate'], ['자료관리', '/mat/list']],
                          [['대출추가', '/len/addupdate'], ['반납추가', '/len/returnlist'], ['대출관리', '/len/list'], ['대출장소관리', '/etc/plalist']],
                          [['상호대차승인거절', '/del/aprelist'],['상호대차도착일추가', '/del/addlist'],['상호대차완료내역', '/del/completelist'],['상호대차관리', '/del/list']],
                          [['회원관리', '/member/list'], ['예약관리', '/res/list'], ['연체관리', '/etc/duelist']]
                         ];
        }else{
            var url = '/member/logalert';
            this.menus = [[['대출중도서', url], ['모든대출내역', url], ['예약내역', url], ['상호대차내역', url]],
                          [['회원정보수정', url], ['회원탈퇴', url]]];

            if(data.no != null){
                let mem_no = data.no;
                this.menus[0][0][1] = '/len/memlist';                
                this.menus[0][1][1] = '/len/memAlllist';                
                this.menus[0][2][1] = '/res/list';                
                this.menus[0][3][1] = '/del/list';                
                this.menus[1][0][1] = '/member/addupdate?mem_no=' + mem_no;               
                this.menus[1][1][1] = '/member/memdel?mem_no=' + mem_no;
            }
        }
    }

    public makehtml(menu: string): string{
        var m_script: string;
        for (let i = 0; i < this.menus[menu].length ; i++) { 
            let m_url = this.menus[menu][i][1];
            let m_title = this.menus[menu][i][0];
            m_script = "<li><a class='dropdown-item' href='" + m_url + "'>" + m_title + "</a></li>";
        }
        return m_script;
    }
}
