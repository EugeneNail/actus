import React from "react";
import "./date-transactions.sass"
import DateTransactionsModel from "@/model/date-transactions";
import TransactionCard from "@/component/transaction-card/transaction-card";
import Category from "@/model/category";

type Props = {
    dateTransactions: DateTransactionsModel
    categories: { [key: number]: Category }
}

export default function DateTransactions({dateTransactions, categories}: Props) {
    const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]

    const weekday = new Date(`${dateTransactions.year}-${dateTransactions.month}-${dateTransactions.day}`).getDay()
    const month = `${monthNames[dateTransactions.month - 1]} ${dateTransactions.year}`

    return (
        <div className="date-transactions">
            <div className="date-transactions__header">
                <p className="date-transactions__day">{dateTransactions.day.toString().padStart(2, '0')}</p>
                <p className="date-transactions__weekday">{weekdays[weekday]}</p>
                <p className="date-transactions__date">{month}</p>
                <p className="date-transactions__total">{dateTransactions.total.toFixed(2)}</p>
            </div>
            <div className="date-transactions__transactions">
                {dateTransactions.transactions && dateTransactions.transactions.map(transaction =>
                    <TransactionCard key={Math.random()} transaction={transaction} categories={categories}/>
                )}
            </div>
        </div>
    )
}
