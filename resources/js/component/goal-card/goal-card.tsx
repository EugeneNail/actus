import "./goal-card.sass"
import Activity from "../../model/activity";
import React from "react";
import Icon8 from "../icon8/icon8";
import {Link, router} from "@inertiajs/react";
import Goal from "../../model/goal";

type Props ={
    goal: Goal
}

export default function GoalCard({goal}: Props) {
    return (
        <Link className="goal-card" href={`/goals/${goal.id}`}>
            <div className="goal-card__icon-container">
                <Icon8 id={goal.icon} className="goal-card__icon"/>
            </div>
            <p className="goal-card__name">{goal.name}</p>
        </Link>
    )
}
