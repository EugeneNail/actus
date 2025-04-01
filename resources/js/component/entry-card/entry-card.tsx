import "./entry-card.sass"
import Entry from "../../model/entry";
import Icon from "../icon/icon";
import {Mood, MoodIcons} from "@/model/mood";
import classNames from "classnames";
import {Weather, WeatherIcons} from "@/model/weather";
import React from "react";
import {Link} from "@inertiajs/react";
import {Goals} from "@/Pages/Entry/Index";
import CardGoal from "@/component/card-goal/card-goal";

type Props = {
    entry: Entry & Goals
}

const weekdays = ["Su", "Mn", "Tu", "We", "Th", "Fr", "Sa"]

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
        <Link className="entry-card" href={`/entries/${entry.date.substring(0, 10)}`}>
            <div className="entry-card__main-container">
                <div className="entry-card__header">
                    <p className="entry-card__date">{formatDate()}</p>
                    <Icon className={moodClassName} name={MoodIcons[entry.mood]}/>
                    <Icon className={weatherClassName} name={WeatherIcons[entry.weather]}/>
                    <div className="entry-card__stats">
                        <div className="entry-card__stat">
                            <Icon className='entry-card__stat-icon' name='check' bold/>
                            <span className="entry-card__stat-value">{entry.goals.length} / {entry.goalsTotal}</span>
                        </div>
                    </div>
                </div>
                <div className="entry-card__goals">
                    {entry?.goals && entry.goals.map(goal => (
                        <CardGoal goal={goal} key={Math.random()}/>
                    ))}
                </div>
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
