import "./month-carousel.sass"
import Month from "../../model/month";
import React, {useState} from "react";
import classNames from "classnames";
import {router} from "@inertiajs/react";
import Icon from "../icon/icon";
import {MonthNames} from "@/model/month-names";

type Props = {
    months: Month[]
}

export default function MonthCarousel({months}: Props) {
    const date = new Date()
    const params = new URLSearchParams(window.location.search)
    const month = Number(params.get('month')) ?? date.getMonth() + 1
    const year = Number(params.get('year')) ?? date.getFullYear()
    const currentMonth = months.filter(item => item.month == month && item.year == year)[0] ?? months[0]


    function getCurrentIndex(): number {
        return months.findIndex(item => item.month == month && item.year == year)
    }


    function goTo(direction: number) {
        let targetIndex = getCurrentIndex() + direction

        if (targetIndex < 0) {
            targetIndex = 0;
        }

        if (targetIndex >= months.length) {
            targetIndex = months.length
        }

        router.get(`/entries?month=${months[targetIndex].month}&year=${months[targetIndex].year}`)
    }


    return (
        <div className="month-carousel">
            {getCurrentIndex() > 0 && <Icon className="month-carousel__button left" name="arrow_back_ios" onClick={() => goTo(-1)}/>}
            <p className="month-carousel__title">
                {MonthNames[currentMonth.month]} {currentMonth.year}
                , {currentMonth.entries} of {currentMonth.days}</p>
            {getCurrentIndex() < months.length - 1 && <Icon className="month-carousel__button right" name="arrow_forward_ios" onClick={() => goTo(+1)}/>}
        </div>
    )
}
