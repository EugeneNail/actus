import React from "react"
import Goal from "@/model/goal";
import Icon8 from "@/component/icon8/icon8";
import "./card-goal.sass"

type Props = {
    goal: Goal
}

export default function CardGoal({goal} : Props) {
    return (
        <div className="card-goal">
            <Icon8 className='card-goal__icon' id={goal.icon}/>
        </div>
    )
}
