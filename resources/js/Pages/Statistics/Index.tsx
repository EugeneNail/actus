import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import TableCollection from "../../model/table-collection";
import TableStatistics from "../../component/table-statistics/table-statistics";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";
import MoodChart from "../../component/mood-chart/mood-chart";

type Props = {
    table: TableCollection[]
    mood: {
        band: MoodBandData,
        chart: number[]
    }
}

export default withLayout(Index)
function Index({table, mood}: Props) {
    return (
        <div className="statistics-page">
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mood.band}/>
                <MoodChart values={mood.chart}/>
                <TableStatistics data={table}/>
            </div>
        </div>
    );
}
