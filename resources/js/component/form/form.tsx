import "./form.sass"
import React, {ReactNode} from "react";
import classNames from "classnames";

type Props = {
    children: ReactNode
}

export default function Form({children}: Props) {
    return (
        <form className="form" onSubmit={e => e.preventDefault()}>
            {children}
        </form>
    )
}
