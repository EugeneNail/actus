import React from "react";
import "./goal-completion.sass";
import Icon8 from "@/component/icon8/icon8";
import classNames from "classnames";
import {GoalCompletionModel} from "@/component/goal-completion/goal-completion";

type Props = {
    goal: GoalCompletionModel,
    index: number
}

export default function GoalCompletionItem({goal, index}: Props) {

    function selectColor(): string {
        if (goal.completionRate >= 80) {
            return '#8CB369';
        }

        if (80 > goal.completionRate && goal.completionRate >= 60) {
            return '#FFB140';
        }

        if (60 > goal.completionRate && goal.completionRate >= 40) {
            return '#4381C1';
        }

        if (40 > goal.completionRate && goal.completionRate >= 20) {
            return '#FE5D26';
        }

        if (20 > goal.completionRate) {
            return '#D33F49';
        }
    }

    return (
        <div className="goal-completion-item">
            <div className="goal-completion-item__circle-outer" style={{background: `conic-gradient(${selectColor()} ${goal.completionRate}%, #fcfcfc 0)`}}>
                <div className="goal-completion-item__circle-inner">
                    <Icon8 className="goal-completion-item__icon" id={goal.icon}/>
                </div>
            </div>
            <p className="goal-completion-item__value">{goal.completionRate}%</p>
        </div>
    )
}
