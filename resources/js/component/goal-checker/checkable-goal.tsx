import "./goal-checker.sass"
import React from "react";
import Goal from "../../model/goal" ;
import Icon8 from "../icon8/icon8";
import classNames from "classnames";
import Icon from "../icon/icon";

type Props = {
    goal: Goal
    checked: boolean
    completion: number
    toggle: (id: number) => void
}

export default function CheckableGoal({goal, toggle, completion, checked}: Props) {
    function formatCompletion(completion: number): string {
        if (completion >= 28 || completion == -1) {
            return 'More than a month ago'
        }

        if (completion >= 21) {
            return 'Three weeks ago'
        }

        if (completion >= 14) {
            return 'Two weeks ago'
        }

        if (completion >= 7) {
            return 'A week ago'
        }

        if (completion >= 2 && completion <= 6) {
            return completion + ' days ago'
        }

        if (completion == 1) {
            return 'Yesterday'
        }

        return completion + ' days ago';
    }

    return (
        <div className="checkable-goal" onClick={() => toggle(goal.id)}>
            <div className={classNames("checkable-goal__checkbox", {checked: checked})}>
                <Icon8 className={classNames("checkable-goal__icon", {checked: checked})} id={goal.icon}/>
                <Icon name='check' bold className={classNames("checkable-goal__checkmark", {checked: checked})}/>
            </div>
            <div className="checkable-goal__labels">
                <p className={classNames("checkable-goal__name", {checked: checked})}>{goal.name}</p>
                {completion != 0 && !checked &&
                    <p className="checkable-goal__days-ago">{formatCompletion(completion)}</p>
                }
            </div>
        </div>
    )
}
