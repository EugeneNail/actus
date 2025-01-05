import HeaderLink from "./header-link";
import React from "react";
import "./header.sass"

export default function Header() {
    return (
        <header className="header">
            <HeaderLink icon="calendar_month" to="/entries"/>
            <HeaderLink icon="bar_chart" to="/statistics"/>
            <HeaderLink icon="calendar_add_on" to={"/entries/today"}/>
            <HeaderLink icon="category" to="/collections"/>
            <HeaderLink icon="menu" to="/menu"/>
        </header>
    )
}
