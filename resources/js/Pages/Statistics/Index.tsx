import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import TableCollection from "../../model/table-collection";
import TableStatistics from "../../component/table-statistics/table-statistics";
import MoodBand from "../../component/mood-band/mood-band";
import MoodBandData from "../../model/mood-band-data";

type Props = {
    table: TableCollection[]
    mood: {
        band: MoodBandData
    }
}

export default withLayout(Index)
function Index({table, mood}: Props) {
    return (
        <div className="statistics-page">
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mood.band}/>
                <TableStatistics data={table}/>
            </div>
        </div>
    );
}
