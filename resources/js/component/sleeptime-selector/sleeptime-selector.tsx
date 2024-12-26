import "./sleeptime-selector.sass"
import React, {ChangeEvent} from "react";
import classNames from "classnames";

type Props = {
    name: string
    value: number
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function SleeptimeSelector({name, value, onChange}: Props) {
    function setSleeptime(sleeptime: number) {
        const input = document.getElementById(name) as HTMLInputElement
        input.defaultValue = sleeptime.toString()
        input.dispatchEvent(new Event('input', {bubbles: true}))
    }


    function getClassName(sleeptime: number): string {
        return classNames(
            'sleeptime-selector__option',
            {'selected': value == sleeptime}
        )
    }

    return (
        <div className="sleeptime-selector">
            <label htmlFor={name} className="sleeptime-selector__label">Сколько часов спали?</label>
            <input name={name} id={name} type="text" className="sleeptime-selector__input" onChange={onChange}/>
            <div className="sleeptime-selector__options">
                <div className={getClassName(1)} onClick={() => setSleeptime(1)}>1</div>
                <div className={getClassName(2)} onClick={() => setSleeptime(2)}>2</div>
                <div className={getClassName(3)} onClick={() => setSleeptime(3)}>3</div>
                <div className={getClassName(4)} onClick={() => setSleeptime(4)}>4</div>
                <div className={getClassName(5)} onClick={() => setSleeptime(5)}>5</div>
                <div className={getClassName(6)} onClick={() => setSleeptime(6)}>6</div>
                <div className={getClassName(7)} onClick={() => setSleeptime(7)}>7</div>
                <div className={getClassName(8)} onClick={() => setSleeptime(8)}>8</div>
                <div className={getClassName(9)} onClick={() => setSleeptime(9)}>9</div>
                <div className={getClassName(10)} onClick={() => setSleeptime(10)}>10</div>
            </div>
        </div>
    )
}
