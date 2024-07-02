import "./menu-option.sass"
import {Color} from "../../model/color";
import Icon from "../icon/icon";
import classNames from "classnames";
import React from "react";

type Props = {
    icon: string
    label: string
    color: Color
    onClick?: () => void
}

export default function MenuOption({icon, label, color, onClick}: Props) {
    const className = classNames(
        "menu-option",
        {red: color == Color.Red},
        {orange: color == Color.Orange},
        {yellow: color == Color.Yellow},
        {green: color == Color.Green},
        {blue: color == Color.Blue},
        {purple: color == Color.Purple},
        {accent: color == Color.Accent},
    )

    return (
        <div className={className} onClick={onClick}>
            <div className="menu-option__icon-container">
                <Icon className="menu-option__icon" name={icon}/>
            </div>
            <p className="menu-option__label">
                {label}
                <Icon className="menu-option__chevron" bold name="chevron_right"/>
            </p>
        </div>
    )
}
