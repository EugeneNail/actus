import Transaction from "@/model/transaction";

export default class DateTransactions {
    day: number = 0
    month: number = 0
    year: number = 0
    total: number = 0
    transactions: Transaction[]
}
