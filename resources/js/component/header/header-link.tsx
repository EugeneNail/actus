import Icon from "../icon/icon";
import classNames from "classnames";
import {Color} from "../../model/color";
import React from "react";
import {Link} from "@inertiajs/react";
import selectColor from "../../service/select-color";

type Props = {
    icon: string,
    to: string
}

export default function HeaderLink({icon, to}: Props) {
    function getClass(): string {
        return
    }

    return (
        <Link className={getClass()} href={to}>
            <Icon className={classNames("header-link__icon", "header-link", {active: window.location.pathname.includes(to)})} name={icon}/>
        </Link>
    )
}
