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
            return 'Более месяца назад'
        }

        if (completion >= 21) {
            return 'Три недели назад'
        }

        if (completion >= 14) {
            return 'Две недели назад'
        }

        if (completion >= 7) {
            return 'Неделю назад'
        }

        if (completion >= 3 && completion <= 4) {
            return completion + ' дня назад'
        }

        if (completion >= 5 && completion <= 6) {
            return completion + ' дней назад'
        }

        if (completion == 2) {
            return 'Позавчера'
        }

        if (completion == 1) {
            return 'Вчера'
        }

        return completion + ' дней назад';
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
