import "./goal-checker.sass"
import React from "react";
import Goal from "../../model/goal" ;
import Icon8 from "../icon8/icon8";
import classNames from "classnames";
import Icon from "../icon/icon";

type Props = {
    goal: Goal
    checked: boolean
    toggle: (id: number) => void
}

export default function CheckableGoal({goal, toggle, checked}: Props) {
    return (
        <div className="checkable-goal" onClick={() => toggle(goal.id)}>
            <div className={classNames("checkable-goal__checkbox", {checked: checked})}>
                <Icon8 className={classNames("checkable-goal__icon", {checked: checked})} id={goal.icon}/>
                <Icon name='check' bold className={classNames("checkable-goal__checkmark", {checked: checked})}/>
            </div>
            <p className={classNames("checkable-goal__name", {checked: checked})}>{goal.name}</p>
        </div>
    )
}
