import Icon from "../icon/icon";
import classNames from "classnames";
import "./field.sass"
import React, {ChangeEvent, useEffect, useState} from "react";
import {Color} from "../../model/color";
import selectColor from "../../service/select-color";

type FieldProps = {
    value: string
    icon?: string
    name: string
    label: string
    max?: number
    className?: string
    error?: string
    email?: boolean
    password?: boolean
    color?: Color
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function Field({value, icon = "", name, label, max = 100, className, error = "", email, password, color = Color.Accent, onChange}: FieldProps) {
    const [isVisible, setVisible] = useState(true)

    useEffect(() => {
        if (password) {
            setVisible(false)
        }
    }, [])


    return (
        <div className={classNames("field", className, selectColor(color))}>
            <div className={classNames("field__content")}>
                <div className="field__icon-container">
                    <Icon name={icon}/>
                </div>
                <input autoComplete="off"
                       value={value}
                       placeholder={label}
                       maxLength={max}
                       type={isVisible ? "text" : "password"}
                       id={name}
                       name={name}
                       inputMode={email ? "email" : "text"}
                       className="field__input"
                       onChange={onChange}/>
                {password && <Icon className="field__visibility" name={isVisible ? "visibility_off" : "visibility"} onClick={() => setVisible(!isVisible)}/>}
            </div>
            <p className="field__error">{error}</p>
        </div>
    )
}
