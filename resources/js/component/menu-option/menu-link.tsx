import "./menu-link.sass"
import {Color} from "../../model/color";
import Icon from "../icon/icon";
import classNames from "classnames";
import React from "react";
import {Link, router} from "@inertiajs/react";
import {Method} from "@inertiajs/inertia";

type Props = {
    className?: string
    icon: string
    label: string
    to: string
    method?: Method
}

export default function MenuLink({className, icon, label, to, method = Method.GET}: Props) {
    return (
        <Link className={classNames("menu-link", className)} href={to} method={method}>
            <Icon className="menu-link__icon" name={icon}/>
            <p className="menu-link__label">
                {label}
                <Icon className="menu-link__chevron" bold name="chevron_right"/>
            </p>
        </Link>
    )
}
