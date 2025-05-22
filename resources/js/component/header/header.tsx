import HeaderLink from "./header-link";
import React from "react";
import "./header.sass"

export default function Header() {
    return (
        <header className="header">
            <HeaderLink icon="calendar_month" to="/entries"/>
            <HeaderLink icon="bar_chart" to="/statistics?period=month"/>
            <HeaderLink icon="calendar_add_on" to={"/entries/today"}/>
            <HeaderLink icon="add_card" to="/transactions/new"/>
            <HeaderLink icon="credit_card" to="/transactions"/>
            <HeaderLink icon="menu" to="/menu"/>
        </header>
    )
}
