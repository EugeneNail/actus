import "./goal-checker.sass"
import React, {useState} from "react";
import Goal from "../../model/goal";
import CheckableGoal from "./checkable-goal";
import classNames from "classnames";

type Props = {
    userGoals: Goal[]
    goals: number[]
    lastGoalCompletions: {[key:number]: number}
    toggleGoal: (id: number) => void
}

export default function GoalChecker({userGoals, goals, lastGoalCompletions, toggleGoal}: Props) {
    function calculateProgressBarBackground(): string {
        const progress = goals.length / userGoals.length * 100
        return `linear-gradient(to right, #8CB369 0%, #8CB369 ${progress}%, transparent ${progress}%, transparent 100%)`
    }

    return (
        <div className="goal-checker">

            <div className="goal-checker__goals">
                {userGoals.map(goal => <CheckableGoal key={goal.id} goal={goal} completion={lastGoalCompletions[goal.id]} toggle={toggleGoal} checked={goals.includes(goal.id)}/>)}
            </div>
            <div className="goal-checker__progress-bar" style={{background: calculateProgressBarBackground()}}>
                <p className={classNames("goal-checker__progress-bar-counter", {white: goals.length / userGoals.length > 0.5})}>{goals.length} / {userGoals.length}</p>
            </div>
        </div>
    )
}
