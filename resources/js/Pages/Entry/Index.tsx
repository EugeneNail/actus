import "./Index.sass"
import React from "react";
import EntryCard from "../../component/entry-card/entry-card";
import Entry from "../../model/entry";
import Icon from "../../component/icon/icon";
import withLayout from "../../Layout/default-layout";
import {router} from "@inertiajs/react";

type Props = {
    entries: Entry[]
}


export default withLayout(Index)
function Index({entries}: Props) {
    const messages = [
        "Давайте не будем оставлять эту страницу дневника пустой? ✌",
        "Давайте продолжим с того места, где вы остановились. 🙌",
        "Что ни день, то новая история. 👏",
        "Сделайте перерыв и добавьте запись на сегодня. ✍"
    ]

    function checkIfToday(entry: Entry): boolean {
        const today = new Date().toISOString().split("T")[0] + "T00:00:00Z"
        return entry.date == today
    }


    function getRandomMessage(): string {
        return messages[Math.floor(Math.random() * messages.length)];
    }


    return (
        <div className="entries-page page">
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
