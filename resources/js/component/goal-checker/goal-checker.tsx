import "./goal-checker.sass"
import React from "react";
import Goal from "../../model/goal";
import CheckableGoal from "./checkable-goal";

type Props = {
    goals: Goal[]
    completedGoals: number[]
    toggleGoal: (id: number) => void
}

export default function GoalChecker({goals, completedGoals, toggleGoal}: Props) {
    return (
        <div className="goal-checker">
            <div className="goal-checker__goals">
                {goals.map(goal => <CheckableGoal key={goal.id} goal={goal} toggle={toggleGoal} checked={completedGoals.includes(goal.id)}/>)}
            </div>
        </div>
    )
}
