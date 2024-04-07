import { getCookie } from 'cookies-next';
import { Controller } from '../components/Controller'
import { Combobox_Manager } from '../components/includes/Combobox_Manager';

class Home_table extends Controller {
    constructor(table: string) {
        super(table);
    }

    public async getLib_info(no: number){
        return await this.selectID(no);
    }

    public getNotlist(){
        this.selectAll();
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
    var cnt = 1;
    var rest: string;
    var lib_man = new Combobox_Manager("library", "lib_no", "", true);
    var lib_data: string[][];
    
    await lib_man.getFetch();

    if(state == null){
        state = '2';
    }

    var lib_no = '1';
    if(url.lib_no != null){
        lib_no = url.lib_no;
    }

    result = await lib.getLib_info(+lib_no);
    rest = result[0]['lib_close'];

    if(rest == null){
        rest = '7';
    }

    lib_data = lib_man.result_call();
    console.log(rest);

    return (<h1>Hello NextJs</h1>);
}