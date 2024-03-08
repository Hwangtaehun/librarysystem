import PDO from "../components/Dbconnect"

export default async function Index(){
    const sql = 'select * from book'
    const data = await PDO(sql, '')
    const getdata = JSON.parse(JSON.stringify(data))
    console.log(getdata)
    return <h1>Hello NextJs</h1>
}