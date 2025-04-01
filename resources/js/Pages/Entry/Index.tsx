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
        "Let's not leave this diary page blank? ✌",
        "Let's continue from where you left off. 🙌",
        "A new day, a new story. 👏",
        "Take a break and create a new entry for today. ✍"
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
            <Head title='Entries'/>
            {months && months.length > 0 && <MonthCarousel months={months}/>}
            <div className="entries-page__entries wrapped">
                {entries && canShowButton() &&
                    <Link className="entries-page-button" href={"/entries/" + new Date().toISOString().split('T')[0]}>
                        <div className="entries-page-button__icon-container">
                            <Icon className="entries-page-button__icon" name="add"/>
                        </div>
                        <p className="entries-page-button__label">{getRandomMessage()}</p>
                    </Link>}
                {goalHeatmap && goalHeatmap.length > 0 && <GoalHeatmap data={goalHeatmap}/>}
                {entries && entries.map(entry => (
                    <EntryCard key={entry.id} entry={entry}/>
                ))}
            </div>
        </div>
    )
}
