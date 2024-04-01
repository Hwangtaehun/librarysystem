import Script from 'next/script'
import { Controller } from '../components/Controller'

class Home_table extends Controller {
    constructor(table: string) {
        super(table);
    }

    public getLib_info(no: number): string[]{
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

export default async function home(){
    var lib = new Home_table('library');
    var not = new Home_table('notification');
    return <h1>Hello NextJs</h1>
}