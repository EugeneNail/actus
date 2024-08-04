import "./table-activity.sass"
import {default as TableActivityModel} from "../../model/table-activity";
import React, {useState} from "react";
import {Color} from "../../model/color";
import {Icons8} from "../icon8/icons8";
import Icon8 from "../icon8/icon8";
import classNames from "classnames";
import selectColor from "../../service/select-color";

type Props = {
    color: Color
    activity: TableActivityModel
}

export default function TableActivity({color, activity}: Props) {
    const [isVisible, setVisible] = useState(false)

    return (
        <div className="table-activity" onClick={() => setVisible(!isVisible)}>
            <Icon8 className="table-activity__icon" id={activity.icon}/>
            <div className="table-activity__occurrences">
                {activity.lastOccurrences && activity.lastOccurrences.length > 0 && activity.lastOccurrences.map(occurrence =>
                    <div key={Math.random()} className={classNames("table-activity__occurrence", {active: occurrence}, selectColor(color))}/>
                )}
                <p className={classNames("table-activity__name", {visible: isVisible})}>{activity.name}</p>
            </div>
        </div>
    );
}
