import "./diary.sass"
import React, {useRef} from "react";
import classNames from "classnames";

type Props = {
    className?: string
    name: string
    max: number
    value: string
    onChange: (event: any) => void
}

export default function Diary({className, name, max, value, onChange}: Props) {
    const ref = useRef<HTMLTextAreaElement>(document.createElement('textarea'))

    function resizeToContent() {
        ref.current.style.height = ref.current.scrollHeight + "px"
    }

    return (
        <div className={classNames("diary", className)}>
            <label className="diary__label" htmlFor={name}>Сегодняшний дневник</label>
            <textarea className="diary__textarea"
                      ref={ref}
                      placeholder="Расскажите, что интересного случилось"
                      value={value}
                      name={name}
                      id={name}
                      onChange={onChange}
                      autoComplete="off"
                      autoCorrect="on"
                      onInput={resizeToContent}
                      maxLength={max}/>
            <p className="diary__limit">{value.length} / {max}</p>
        </div>
    )
}
