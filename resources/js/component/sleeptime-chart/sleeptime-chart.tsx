import "./sleeptime-chart.sass"
import React from "react";
import {Color} from "../../model/color";
import LineChart from "../line-chart/line-chart";

type Props = {
    values: number[]
};

export default function SleeptimeChart({values}: Props) {
    return (
        <div className="sleeptime-chart">
            <p className="mood-chart__label">Динамика Сна</p>
            <LineChart className='sleeptime-chart__canvas' values={values} color={Color.Blue} rows={5} decimalPlaces={1}/>
        </div>
    )
}
