"use client";

import { useSearchParams } from "next/navigation"
import PDO from "../components/includes/Dbconnect"

export default async function Index(){
    const sql = 'select * from book'
    const data = await PDO(sql, '')
    const getdata: string[] = JSON.parse(JSON.stringify(data))
    // console.log(getdata)
    // var string = getdata[1]['book_name'] + getdata[1]['book_year']
    console.log(getdata.length);
    // getdata.forEach(function (row) {
    //     console.log(row['book_name']);
    // });

    // const insert_sql = "INSERT INTO `library` SET `lib_name` = '청주가로수도서관', `lib_date` = '2021-04-29', `lib_zip` = '28383', `lib_add` = '충청북도 청주시 흥덕구 서현서로 5'";
    // PDO(insert_sql, '');
    // console.log('success');
    const str = useSearchParams();
    if(str.get('name') != null){
        var name = str.get('name');
        console.log();
    }else{
        console.log('nothing');
    }

    return <h1>Hello NextJs</h1>
}