import PDO from "../components/includes/Dbconnect"

export default async function home(){
    // const sql = 'select * from book'
    // const data = await PDO(sql, '')
    // const getdata: string[] = JSON.parse(JSON.stringify(data))
    // console.log(getdata)
    return <h1>Hello NextJs</h1>
}