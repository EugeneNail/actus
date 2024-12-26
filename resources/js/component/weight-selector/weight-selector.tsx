import "./weight-selector.sass"
import React, {ChangeEvent} from "react";
import classNames from "classnames";
import Icon from "../icon/icon";
import Icon8 from "../icon8/icon8";
import {Icons8} from "../icon8/icons8";

type Props = {
    name: string
    value: number
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function WeightSelector({name, value, onChange}: Props) {
    function addWeight(weight: number) {
        const input = document.getElementById(name) as HTMLInputElement
        let previous = +input.defaultValue == 0 ? 70 : +input.defaultValue
        weight = (previous + weight);

        if (weight < 40 || weight > 200) {
            return
        }

        input.defaultValue = weight.toFixed(1)
        input.dispatchEvent(new Event('input', {bubbles: true}))
    }


    function getClassName(weight: number): string {
        return classNames(
            'weight-selector__button',
            {'selected': value == weight}
        )
    }

    return (
        <div className="weight-selector">
            <label htmlFor={name} className="weight-selector__label"><Icon8 className="weight-selector__icon" id={Icons8.Torso}/> Сколько весили?</label>
            <input name={name} id={name} type="text" className="weight-selector__input" onChange={onChange}/>
            <p className="weight-selector__value">{(+value).toFixed(1)}</p>
            <div className="weight-selector__buttons">
                <div className={getClassName(1)} onClick={() => addWeight(10)}>+10</div>
                <div className={getClassName(2)} onClick={() => addWeight(5)}>+5</div>
                <div className={getClassName(3)} onClick={() => addWeight(1)}>+1</div>
                <div className={getClassName(4)} onClick={() => addWeight(0.1)}>+0.1</div>
            </div>
            <div className="weight-selector__buttons">
                <div className={getClassName(1)} onClick={() => addWeight(-10)}>-10</div>
                <div className={getClassName(2)} onClick={() => addWeight(-5)}>-5</div>
                <div className={getClassName(3)} onClick={() => addWeight(-1)}>-1</div>
                <div className={getClassName(4)} onClick={() => addWeight(-0.1)}>-0.1</div>
            </div>
        </div>
    )
}
