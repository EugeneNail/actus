import "./Index.sass"
import React from "react";
import EntryCard from "../../component/entry-card/entry-card";
import Entry from "../../model/entry";
import Icon from "../../component/icon/icon";
import withLayout from "../../Layout/default-layout";
import {Head, Link} from "@inertiajs/react";
import Month from "../../model/month";
import MonthCarousel from "../../component/month-carousel/month-carousel";
import GoalHeatmapModel from "@/model/goal-heatmap";
import GoalHeatmap from "@/component/goal-heatmap/goal-heatmap";

export type Goals = {
    goalsTotal: number
    goalsCompleted: number
}

type Props = {
    goalHeatmap: GoalHeatmapModel[],
    entries: (Entry & Goals)[],
    months: Month[],
}


export default withLayout(Index)

function Index({entries, months, goalHeatmap}: Props) {

    const messages = [
        "Давайте не будем оставлять эту страницу дневника пустой? ✌",
        "Давайте продолжим с того места, где вы остановились. 🙌",
        "Что ни день, то новая история. 👏",
        "Сделайте перерыв и добавьте запись на сегодня. ✍"
    ]


    function canShowButton(): boolean {
        const params = new URLSearchParams(window.location.search)
        const today = new Date()

        const todayMonth = (today.getMonth() + 1).toString()
        if ((params.get('month') ?? todayMonth) != todayMonth) {
            return false
        }

        const todayYear = today.getFullYear().toString()
        if ((params.get('year') ?? todayYear) != todayYear) {
            return false
        }

        const formatted = today.toISOString().split("T")[0] + " 00:00:00"

        return !entries.some(entry => entry.date == formatted);
    }


    function getRandomMessage(): string {
        return messages[Math.floor(Math.random() * messages.length)];
    }

    return (
        <div className="entries-page">
            <Head title='Записи'/>
            {months && months.length > 0 && <MonthCarousel months={months}/>}
            <div className="entries-page__entries wrapped">
                {goalHeatmap && goalHeatmap.length > 0 && <GoalHeatmap data={goalHeatmap}/>}
                {entries && canShowButton() &&
                    <Link className="entries-page-button" href={"/entries/" + new Date().toISOString().split('T')[0]}>
                        <div className="entries-page-button__icon-container">
                            <Icon className="entries-page-button__icon" name="add"/>
                        </div>
                        <p className="entries-page-button__label">{getRandomMessage()}</p>
                    </Link>}
                {entries && entries.map(entry => (
                    <EntryCard key={entry.id} entry={entry}/>
                ))}
            </div>
        </div>
    )
}
