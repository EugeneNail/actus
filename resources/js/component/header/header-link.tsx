import Icon from "../icon/icon";
import classNames from "classnames";
import {Color} from "../../model/color";
import React from "react";
import {Link} from "@inertiajs/react";
import selectColor from "../../service/select-color";

type Props = {
    label: string
    color: Color,
    icon: string,
    to: string
}

export default function HeaderLink({label, color, icon, to}: Props) {
    function getClass(): string {
        return classNames(
            "header-link",
            selectColor(color),
            {active: window.location.pathname.includes(to)})
    }

    return (
        <Link className={getClass()} href={to}>
            <Icon className="header-link__icon" name={icon}/>
            <p className="header-link__label">{label}</p>
        </Link>
    )
}
