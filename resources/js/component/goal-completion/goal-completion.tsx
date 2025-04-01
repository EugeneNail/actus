import Goal from "@/model/goal"
import "./goal-completion.sass"
import React from "react"
import {Icons8} from "@/component/icon8/icons8";
import GoalCompletionItem from "@/component/goal-completion/goal-completion-item";

export type GoalCompletionModel = {
    icon: Icons8,
    completionRate: number
}

type Props = {
    values: GoalCompletionModel[]
}

export default function GoalCompletion({values}: Props) {
    console.log(values)
    return (
        <div className="goal-completion">
            <p className="goal-completion__label">Goal Completion</p>
            <div className="goal-completion__items">
                {values && values.map((goal, index) => <GoalCompletionItem key={index} goal={goal} index={index + 1}/>)}
            </div>
        </div>
    )
}
