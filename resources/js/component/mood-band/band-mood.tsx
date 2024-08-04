import "./mood-band.sass"
import Icon from "../icon/icon";
import React from "react";
import {Mood, MoodIcons} from "../../model/mood";
import classNames from "classnames";

type Props = {
    mood: Mood
    value: number
    greatest: number
}

export default function BandMood({mood, value, greatest}: Props) {
    const color = classNames(
        {radiating: mood == Mood.Radiating},
        {happy: mood == Mood.Happy},
        {neutral: mood == Mood.Neutral},
        {bad: mood == Mood.Bad},
        {awful: mood == Mood.Awful}
    )
    const iconClass = classNames("band-mood__icon", color, {greatest: greatest == value})
    const containerClass = classNames("band-mood__value-container", color, {greatest: greatest})

    return (
        <div className="band-mood">
            <Icon className={iconClass} name={MoodIcons[mood]}/>
            <div className={containerClass}>
                <div className="band-mood__value">{value.toFixed(0)}%</div>
            </div>
        </div>
    );
}
