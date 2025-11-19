// import axios from 'axios'
//
// const API_BASE = '/local/api/dev/backend/index.php'
//
// export const reportsApi = {
//     // Получить всех сотрудников
//     async getEmployees() {
//         const response = await axios.get(API_BASE, {
//             params: { resource: 'employees' }
//         })
//         return response.data.data
//     },
//
//     // Получить одного сотрудника
//     async getEmployee(id) {
//         const response = await axios.get(API_BASE, {
//             params: { resource: 'employees', id }
//         })
//         return response.data.data
//     },
//
//     // Получить статистику
//     async getStats() {
//         const response = await axios.get(API_BASE, {
//             params: { resource: 'stats' }
//         })
//         return response.data.data
//     }
// }