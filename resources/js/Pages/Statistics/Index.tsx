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

type Props = {
    table: TableCollection[]
    mood: {
        band: MoodBandData,
        chart: number[]
    },
    frequency: FrequentActivity[]
}

export default withLayout(Index)
function Index({table, mood, frequency}: Props) {

    console.log(frequency)
    return (
        <div className="statistics-page">
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mood.band}/>
                <MoodChart values={mood.chart}/>
                {frequency && frequency.length > 0 && <FrequentActivities activities={frequency}/>}
                <TableStatistics data={table}/>
            </div>
        </div>
    );
}
