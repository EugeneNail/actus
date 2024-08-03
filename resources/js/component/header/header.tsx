import Icon from "../icon/icon";
import Button from "../button/button";
import {Color} from "../../model/color";
import HeaderLink from "./header-link";
import React from "react";
import {router} from "@inertiajs/react";
import "./header.sass"

export default function Header() {
    return (
        <header className="header">
            <HeaderLink icon="calendar_month" to="/entries"/>
            <HeaderLink icon="bar_chart" to="/statistics"/>
            <div className="header__placeholder">
                <div className="header__button-container">
                    <Button className="header__button" color={Color.Accent} round even onClick={() => router.get("/entries/new")}>
                        <Icon className="header__button-icon" name="calendar_add_on" bold/>
                    </Button>
                </div>
            </div>
            <HeaderLink icon="category" to="/collections"/>
            <HeaderLink icon="menu" to="/menu"/>
        </header>
    )
}
