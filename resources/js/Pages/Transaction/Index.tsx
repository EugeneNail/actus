import React from "react";
import "./index.sass"
import TransactionPeriod from "@/model/transaction-period";
import {Head} from "@inertiajs/react";
import PeriodCarousel from "@/component/period-carousel/period-carousel";
import DateTransactionModel from "@/model/date-transactions";
import DateTransactions from "@/component/date-transactions/date-transactions";
import Category from "@/model/category";
import withLayout from "@/Layout/default-layout";
import TransactionChart from "@/component/transaction-chart/transaction-chart";
import Chart from "@/model/transaction/chart";
import Flow from "@/model/transaction/flow";

type Props = {
    periods: TransactionPeriod[],
    transactions: DateTransactionModel[],
    categories: { [key: number]: Category },
    chart: {
        flow: Flow,
        scales: number[]
        main: Chart
        compared: Chart
    }
}

export default withLayout(Index)
function Index({periods, transactions, categories, chart}: Props) {
    return (
        <div className="transactions-page page">
            <Head title='Transactions'/>
            <PeriodCarousel periods={periods}/>
            <div className="transactions-page__wrapper wrapped">
                <TransactionChart scales={chart.scales} main={chart.main} compared={chart.compared} flow={chart.flow}/>
                <div className="transactions-page__transactions">
                    {transactions && transactions.map(dateTransactions =>
                        <DateTransactions key={Math.random()} dateTransactions={dateTransactions} categories={categories}/>
                    )}
                </div>
            </div>


        </div>
    )
}
