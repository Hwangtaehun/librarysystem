import PDO from "../components/includes/Dbconnect"

export default async function home(){
    // const sql = 'select * from book'
    // const data = await PDO(sql, '')
    // const getdata: string[] = JSON.parse(JSON.stringify(data))
    // console.log(getdata)
    // var string = getdata[1]['book_name'] + getdata[1]['book_year']
    // console.log(getdata.length);
    // getdata.forEach(function (row) {
    //     console.log(row['book_name']);
    // });

    // const insert_sql = "INSERT INTO `library` SET `lib_name` = '청주가로수도서관', `lib_date` = '2021-04-29', `lib_zip` = '28383', `lib_add` = '충청북도 청주시 흥덕구 서현서로 5'";
    // PDO(insert_sql, '');
    // console.log('success');
    // const str = useSearchParams();
    // if(str.get('name') != null){
    //     var name = str.get('name');
    //     console.log();
    // }else{
    //     console.log('nothing');
    // }

    // async function handleSubmit(formData) {
    //     'use server';
    //     const arr_str = new Map();
    //     var i: number = 0;
    //     for (const key of formData.keys()) {
    //         if(i > 0){
    //             arr_str.set(key, formData.get(key));
    //         }
    //         i++;
    //         // console.log(key);
    //     }

    //     arr_str.forEach((values, key) => {
    //         console.log(key + "=" + values);
    //     });
    //     //console.log(formData.get('name'))
    // }

    // return (
    //     <><h1>Hello NextJs</h1><form action={handleSubmit}>
    //         이름: <input type="text" name="name" />
    //         나이: <input type="text" name="age" />
    //         <button type="submit">Submit</button>
    //     </form></>
    // );

    return <h1>Hello NextJs</h1>
}