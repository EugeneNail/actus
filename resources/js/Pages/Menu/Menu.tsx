import "./menu-page.sass"
import MenuOption from "../../component/menu-option/menu-option";
import {Color} from "../../model/color";
import React from "react";
import {router} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";

function Menu() {
    return (
        <div className="menu-page page">
            <div className="menu-page__menu">
                <div className="menu-page__group">
                    <MenuOption icon="bar_chart" label="Статистика" color={Color.Green} onClick={() => router.get("/statistics")}/>
                    <MenuOption icon="post" label="Записи" color={Color.Red} onClick={() => router.get("/entries")}/>
                    <MenuOption icon="category" label="Коллекции" color={Color.Orange} onClick={() => router.get("/collections")}/>
                </div>
                <div className="menu-page__group">
                    <MenuOption icon="logout" label="Выйти" color={Color.Accent} onClick={() => router.post('/logout')}/>
                </div>

            </div>
        </div>
    )
}
export default withLayout(Menu)
