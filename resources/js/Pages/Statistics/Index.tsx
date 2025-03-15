import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";
import MoodChart from "../../component/mood-chart/mood-chart";
import {Head} from "@inertiajs/react";

type Props = {
    mood: {
        band: MoodBandData,
        chart: number[]
    },
}

export default withLayout(Index)
function Index({mood}: Props) {
    return (
        <div className="statistics-page">
            <Head title='Статистика'/>
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mood.band}/>
                <MoodChart values={mood.chart}/>
            </div>
        </div>
    );
}
