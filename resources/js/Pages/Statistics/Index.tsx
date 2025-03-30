import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";
import MoodChart from "../../component/mood-chart/mood-chart";
import {Head} from "@inertiajs/react";
import GoalChart from "@/component/goal-chart/goal-chart";

type Props = {
    mood: {
        band: MoodBandData,
        chart: number[]
    },
    goalChart: {
        plain: number
        percent: number
    }[]
}

export default withLayout(Index)
function Index({mood, goalChart}: Props) {
    const period = new URLSearchParams(window.location.search).get('period')

    return (
        <div className="statistics-page">
            <Head title='Статистика'/>
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mood.band}/>
                <MoodChart values={mood.chart} period={period}/>
                <GoalChart values={goalChart} period={period}/>
            </div>
        </div>
    );
}
