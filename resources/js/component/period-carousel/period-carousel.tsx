import "./period-carousel.sass"
import Month from "../../model/month";
import React, {useState} from "react";
import classNames from "classnames";
import {router} from "@inertiajs/react";
import Icon from "../icon/icon";
import {MonthNames} from "@/model/month-names";
import TransactionPeriod from "@/model/transaction-period";

type Props = {
    periods: TransactionPeriod[]
}

export default function PeriodCarousel({periods}: Props) {
    const params = new URLSearchParams(window.location.search)
    const from = params.get('from')
    const to = params.get('to')

    function getCurrentIndex(): number {
        return periods.findIndex(item => item.from == from && item.to == to)
    }


    function goTo(direction: number) {
        let targetIndex = getCurrentIndex() + direction

        if (targetIndex < 0) {
            targetIndex = 0;
        }

        if (targetIndex >= periods.length) {
            targetIndex = periods.length
        }

        router.get(`/transactions?from=${periods[targetIndex].from}&to=${periods[targetIndex].to}`)
    }


    function buildTitle(): string {
        const index = getCurrentIndex()
        return `${periods[index].from} -- ${periods[index].to}`
    }


    return (
        <div className="period-carousel">
            {getCurrentIndex() > 0 && <Icon className="period-carousel__button left" name="arrow_back_ios" onClick={() => goTo(-1)}/>}
            <p className="period-carousel__title">{buildTitle()}</p>
            {getCurrentIndex() < periods.length - 1 && <Icon className="period-carousel__button right" name="arrow_forward_ios" onClick={() => goTo(+1)}/>}
        </div>
    )
}
