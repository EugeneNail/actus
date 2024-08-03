import Icon from "../icon/icon";
import classNames from "classnames";
import "./field.sass"
import React, {ChangeEvent, useEffect, useState} from "react";
import selectColor from "../../service/select-color";

type FieldProps = {
    value: string
    name: string
    label: string
    max?: number
    className?: string
    error?: string
    email?: boolean
    password?: boolean
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function Field({value, name, label, max = 100, className, error = "", email, password, onChange}: FieldProps) {
    const [isVisible, setVisible] = useState(true)

    useEffect(() => {
        if (password) {
            setVisible(false)
        }
    }, [])


    return (
        <div className={classNames("field", className)}>
            <div className={"field__content"}>
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
