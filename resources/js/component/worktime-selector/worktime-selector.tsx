import "./worktime-selector.sass"
import React, {ChangeEvent} from "react";
import classNames from "classnames";

type Props = {
    name: string
    value: number
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function WorktimeSelector({name, value, onChange}: Props) {
    function setWorktime(worktime: number) {
        const input = document.getElementById(name) as HTMLInputElement
        input.defaultValue = worktime.toString()
        input.dispatchEvent(new Event('input', {bubbles: true}))
    }


    function getClassName(worktime: number, isWide: boolean = false): string {
        return classNames(
            'worktime-selector__option',
            {'wide': isWide},
            {'selected': value == worktime}
        )
    }

    return (
        <div className="worktime-selector">
            <label htmlFor={name} className="worktime-selector__label">Сколько часов работали?</label>
            <input name={name} id={name} type="text" className="worktime-selector__input" onChange={onChange}/>
            <div className="worktime-selector__large-options">
                <div className={getClassName(0, true)} onClick={() => setWorktime(0)}>Не работал</div>
                <div className={getClassName(9, true)} onClick={() => setWorktime(9)}>Переработка</div>
            </div>
            <div className="worktime-selector__options">
                <div className={getClassName(1)} onClick={() => setWorktime(1)}>1</div>
                <div className={getClassName(2)} onClick={() => setWorktime(2)}>2</div>
                <div className={getClassName(3)} onClick={() => setWorktime(3)}>3</div>
                <div className={getClassName(4)} onClick={() => setWorktime(4)}>4</div>
                <div className={getClassName(5)} onClick={() => setWorktime(5)}>5</div>
                <div className={getClassName(6)} onClick={() => setWorktime(6)}>6</div>
                <div className={getClassName(7)} onClick={() => setWorktime(7)}>7</div>
                <div className={getClassName(8)} onClick={() => setWorktime(8)}>8</div>
            </div>
        </div>
    )
}
