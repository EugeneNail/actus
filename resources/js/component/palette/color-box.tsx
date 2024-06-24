import "./palette.sass"
import {Color} from "../../model/color";
import Icon from "../icon/icon";
import classNames from "classnames";
import React from "react";
import selectColor from "../../service/select-color";

type Props = {
    color: Color
    value: number
    setColor: (color: Color) => void
}

export default function ColorBox({color, value, setColor}: Props) {
    return (
        <div onClick={() => setColor(color)} className={classNames("palette__color-box", selectColor(color), {selected: value == color})}>
            {value == color && <Icon bold className="palette__check-mark" name="check"/>}
        </div>
    )
}
