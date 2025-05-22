import React from "react";
import "./index.sass"
import TransactionPeriod from "@/model/transaction-period";
import {Head} from "@inertiajs/react";
import PeriodCarousel from "@/component/period-carousel/period-carousel";
import DateTransactionModel from "@/model/date-transactions";
import DateTransactions from "@/component/date-transactions/date-transactions";
import Category from "@/model/category";
import withLayout from "@/Layout/default-layout";

type Props = {
    periods: TransactionPeriod[],
    transactions: DateTransactionModel[],
    categories: { [key: number]: Category }
}
export default withLayout(Index)

function Index({periods, transactions, categories}: Props) {
    return (
        <div className="transactions-page page">
            <Head title='Transactions'/>
            <PeriodCarousel periods={periods}/>
            <div className="transactions-page__transactions">
                {transactions && transactions.map(dateTransactions =>
                    <DateTransactions dateTransactions={dateTransactions} categories={categories}/>
                )}
                {!transactions && 'No transactions'}
            </div>
        </div>
    )
}
