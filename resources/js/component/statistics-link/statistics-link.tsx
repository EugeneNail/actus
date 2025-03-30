import "./statistics-link.sass"
import {Link} from "@inertiajs/react";
import classNames from "classnames";
import React from "react";

type Props = {
    to: string
    label: string
    period: string
    type: string
}

export default function StatisticsLink({to, label, period, type}: Props) {
    return (
        <Link className={classNames("statistics-link", {active: period == type})} href={to} >
            <p className="menu-link__label">
                {label}
            </p>
        </Link>
    )
}
