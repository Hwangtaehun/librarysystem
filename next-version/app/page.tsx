import { Controller } from '../components/Controller'
import PDO from "../components/includes/Dbconnect";

class Home_table extends Controller {
    constructor(table: string) {
        super(table);
    }

    public getLib_info(no: number){
        return this.selectID(no);
    }

    public getNotlist(): string[]{
        return this.selectAll();
    }

    public setOption(url, listnum: number, m_get: string){
        this.insertUrl(url);
        this.listchange(listnum);
        this.getValue(m_get);
    }
}

export default async function home(props){
    const url = props.searchParams;
    var lib = new Home_table('library');
    var not = new Home_table('notification');

    var lib_no = '1';
    if(url.lib_no != null){
        lib_no = url.lib_no;
    }

    lib.getLib_info(+lib_no).then(value => console.log(value));

    return (<h1>Hello NextJs</h1>);
}