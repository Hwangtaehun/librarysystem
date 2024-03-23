import PDO from "../components/includes/Dbconnect"
import { WebSearch } from "../components/test/kakaoApi";

export default async function Index(){
    // const sql = 'select * from book'
    // const data = await PDO(sql, '')
    // const getdata = JSON.parse(JSON.stringify(data))
    // // console.log(getdata)
    // // var string = getdata[1]['book_name'] + getdata[1]['book_year']
    // console.log(getdata.length);

    const params = {
        query: 'Herman Melville',
        sort: 'accuracy',
        page: 1,
        size: 10,
    };

    const { data } = await WebSearch(params);
    let value = data['documents']['0']['title'].split(" - ");
    value = value[0];
    value = value.replace('<b>', '');
    value = value.replace('</b>', '');
    console.log(value);

    return <h1>Hello NextJs</h1>
}