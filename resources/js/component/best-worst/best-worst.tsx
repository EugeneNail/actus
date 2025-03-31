import Goal from "@/model/goal"
import "./best-worst.sass"
import React from "react"
import BestWorstGoal from "@/component/best-worst/best-worst-goal";
import {Icons8} from "@/component/icon8/icons8";

export type BestWorstGoalModel = {
    icon: Icons8,
    mood: number
}

type Props = {
    values: {
        best: BestWorstGoalModel[],
        worst: BestWorstGoalModel[]
    }
}

export default function BestWorst({values}: Props) {
    return (
        <div className="best-worst">
            <p className="best-worst__label">Best and Worst</p>
            <p className="best-worst__title">When you was <span>radiating...</span></p>
            <div className="best-worst__goals">
                {values.best && values.best.map((goal, index) => <BestWorstGoal key={index} goal={goal} index={index + 1}/>)}
            </div>
            <p className="best-worst__title">When you was <span>awful...</span></p>
            <div className="best-worst__goals">
                {values.worst && values.worst.map((goal, index) => <BestWorstGoal key={index} goal={goal} index={index + 1}/>)}
            </div>
        </div>
    )
}
