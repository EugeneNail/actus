import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import TableCollection from "../../model/table-collection";
import TableStatistics from "../../component/table-statistics/table-statistics";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";
import MoodChart from "../../component/mood-chart/mood-chart";
import FrequentActivities from "../../component/frequent-activities/frequent-activities";
import {FrequentActivity} from "../../model/frequent-activity";
import WeightChart from "../../component/weight-chart/weight-chart";
import SleeptimeChart from "../../component/sleeptime-chart/sleeptime-chart";

type Props = {
    table: TableCollection[]
    mood: {
        band: MoodBandData,
        chart: number[]
    },
    frequency: {
        month: FrequentActivity[],
        year: FrequentActivity[]
    },
    weightChart: number[],
    sleeptimeChart: number[]
}

export default withLayout(Index)
function Index({table, mood, frequency, sleeptimeChart, weightChart}: Props) {
    return (
        <div className="statistics-page">
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mood.band}/>
                <MoodChart values={mood.chart}/>
                <SleeptimeChart values={sleeptimeChart}/>
                <WeightChart values={weightChart} />
                {frequency.month.length > 0 && <FrequentActivities type="month" activities={frequency.month}/>}
                {frequency.year.length > 0 && <FrequentActivities type="year" activities={frequency.year}/>}
                <TableStatistics data={table}/>
            </div>
        </div>
    );
}
