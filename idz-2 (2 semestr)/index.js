import express from "express";
import http from "http";
import path from "path";
import io from "socket.io";
import mysql from "mysql2/promise";

const connectionConfig = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'lb_pdo_rent_2',
};

async function createConnection() {
    return await mysql.createConnection(connectionConfig);
}

const app = express();
const server = http.createServer(app);
const ioServer = io(server);

const port = 3000;

const INDEX_NAME = './index.html';

app.get('/', (_req, res) => {
    res.sendFile(path.resolve(INDEX_NAME));
});

ioServer.on('connection', (socket) => {
    socket.on('get_vendors', async () => {
        const connection = await createConnection();
        const [rows] = await connection.query(
            'SELECT ID_Vendors, Name FROM vendors'
        );

        ioServer.emit('vendors_list', rows);
    });

    socket.on('sum_query', async (date) => {
        const connection = await createConnection();
        const [rows] = await connection.query(
            'SELECT SUM(Cost) AS `Total Income` FROM `rent` WHERE `Date_start` <= ?',
            [String(date)]
        );

        const totalIncome = rows[0]['Total Income'] || 0;
        ioServer.emit('sum_result', `Sum: ${Math.round(totalIncome * 100) / 100}`);
    });

    socket.on('car_by_vendor', async (vendorId) => {
        const connection = await createConnection();
        const [rows] = await connection.query(
            'SELECT * FROM cars WHERE FID_Vendors = ?',
            [String(vendorId)]
        );

        ioServer.emit('car_list', rows);
    });

    socket.on('free_car_query', async (date, time) => {
        const connection = await createConnection();
        const [rows] = await connection.query(
            'SELECT * FROM cars WHERE ID_Cars NOT IN (SELECT FID_Car FROM rent WHERE ? BETWEEN Date_start AND Date_end AND ? <= Time_end)',
            [String(date), String(time)]
        );

        ioServer.emit('free_car_result', rows);
    });
});

server.listen(port, () => {
    console.log(`Server work on ${port}`);
});
