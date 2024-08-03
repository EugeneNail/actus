import "./activity-picker.sass"
import {Color} from "../../model/color";
import Activity from "../../model/activity";
import classNames from "classnames";
import Icon8 from "../icon8/icon8";
import React from "react";
import selectColor from "../../service/select-color";

type Props = {
    activity: Activity
    color: Color
    toggled: boolean
    toggle: (id: number) => void
}

export default function PickerActivity({activity, color, toggled, toggle}: Props) {
    return (
        <div className="picker-activity" onClick={() => toggle(activity.id)}>
            <div className={classNames("picker-activity__icon-container", {toggled: toggled}, selectColor(color))}>
                <Icon8 id={activity.icon} className="picker-activity__icon"/>
            </div>
            <p className="picker-activity__name">{activity.name}</p>
        </div>
    )
}
