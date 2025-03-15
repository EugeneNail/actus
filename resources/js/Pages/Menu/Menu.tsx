import "./menu-page.sass"
import React from "react";
import {Head, Link} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";
import Icon from "../../component/icon/icon";
import MenuLink from "../../component/menu-option/menu-link";
import {Method} from "@inertiajs/inertia";

type Props = {
    user: {name: string, id: number},
    counters: {records: number, photos: number}
}

export default withLayout(Menu)
function Menu({user, counters}: Props) {
    function getPostfix(extension: string): string {
        return `${new Date().toISOString().split('T')[0]}.${extension}`
    }

    return (
        <div className="menu-page">
            <Head title='Меню'/>
            <div className="menu wrapped">
                <h2 className="label">Учетная запись</h2>
                <div className="profile">
                    <Icon className="profile__icon" name="person"/>
                    <p className="profile__name">{user.name}</p>
                    <p className="profile__id">#{user.id}</p>
                </div>
                <h2 className="label">Мои записи</h2>
                <div className="records">
                    <Link className="record" href={"/entries"}>
                        <p className="record__label">Записано дней</p>
                        <p className="record__value">{counters?.records ?? 0}</p>
                        <Icon className="record__icon" name="calendar_month"/>
                    </Link>
                    <div className="record">
                        <p className="record__label">Загружено фотографий</p>
                        <p className="record__value">{counters?.photos ?? 0}</p>
                        <Icon className="record__icon" name="photo"/>
                    </div>
                </div>
                <h2 className="label">Экспорт</h2>
                <div className="exports">
                    <a className="export" href="/export/diaries" download>
                        <Icon className="export__icon" name="download"/>
                        <p className="export__filename">
                            Дневники
                            <br/>
                            {getPostfix('md')}
                        </p>
                    </a>
                    <a className="export" href="/export/photos" download>
                        <Icon className="export__icon" name="download"/>
                        <p className="export__filename">
                            Фотографии
                            <br/>
                            {getPostfix('zip')}
                        </p>
                    </a>
                </div>
                <h2 className="label">Навигация</h2>
                <div className="links">
                    <MenuLink icon="calendar_month" label="Записи" to="/entries"/>
                    <MenuLink icon="bar_chart" label="Статистика" to="/statistics"/>
                    <MenuLink icon="check" label="Цели" to="/goals"/>
                    <MenuLink className="logout-link" icon="logout" label="Выйти" to="/logout" method={Method.POST}/>
                </div>
            </div>
        </div>
    )
}
