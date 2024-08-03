import React, {ReactNode} from "react";
import "./form.sass"

type Props = {
    children: ReactNode
}

export default function FormHeader({children}: Props) {
    return (
        <div className="form-header wrapped">
            {children}
        </div>
    );
}
