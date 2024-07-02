import "./entry-month.sass"
import Month from "../../model/month";
import React from "react";
import classNames from "classnames";
import {router} from "@inertiajs/react";

type Props = {
    month: Month
}

const shortNames: { [key: number]: string } = {
    1: "янв",
    2: "фев",
    3: "март",
    4: "апр",
    5: "май",
    6: "июнь",
    7: "июль",
    8: "авг",
    9: "сен",
    10: "окт",
    11: "нояб",
    12: "дек",
};

export default function EntryMonth({month}: Props) {
    function getClass(): string {
        const params = new URLSearchParams(window.location.search)
        const today = new Date();
        const currentMonth = params.get('month') ?? today.getMonth() + 1
        const currentYear = params.get('year') ?? today.getFullYear()

        return classNames(
            "entry-month",
            {selected: currentMonth == month.month && currentYear == month.year}
        )
    }


    function fetchEntries() {
        router.get(`/entries?month=${month.month}&year=${month.year}`)
    }


    return (
        <div className={getClass()} id={`${month.month}-${month.year}`} onClick={fetchEntries}>
            <p className="entry-month__entries">{month.entries} / {month.days}</p>
            <p className="entry-month__name">{shortNames[month.month]}</p>
            <p className="entry-month__year">{month.year}</p>
        </div>
    )
}
