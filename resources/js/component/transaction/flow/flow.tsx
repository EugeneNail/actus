import React from "react"
import styles from "./flow.module.sass"
import FlowModel from "@/model/transaction/flow";

type Props = {
    flow: FlowModel
}

export default function Flow({flow}: Props) {
    return (
        <div className={styles.flow}>
            <p className={styles.flow__label}>Outcome</p>
            <p className={styles.flow__label}>Income</p>
            <p className={styles.flow__label}>Summary</p>
            <p className={`${styles.flow__value} ${styles.outcome}`}>{flow.outcome.toFixed(2)}</p>
            <p className={`${styles.flow__value} ${styles.income}`}>{flow.income.toFixed(2)}</p>
            <p className={styles.flow__value}>{flow.summary.toFixed(2)}</p>
        </div>
    )
}