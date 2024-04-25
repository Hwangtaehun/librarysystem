import NavDropdown from 'react-bootstrap/NavDropdown';

export class Menu{
    private state: string;
    private menus: string[][][];
    private cnt: number = 10;

    public constructor(state: string | null, no: string | null){

        if(state == null){
            state = '2';
        }else{
            this.state = state;
        }

        if(state == '1'){
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

            if(no != null){
                this.menus[0][0][1] = '/len/memlist';                
                this.menus[0][1][1] = '/len/memAlllist';                
                this.menus[0][2][1] = '/res/list';                
                this.menus[0][3][1] = '/del/list';                
                this.menus[1][0][1] = '/member/addupdate?mem_no=' + no;               
                this.menus[1][1][1] = '/member/memdel?mem_no=' + no;
            }
        }
    }

    private menu_index(menu: string): number{
        var index: number = 9;

        if(menu == '반납'){
            menu = '대출';
        }
        else if(menu == '예약' || menu == '연체'){
            menu = '기타';
        }

        if(this.state != '1'){
            if(menu == '회원'){
                menu = '기타';
            }

            switch (menu) {
                case '내서재':
                    index = 0;
                    break;
                case '내정보수정':
                    index = 1;
                    break;
            }
        }
        else{
            switch (menu) {
                case '공지사항':
                    index = 0;
                    break;
                case '책':
                    index = 1;
                    break;
                case '종류':
                    index = 2;
                    break;
                case '도서관':
                    index = 3;
                    break;
                case '자료':
                    index = 4;
                    break;
                case '대출':
                    index = 5;
                    break;
                case '상호대차':
                    index = 6;
                    break;
                case '기타':
                    index = 7;
                    break;
            }
        }

        return index;
    }

    public makehtml(menu: string): string[]{
        var result = [];
        var index = this.menu_index(menu);

        if(index == 9){
            return null;
        }

        for (let i = 0; i < this.menus[index].length ; i++) { 
            let m_url = this.menus[index][i][1];
            let m_title = this.menus[index][i][0];
            let m_id: string = this.cnt.toString();
            result.push(<li key={m_id}><a className='dropdown-item' href={m_url}>{m_title}</a></li>);
            this.cnt++;
        }
        return result;
    }

    public makeArray(menu: string): string[]{
        var result = [];
        var index = this.menu_index(menu);

        if(index == 9){
            return null;
        }

        for (let i = 0; i < this.menus[index].length ; i++) { 
            let m_url = this.menus[index][i][1];
            let m_title = this.menus[index][i][0];
            result.push(<NavDropdown.Item href={m_url}>{ m_title }</NavDropdown.Item>);
        }
        return result;
    }

    public array(menu: string): string[][]{
        var index = this.menu_index(menu);
        return this.menus[index];
    }

    public get_menus(){
        return this.menus;
    }
}
