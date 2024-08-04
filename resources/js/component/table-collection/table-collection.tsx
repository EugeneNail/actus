import "./table-collection.sass"
import {default as TableCollectionModel} from "../../model/table-collection";
import React from "react";
import TableActivity from "../table-activity/table-activity";


type Props = {
    collection: TableCollectionModel
}

export default function TableCollection({collection}: Props) {
    return (
        <div className="table-collection">
            <div className="table-collection__name">
                Шкала:  {collection.name}
            </div>
            <div className="table-collection__activities">
                {collection.activities && collection.activities.length > 0 && collection.activities.map(activity =>
                    <TableActivity key={activity.name} color={collection.color} activity={activity}/>
                )}
            </div>
        </div>
    );
}
