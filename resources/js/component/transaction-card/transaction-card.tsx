import React from "react";
import "./transaction-card.sass"
import Transaction from "@/model/transaction";
import Icon from "@/component/icon/icon";
import Category from "@/model/category";
import classNames from "classnames";
import {router} from "@inertiajs/react";

type Props = {
    transaction: Transaction
    categories: { [key: number]: Category }
}

export default function TransactionCard({transaction, categories}: Props) {
    const valueClassName = classNames(
        "transaction-card__value",
        {income: transaction.sign == +1},
        {outcome: transaction.sign == -1}
    );

    const iconClassName = classNames(
        "transaction-card__icon",
        {income: transaction.sign == +1},
        {outcome: transaction.sign == -1}
    );

    return (
        <div className="transaction-card" onClick={() => router.get(`/transactions/${transaction.id}`)}>
            <Icon className={iconClassName} name={categories[transaction.category].icon}/>
            <p className="transaction-card__category">{categories[transaction.category].name}</p>
            <p className="transaction-card__description">{transaction.description}</p>
            <p className={valueClassName}>{(transaction.sign == +1 ? '+' : '-') + transaction.value.toFixed(2)}</p>
        </div>
    )
}
