import React from "react";
import "./best-worst.sass";
import {BestWorstGoalModel} from "@/component/best-worst/best-worst";
import Icon8 from "@/component/icon8/icon8";
import classNames from "classnames";

type Props = {
    goal: BestWorstGoalModel,
    index: number
}

export default function BestWorstGoal({goal, index}: Props) {

    function selectClassName() {
        return classNames(
            "best-worst-goal__mood-star",
            {green: goal.mood >= 4.5},
            {yellow: 4.5 > goal.mood && goal.mood >= 3.5},
            {blue: 3.5 > goal.mood && goal.mood >= 2.5},
            {orange: 2.5 > goal.mood && goal.mood >= 1.5},
            {red: 1.5 > goal.mood},
        )
    }

    return (
        <div className="best-worst-goal">
            <p className="best-worst-goal__index">{index}</p>
            <div className="best-worst-goal__icon-container">
                <Icon8 className="best-worst-goal__icon" id={goal.icon}/>
            </div>
            <div className="best-worst-goal__mood">
                <div className={selectClassName()}></div>
                <p className="best-worst-goal__mood-value">{goal.mood.toFixed(1)}</p>
            </div>
        </div>
    )
}
