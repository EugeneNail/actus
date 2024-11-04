import "./frequent-activities.sass"
import React from "react";
import {FrequentActivity as ModelFrequentActivity} from "../../model/frequent-activity";
import FrequentActivity from "./frequent-activity";

type Props = {
    activities: ModelFrequentActivity[],
    type: "month" | "year"
}

export default function FrequentActivities({activities, type}: Props) {
    return (
        <div className="frequent-activities">
            <p className="frequent-activities__label">Частые Активности {type == "month" ? "(месяц)" : "(год)"}</p>
            <div className="frequent-activities__activities">
                {activities.map((activity, index) => (
                    <FrequentActivity key={activity.name + activity.icon} activity={activity} index={index + 1}/>
                ))}
            </div>
        </div>
    )
}
