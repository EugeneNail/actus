import "./form.sass"
import Icon from "../icon/icon";
import React from "react";

type Props = {
    action?: () => void
}

export default function FormBackButton({action}: Props) {
    return (
        <Icon className="form-back-button" name="arrow_back_ios" bold onClick={() => action ? action() : window.history.back()}/>
    )
}
