import PDO from "../components/includes/Dbconnect"

export default async function Index(){
    const sql = 'select * from book'
    const data = await PDO(sql, '')
    const getdata = JSON.parse(JSON.stringify(data))
    // console.log(getdata)
    // var string = getdata[1]['book_name'] + getdata[1]['book_year']
    // console.log(getdata.length);
    getdata.forEach(function (row) {
        console.log(row['book_name']);
    });

    return <h1>Hello NextJs</h1>
}