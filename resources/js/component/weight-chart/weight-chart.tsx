import "./weight-chart.sass"
import React from "react";
import {Color} from "../../model/color";
import LineChart from "../line-chart/line-chart";

type Props = {
    values: number[]
};

export default function WeightChart({values}: Props) {
    return (
        <div className="weight-chart">
            <p className="mood-chart__label">Динамика Веса</p>
            <LineChart className='weight-chart__canvas' values={values} color={Color.Orange} rows={6} decimalPlaces={1}/>
        </div>
    )
}
