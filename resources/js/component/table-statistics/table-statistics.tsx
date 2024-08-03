import "./table-statistics.sass"
import React from "react";
import {default as TableCollectionModel} from "../../model/table-collection";
import TableCollection from "../table-collection/table-collection";

type Props = {
    data: TableCollectionModel[]
}

export default function TableStatistics({data}: Props) {
    return (
        <div className="table-statistics">
            {data && data.length > 0 && data.map(collection =>
                <TableCollection key={collection.name} collection={collection}/>
            )}
        </div>
    );
}
