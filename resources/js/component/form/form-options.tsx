import React, {ReactNode} from "react";
import "./form.sass"
import Icon from "../icon/icon";
import {Link} from "@inertiajs/react";

type Props = {
    href: string
    icon: string
}

export default function FormOptions({href, icon}: Props) {
    return (
        <Link href={href} className="form-options">
            <Icon className="form-options__icon" name={icon}/>
        </Link>
    );
}
