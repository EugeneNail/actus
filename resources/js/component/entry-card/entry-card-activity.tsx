import "./entry-card.sass"
import Icon8 from "../icon8/icon8";
import React from "react";
import Activity from "../../model/activity";

type Props = {
    activity: Activity
}

export default function EntryCardActivity({activity}: Props) {
    return (
        <div className="entry-card-activity">
            <Icon8 className="entry-card-activity__icon" id={activity.icon}/>
            <p className="entry-card-activity__name">{activity.name}</p>
        </div>
    )
}
