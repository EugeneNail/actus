import React, {ReactNode} from "react";
import "./form.sass"
import Icon from "../icon/icon";

type Props = {
    onClick: () => void
    icon: string
}

export default function FormOptions({onClick, icon}: Props) {
    return (
        <div className="form-options">
            <Icon className="form-options__icon" name={icon} onClick={onClick}/>
        </div>
    );
}
