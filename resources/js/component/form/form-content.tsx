import React, {ReactNode} from "react";
import "./form.sass"

type Props = {
    children: ReactNode
}

export default function FormContent({children}: Props) {
    return (
        <div className="form-content wrapped">
            {children}
        </div>
    );
}
