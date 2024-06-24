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
            <HeaderLink label="Отчеты" color={Color.Green} icon="bar_chart" to="/statistics"/>
            <HeaderLink label="Записи" color={Color.Blue} icon="post" to="/records"/>
            <div className="header__placeholder">
                <div className="header__button-container">
                    <Button className="header__button" color={Color.Accent} round even onClick={() => router.get("/records/new")}>
                        <Icon className="header__button-icon" name="add" bold/>
                    </Button>
                </div>
            </div>
            <HeaderLink label="Коллекции" color={Color.Orange} icon="category" to="/collections"/>
            <HeaderLink label="Меню" color={Color.Accent} icon="more_horiz" to="/menu"/>
        </header>
    )
}
