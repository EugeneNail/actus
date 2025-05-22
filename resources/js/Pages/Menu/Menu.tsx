import "./menu-page.sass"
import React from "react";
import {Head, Link} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";
import Icon from "../../component/icon/icon";
import MenuLink from "../../component/menu-option/menu-link";
import {Method} from "@inertiajs/inertia";
import {MonthNames} from "@/model/month-names";

type Props = {
    user: {name: string, id: number},
    counters: {records: number, photos: number},
    exportPeriods: {
        diaries: number[],
        photos: { year: number, month: number }[]
    }
}

export default withLayout(Menu)
function Menu({user, counters, exportPeriods}: Props) {
    function getPostfix(extension: string): string {
        return `${new Date().toISOString().split('T')[0]}.${extension}`
    }

    return (
        <div className="menu-page">
            <Head title='Menu'/>
            <div className="menu wrapped">
                <h2 className="label">Profile</h2>
                <div className="profile">
                    <Icon className="profile__icon" name="person"/>
                    <p className="profile__name">{user.name}</p>
                    <p className="profile__id">#{user.id}</p>
                </div>
                <h2 className="label">Entries</h2>
                <div className="records">
                    <Link className="record" href={"/entries"}>
                        <p className="record__label">Entries created</p>
                        <p className="record__value">{counters?.records ?? 0}</p>
                        <Icon className="record__icon" name="calendar_month"/>
                    </Link>
                    <div className="record">
                        <p className="record__label">Photos uploaded</p>
                        <p className="record__value">{counters?.photos ?? 0}</p>
                        <Icon className="record__icon" name="photo"/>
                    </div>
                </div>
                <h2 className="label">Export</h2>
                <div className="exports">
                    {exportPeriods?.diaries?.length > 0 && (
                        <div className="exports-column">
                            {exportPeriods.diaries.map(period => (
                                <a className="export" href={`/export/diaries?year=${period}`} download>
                                    <Icon className="export__icon" name="download"/>
                                    <p className="export__filename">
                                        Diaries
                                        <br/>
                                        {`${period}.md`}
                                    </p>
                                </a>
                            ))}
                        </div>
                    )}

                    {exportPeriods?.photos?.length > 0 && (
                        <div className="exports-column">
                            {exportPeriods.photos.map(period => (
                                <a className="export" href={`export/photos?year=${period.year}&month=${period.month}`}>
                                    <Icon className="export__icon" name="download"/>
                                    <p className="export__filename">
                                        Photos
                                        <br/>
                                        {`${MonthNames[+period.month]} ${period.year}.zip`}
                                    </p>
                                </a>
                            ))}
                        </div>
                    )}

                </div>
                <h2 className="label">Navigation</h2>
                <div className="links">
                    <MenuLink icon="calendar_month" label="Entries" to="/entries"/>
                    <MenuLink icon="bar_chart" label="Statistics" to="/statistics"/>
                    <MenuLink icon="check" label="Goals" to="/goals"/>
                    <MenuLink icon="credit_card" label="Transactions" to="/transactions"/>
                    <MenuLink className="logout-link" icon="logout" label="Log out" to="/logout" method={Method.POST}/>
                </div>
            </div>
        </div>
    )
}
