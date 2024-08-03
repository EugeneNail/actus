import "./form.sass"
import Icon from "../icon/icon";
import React from "react";

export default function FormBackButton() {
    return (
        <Icon className="form-back-button" name="arrow_back_ios" bold onClick={() => window.history.back()}/>
    )
}
