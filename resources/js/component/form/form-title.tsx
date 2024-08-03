import React, {ReactNode} from "react";
import "./form.sass"

type Props = {
    children: ReactNode
}

export default function FormTitle({children}: Props) {
    return (
        <div className="form-title">
            {children}
        </div>
    );
}
