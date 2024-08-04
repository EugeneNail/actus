import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import TableCollection from "../../model/table-collection";
import TableStatistics from "../../component/table-statistics/table-statistics";
import MoodBand from "../../component/mood-band/mood-band";

type Props = {
    table: TableCollection[]
    mood: {band: number[]}
}

export default withLayout(Index)
function Index({table}: Props) {
    const mockedPercentages = [33.33, 16.09, 21.21, 19.8, 9.57];

    return (
        <div className="statistics-page">
            <div className="statistics-page__statistics wrapped">
                <MoodBand values={mockedPercentages}/>
                <TableStatistics data={table}/>
            </div>
        </div>
    );
}
