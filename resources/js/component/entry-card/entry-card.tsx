import "./entry-card.sass"
import Entry from "../../model/entry";
import Icon from "../icon/icon";
import {Mood, MoodIcons} from "../../model/mood";
import classNames from "classnames";
import EntryCardCollection from "./entry-card-collection";
import {Weather, WeatherIcons, WeatherNames} from "../../model/weather";
import React from "react";
import {Link, router} from "@inertiajs/react";

type Props = {
    entry: Entry
}

const weekdays = ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]

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
        return `${date.getDate().toString().padStart(2, "0")} ${weekdays[date.getDay()]}`
    }


    return (
        <Link className="entry-card" href={`/entries/${entry.id}`}>
            <div className="entry-card__main-container">
                <div className="entry-card__header">
                    <p className="entry-card__date">{formatDate()}</p>
                    <Icon className={moodClassName} name={MoodIcons[entry.mood]}/>
                    <Icon className={weatherClassName} name={WeatherIcons[entry.weather]}/>
                    <div className="entry-card__stats">
                        <div className="entry-card__stat">
                            <Icon className='entry-card__stat-icon green' name='bedtime'/>
                            <span className="entry-card__stat-value green">{entry.sleeptime}</span>
                        </div>
                        <div className="entry-card__stat">
                            <Icon className='entry-card__stat-icon orange' name='weight'/>
                            <span className="entry-card__stat-value orange">{entry.weight.toFixed(1)}</span>
                        </div>
                        <div className="entry-card__stat">
                            <Icon className='entry-card__stat-icon blue' name='payments'/>
                            <span className="entry-card__stat-value blue">{entry.worktime}</span>
                        </div>
                    </div>
                </div>
                {entry.collections && entry.collections.length > 0 && <div className="entry-card__collections">
                    {entry.collections && entry.collections.map(collection =>
                        collection.activities?.length > 0 &&
                        <EntryCardCollection key={Math.random()} collection={collection}/>
                    )}
                </div>}
            </div>
            {entry.diary.length > 0 && <p className="entry-card__diary">{entry.diary}</p>}
            {entry.photos && entry.photos.length > 0 &&
                <div className="entry-card__photos">
                    <div className="entry-card__photos-grid">
                        {entry.photos.map(photo =>
                            <div className="entry-card__photo-container" key={photo}>
                                <img className="entry-card__photo" src={`/photos/${photo}`} alt={photo} />
                            </div>
                        )}
                    </div>
                </div>
            }
        </Link>
    )
}
