import "./form.sass"
import Button, {ButtonStyle} from "../button/button";
import {Color} from "../../model/color";
import React from "react";

type Props = {
    label: string
    color?: Color
    onClick: () => void
}

export default function FormSubmitButton({label, color = Color.Accent, onClick}: Props) {
    return (
        <div className="form-submit-button wrapped">
            <Button className="form-submit-button__button" submit style={ButtonStyle.Primary} color={color} onClick={onClick}>
                {label}
            </Button>
        </div>
    )
}
