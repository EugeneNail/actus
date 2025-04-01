import "./icon-select.sass"
import React, {ChangeEvent} from "react";
import IconSelectList from "./icon-select-list";
import classNames from "classnames";
import {Color} from "../../model/color";

type Props = {
    className?: string
    name: string
    value: number
    color: Color
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function IconSelect({className, name, value, color, onChange}: Props) {
    const inputId = "icon-select"


    function setIcon(icon: number) {
        const input = document.getElementById(inputId) as HTMLInputElement
        input.defaultValue = icon.toString()
        input.dispatchEvent(new Event('input', {bubbles: true}))
    }


    return (
        <div className={classNames("icon-select", className)}>
            <input id={inputId} className="icon-select__input" name={name} onChange={onChange}/>
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={100} color={color} label="People" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={200} color={color} label="Animals" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={300} color={color} label="Food and Drinks" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={400} color={color} label="Nature" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={500} color={color} label="Sport" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={600} color={color} label="Places and Travel" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={700} color={color} label="House" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={800} color={color} label="Body" />
            <IconSelectList setIcon={setIcon} selectedIconId={value} group={900} color={color} label="Beauty" />
        </div>
    )
}
