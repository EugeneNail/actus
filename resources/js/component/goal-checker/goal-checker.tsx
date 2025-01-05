import "./goal-checker.sass"
import React from "react";
import Goal from "../../model/goal";
import CheckableGoal from "./checkable-goal";

type Props = {
    userGoals: Goal[]
    goals: number[]
    lastGoalCompletions: {[key:number]: number}
    toggleGoal: (id: number) => void
}

export default function GoalChecker({userGoals, goals, lastGoalCompletions, toggleGoal}: Props) {
    return (
        <div className="goal-checker">
            <div className="goal-checker__goals">
                {userGoals.map(goal => <CheckableGoal key={goal.id} goal={goal} completion={lastGoalCompletions[goal.id]} toggle={toggleGoal} checked={goals.includes(goal.id)}/>)}
            </div>
        </div>
    )
}
