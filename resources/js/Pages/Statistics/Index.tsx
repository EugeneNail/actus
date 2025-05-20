import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";
import MoodChart from "../../component/mood-chart/mood-chart";
import {Head} from "@inertiajs/react";
import GoalChart from "@/component/goal-chart/goal-chart";
import StatisticsLink from "@/component/statistics-link/statistics-link";
import GoalCompletion, {GoalCompletionModel} from "@/component/goal-completion/goal-completion";
import GoalHeatmap from "@/component/goal-heatmap/goal-heatmap";
import GoalHeatmapModel from "@/model/goal-heatmap";

type Props = {
    mood: {
        band: MoodBandData,
        chart: number[]
    },
    goalChart: {
        plain: number
        percent: number
    }[],
    goalCompletion: GoalCompletionModel[],
    goalHeatmap: GoalHeatmapModel[],
}

export default withLayout(Index)
function Index({mood, goalChart, goalCompletion, goalHeatmap}: Props) {
    const period = new URLSearchParams(window.location.search).get('period')

    return (
        <div className="statistics-page">
            <Head title='Statistics'/>
            <div className="statistics-page__statistics wrapped">
                <div className="statistics-page__links">
                    <StatisticsLink to="/statistics?period=month" label="Month" type="month" period={period}/>
                    <StatisticsLink to="/statistics?period=season" label="Season" type="season" period={period}/>
                    <StatisticsLink to="/statistics?period=year" label="Year" type="year" period={period}/>
                </div>
                <MoodBand values={mood.band}/>
                <MoodChart values={mood.chart} period={period}/>
                <GoalChart values={goalChart} period={period}/>
                <GoalCompletion values={goalCompletion}/>
                <GoalHeatmap data={goalHeatmap}/> 
            </div>
        </div>
    );
}
