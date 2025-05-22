import React, {ChangeEvent} from "react"
import "./sign-picker.sass"
import {Weather} from "@/model/weather";
import classNames from "classnames";
import Icon from "@/component/icon/icon";

type Props = {
    value: number
    name: string
    className?: string
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function SignPicker({value, name, className, onChange}: Props) {
    function setSign(sign: number) {
        if (sign != -1 && sign != 1) {
            sign = -1
        }

        const input = document.getElementById(name) as HTMLInputElement
        input.defaultValue = sign.toString()
        input.dispatchEvent(new Event('input', {bubbles: true}))
    }




    return (
        <div className="sign-picker">
            <input className="sign-picker__input" id={name} name={name} onChange={onChange} type='number'/>
            <div className="sign-picker__button-container">
                <div className={classNames("sign-picker__button", {'button accent primary': value == -1})} onClick={() => setSign(-1)}>
                    <Icon className='sign-picker__icon' name='remove' bold/>
                </div>
                <div className={classNames("sign-picker__button", {'button accent primary': value == +1})} onClick={() => setSign(+1)}>
                    <Icon className='sign-picker__icon' name='add' bold/>
                </div>
            </div>
        </div>
    )
}
