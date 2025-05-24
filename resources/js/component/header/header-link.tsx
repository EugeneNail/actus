import Icon from "../icon/icon";
import classNames from "classnames";
import React from "react";
import {Link} from "@inertiajs/react";

type Props = {
    icon: string,
    to: string
}

export default function HeaderLink({icon, to}: Props) {
    function getClass(): string {
        return classNames(
            "header-link__icon",
            "header-link",
            {active: window.location.pathname == to.split('?')[0]}
        )
    }

    return (
        <Link className={getClass()} href={to}>
            <Icon className={getClass()} name={icon}/>
        </Link>
    )
}
