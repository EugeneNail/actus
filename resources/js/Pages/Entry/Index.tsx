import "./Index.sass"
import React, {useEffect} from "react";
import EntryCard from "../../component/entry-card/entry-card";
import Entry from "../../model/entry";
import Icon from "../../component/icon/icon";
import withLayout from "../../Layout/default-layout";
import {Head, router} from "@inertiajs/react";
import Month from "../../model/month";
import EntryMonth from "../../component/entry-month/entry-month";

type Props = {
    entries: Entry[],
    months: Month[],
}


export default withLayout(Index)
function Index({entries, months}: Props) {

    const messages = [
        "Давайте не будем оставлять эту страницу дневника пустой? ✌",
        "Давайте продолжим с того места, где вы остановились. 🙌",
        "Что ни день, то новая история. 👏",
        "Сделайте перерыв и добавьте запись на сегодня. ✍"
    ]


    useEffect(() => {
        const params = new URLSearchParams(window.location.search)
        const today = new Date();
        const currentMonth = params.get('month') ?? today.getMonth() + 1
        const currentYear = params.get('year') ?? today.getFullYear()

        document.getElementById(`${currentMonth}-${currentYear}`)
            ?.scrollIntoView({
                block: "nearest",
                inline: "center"
            })
    }, []);


    function checkIfToday(entry: Entry): boolean {
        const params = new URLSearchParams(window.location.search)
        const today = new Date();
        const isCurrentMonth = params.get('month') == (today.getMonth() + 1).toString()
        const isCurrentYear = params.get('year') == today.getFullYear().toString()
        const formatted = today.toISOString().split("T")[0] + " 00:00:00"

        return !isCurrentYear || !isCurrentMonth || entry.date == formatted
    }


    function getRandomMessage(): string {
        return messages[Math.floor(Math.random() * messages.length)];
    }


    return (
        <div className="entries-page page">
            <Head title='Записи'/>
            <div className="entries-page__months" id="entries-page__months">
                {months && months.map(month => (
                    <EntryMonth month={month} key={`${month.month}-${month.year}`}/>
                ))}
            </div>
            <div className="entries-page__entries">
                {entries && !entries.some(checkIfToday) &&
                    <div className="entries-page-button" onClick={() => router.get("/entries/new")}>
                        <div className="entries-page-button__icon-container">
                            <Icon className="entries-page-button__icon" name="add"/>
                        </div>
                        <p className="entries-page-button__label">{getRandomMessage()}</p>
                    </div>}
                {entries && entries.map(entry => (
                    <EntryCard key={entry.id} entry={entry}/>
                ))}
            </div>
        </div>
    )
}
