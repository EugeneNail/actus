import "./button.sass"
import React, {ReactNode} from "react";
import classNames from "classnames";
import {Color} from "../../model/color";
import selectColor from "../../service/select-color";

export enum ButtonStyle {
    Primary,
    Secondary
}

type Props = {
    className?:string
    color?: Color
    submit?: boolean
    even?: boolean
    round?: boolean
    shadowed?: boolean
    style?: ButtonStyle
    onClick: () => void
    children: ReactNode
}

export default function Button({className, color = Color.Green, submit, even, round, shadowed, style = ButtonStyle.Primary, onClick, children}: Props) {
    className = classNames(
        "button",
        className,
        {even: even},
        {round: round},
        {shadowed: shadowed},
        selectColor(color),
        {primary: style == ButtonStyle.Primary},
        {secondary: style == ButtonStyle.Secondary}
    )

    return (
        <button type={submit ? "submit" : "button"} className={className} onClick={onClick}>
            {children}
        </button>
    )
}
