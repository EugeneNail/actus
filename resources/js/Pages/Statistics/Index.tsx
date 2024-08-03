import "./index.sass"
import withLayout from "../../Layout/default-layout";
import React from "react";
import TableCollection from "../../model/table-collection";
import TableStatistics from "../../component/table-statistics/table-statistics";

type Props = {
    table: TableCollection[]
}

export default withLayout(Index)
function Index({table}: Props) {
    return (
        <div className="statistics-page page">
            <div className="statistics-page__statistics">
                <TableStatistics data={table}/>
            </div>
        </div>
    );
}
