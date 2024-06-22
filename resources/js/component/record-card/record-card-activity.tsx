import "./record-card.sass"
import ShortActivity from "../../model/short-activity";
import Icon8 from "../icon8/icon8";
import React from "react";

type Props = {
    activity: ShortActivity
}

export default function RecordCardActivity({activity}: Props) {
    return (
        <div className="record-card-activity">
            <Icon8 className="record-card-activity__icon" id={activity.icon}/>
            <p className="record-card-activity__name">{activity.name}</p>
        </div>
    )
}
