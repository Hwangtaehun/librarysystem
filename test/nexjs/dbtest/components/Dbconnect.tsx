import { createPool } from 'mysql2'

const pool = createPool({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: 3306,
})

pool.getConnection((err, conn) => {
    if (err) console.log('fail connected')
    else console.log('Connected')
    conn.release()
})

const PDO = (sql: string, arrParams: any) => {
    return new Promise((resolve, reject) => {
        try {
            pool.query(sql, arrParams, (err, data) => {
                if (err) {
                    console.log('Error in executing the query')
                    reject(err)
                }
                resolve(data)
            })
        } catch (err) {
            reject(err)
        }
    })
}

export default PDO