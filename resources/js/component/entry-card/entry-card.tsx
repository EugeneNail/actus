import "./entry-card.sass"
import Entry from "../../model/entry";
import Icon from "../icon/icon";
import {Mood, MoodIcons} from "../../model/mood";
import classNames from "classnames";
import EntryCardCollection from "./entry-card-collection";
import {Weather, WeatherIcons, WeatherNames} from "../../model/weather";
import React from "react";
import {router} from "@inertiajs/react";

type Props = {
    entry: Entry
}

const months = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"]
const weekdays = ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"]

export default function EntryCard({entry}: Props) {
    const moodClassName = classNames(
        "entry-card__mood",
        {radiating: entry.mood == Mood.Radiating},
        {happy: entry.mood == Mood.Happy},
        {neutral: entry.mood == Mood.Neutral},
        {bad: entry.mood == Mood.Bad},
        {awful: entry.mood == Mood.Awful},
    )


    const weatherClassName = classNames(
        "entry-card__weather",
        {heat: entry.weather == Weather.Heat},
        {sunny: entry.weather == Weather.Sunny},
        {cloudy: entry.weather == Weather.Cloudy},
        {windy: entry.weather == Weather.Windy},
        {rainy: entry.weather == Weather.Rainy},
        {thunder: entry.weather == Weather.Thunder},
        {foggy: entry.weather == Weather.Foggy},
        {snowy: entry.weather == Weather.Snowy},
        {cold: entry.weather == Weather.Cold},
    )


    function formatDate(): string {
        const date = new Date(entry.date)
        return `${weekdays[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]}`
    }


    return (
        <div className="entry-card" onClick={() => router.get(`/entries/${entry.id}`)}>
            <div className="entry-card__header">
                <Icon className={moodClassName} name={MoodIcons[entry.mood]}/>
                <Icon className={weatherClassName} name={WeatherIcons[entry.weather]}/>
                <div className="entry-card__label">
                    <p className="entry-card__date">{formatDate()}</p>
                    <p className="entry-card__weather-name">{WeatherNames[entry.weather]}</p>
                </div>
            </div>
            <div className="entry-card__collections">
                {entry.collections && entry.collections.map(collection =>
                    collection.activities?.length > 0 && <EntryCardCollection key={Math.random()} collection={collection}/>
                )}
            </div>
            {entry.diary.length > 0 && <p className="entry-card__notes">{entry.diary}</p>}
            {entry.photos && <div className="entry-card__photos">
                {entry.photos.map(photo =>
                    <div className="entry-card__photo-container" key={photo}>
                        <img className="entry-card__photo" src={`/api/photos/${photo}`} alt={photo} />
                    </div>
                )}
            </div>}
        </div>
    )
}