import "./frequent-activities.sass"
import React from "react";
import {Icons8} from "../icon8/icons8";
import {FrequentActivity as ModelFrequentActivity}from "../../model/frequent-activity" ;
import Icon8 from "../icon8/icon8";

type Props = {
    activity: ModelFrequentActivity
    index: number
}

export default function FrequentActivity({activity, index}: Props) {
    return (
        <div className="frequent-activity">
            <p className="frequent-activity__index">{index}</p>
            <div className="frequent-activity__icon-container">
                <Icon8 className="frequent-activity__icon" id={activity.icon}/>
            </div>
            <p className="frequent-activity__name">{activity.name}</p>
            <p className="frequent-activity__count">{"x" + activity.count}</p>
        </div>
    )
}
