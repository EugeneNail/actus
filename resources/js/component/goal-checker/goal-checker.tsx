import "./goal-checker.sass"
import React from "react";
import Goal from "../../model/goal";
import CheckableGoal from "./checkable-goal";

type Props = {
    goals: Goal[]
    completedGoals: number[]
    goalCompletions: {[key:number]: number}
    toggleGoal: (id: number) => void
}

export default function GoalChecker({goals, completedGoals, goalCompletions, toggleGoal}: Props) {
    return (
        <div className="goal-checker">
            <div className="goal-checker__goals">
                {goals.map(goal => <CheckableGoal key={goal.id} goal={goal} completion={goalCompletions[goal.id]} toggle={toggleGoal} checked={completedGoals.includes(goal.id)}/>)}
            </div>
        </div>
    )
}
