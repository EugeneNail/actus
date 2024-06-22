import "./icon8.sass"
import classNames from "classnames";
import {Icons8, icons8Names} from "./icons8";
import React from "react";

type Props = {
    className?: string
    id: Icons8
}

export default function Icon8({className, id}: Props) {
    const name = icons8Names[id]

    return (
        <div className={classNames("icon8", className)}>
            <img className="icon8__icon" src={`/img/icons/${name}.png`} alt={name}/>
        </div>
    )
}
