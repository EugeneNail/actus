import "./form.sass"
import Button, {ButtonStyle} from "../button/button";
import Icon from "../icon/icon";
import {Color} from "../../model/color";
import React from "react";

type Props = {
    onClick: () => void
}

export default function FormDeleteButton({onClick}: Props) {
    return (
        <Button className="form__delete-button" even style={ButtonStyle.Secondary} color={Color.Red} onClick={onClick}>
            <Icon className="form__delete-button-icon" name="delete" bold/>
        </Button>
    )
}
