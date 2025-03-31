import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";
import MoodChart from "../../component/mood-chart/mood-chart";
import {Head} from "@inertiajs/react";
import GoalChart from "@/component/goal-chart/goal-chart";
import StatisticsLink from "@/component/statistics-link/statistics-link";
import BestWorst, {BestWorstGoalModel} from "@/component/best-worst/best-worst";

type Props = {
    mood: {
        band: MoodBandData,
        chart: number[]
    },
    goalChart: {
        plain: number
        percent: number
    }[],
    bestWorst: {
        best: BestWorstGoalModel[],
        worst: BestWorstGoalModel[],
    }
}

export default withLayout(Index)
function Index({mood, goalChart, bestWorst}: Props) {
    const period = new URLSearchParams(window.location.search).get('period')

    return (
        <div className="statistics-page">
            <Head title='Статистика'/>
            <div className="statistics-page__statistics wrapped">
                <div className="statistics-page__links">
                    <StatisticsLink to="/statistics?period=month" label="Month" type="month" period={period}/>
                    <StatisticsLink to="/statistics?period=season" label="Season" type="season" period={period}/>
                    <StatisticsLink to="/statistics?period=year" label="Year" type="year" period={period}/>
                </div>
                <MoodBand values={mood.band}/>
                {/*<MoodChart values={mood.chart} period={period}/>*/}
                {/*<GoalChart values={goalChart} period={period}/>*/}
                <BestWorst values={bestWorst}/>
            </div>
        </div>
    );
}
