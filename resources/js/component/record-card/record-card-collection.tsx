import "./record-card.sass"
import ShortCollection from "../../model/short-collection";
import RecordCardActivity from "./record-card-activity";
import classNames from "classnames";
import React from "react";
import selectColor from "../../service/select-color";
type Props = {
    collection: ShortCollection
}

export default function RecordCardCollection({collection}: Props) {
    return (
        <div className="record-card-collection">
            <p className={classNames("record-card-collection__name", selectColor(collection.color))}>{collection.name}</p>
            <div className="record-card-collection__activities">
                {collection.activities && collection.activities.map(activity => (
                    <RecordCardActivity key={Math.random()} activity={activity}/>
                ))}
            </div>
        </div>
    )
}
