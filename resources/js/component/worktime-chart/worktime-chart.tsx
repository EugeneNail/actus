import "./worktime-chart.sass"
import React from "react";
import {Color} from "../../model/color";
import LineChart from "../line-chart/line-chart";

type Props = {
    values: number[]
};

export default function WorktimeChart({values}: Props) {
    return (
        <div className="worktime-chart">
            <p className="mood-chart__label">Динамика Работы</p>
            <LineChart className='worktime-chart__canvas' values={values} color={Color.Blue} rows={6} decimalPlaces={1}/>
        </div>
    )
}
