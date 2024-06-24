import "./activity-card.sass"
import Activity from "../../model/activity";
import React from "react";
import Icon8 from "../icon8/icon8";
import {router} from "@inertiajs/react";

type Props ={
    collectionId: number
    activity: Activity
}

export default function ActivityCard({activity, collectionId}: Props) {
    return (
        <div className="activity-card" onClick={() => router.get(`/collections/${collectionId}/activities/${activity.id}`)}>
            <div className="activity-card__icon-container">
                <Icon8 id={activity.icon} className="activity-card__icon"/>
            </div>
            <p className="activity-card__name">{activity.name}</p>
        </div>
    )
}
