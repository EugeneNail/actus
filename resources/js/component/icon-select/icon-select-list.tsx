import "./icon-select.sass"
import Icon from "../icon/icon";
import classNames from "classnames";
import React, {useState} from "react";
import {Icons8} from "../icon8/icons8";
import Icon8 from "../icon8/icon8";
import {Color} from "../../model/color";
import selectColor from "../../service/select-color";

type Props = {
    label: string
    selectedIconId: number
    group: number
    color: Color
    setIcon: (icon: number) => void
}

export default function IconSelectList({label, selectedIconId, group, color, setIcon}: Props) {
    const [isVisible, setVisible] = useState(false)
    const ids = Object.keys(Icons8).map(key => Number(key)).filter(id => id >= group && id < group + 100)

    return (
        <div className={classNames("icon-select-list", {invisible: !isVisible})}>
            <div className="icon-select-list__header" onClick={() => setVisible(!isVisible)}>
                <p className="icon-select-list__name">{label}</p>
                <Icon className="icon-select-list__chevron" name={isVisible ? "keyboard_arrow_up" : "keyboard_arrow_down"}/>
            </div>
            <ul className="icon-select-list__list">
                {ids && ids.map(id => (
                    <li key={id} className={classNames("icon-select-list__item", {selected: id == selectedIconId}, selectColor(color))} onClick={() => setIcon(id)}>
                        <Icon8 className="icon-select-list__icon" id={id}/>
                    </li>
                ))}
            </ul>
        </div>
    )
}
