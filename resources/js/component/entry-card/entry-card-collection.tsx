import "./entry-card.sass"
import EntryCardActivity from "./entry-card-activity";
import classNames from "classnames";
import React from "react";
import selectColor from "../../service/select-color";
import Collection from "../../model/collection";
type Props = {
    collection: Collection
}

export default function EntryCardCollection({collection}: Props) {
    return (
        <div className="entry-card-collection">
            <p className={classNames("entry-card-collection__name", selectColor(collection.color))}>{collection.name}</p>
            <div className="entry-card-collection__activities">
                {collection.activities && collection.activities.map(activity => (
                    <EntryCardActivity key={Math.random()} activity={activity}/>
                ))}
            </div>
        </div>
    )
}
