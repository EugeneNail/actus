import React from "react";
import "./goal-heatmap.sass"
import GoalHeatmapModel from "@/model/goal-heatmap";
import classNames from "classnames";
import Icon8 from "@/component/icon8/icon8";

type Props = {
    data: GoalHeatmapModel[]
}

export default function GoalHeatmap({data}: Props) {
    return (
        <div className="goal-heatmap">
            {data && data.length && data.map(heatmap =>
                <div className="goal-heatmap__grid">
                    <div className="goal-heatmap__icon-container">
                        <Icon8 id={heatmap.icon} className="goal-heatmap__icon"/>
                    </div>
                    {heatmap.heat && heatmap.heat.map(heat =>
                        <div className={classNames("goal-heatmap__heat", {hot: heat == true})}></div>
                    )}
                    <div className="goal-heatmap__icon-container">
                        <Icon8 id={heatmap.icon} className="goal-heatmap__icon"/>
                    </div>
                </div>
            )}
        </div>
    )
}
