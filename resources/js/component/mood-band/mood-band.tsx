import "./mood-band.sass"
import React from "react";
import BandMood from "./band-mood";
import {Mood} from "../../model/mood";

type Props = {
    values: number[]
}

export default function MoodBand({values}: Props) {
    const greatest = Math.max(...values)

    return (
        <div className="mood-band">
            <p className="mood-band__label">Шкала Настроения</p>
            <div className="mood-band__moods">
                <BandMood mood={Mood.Radiating} value={values[0]} greatest={greatest}/>
                <BandMood mood={Mood.Happy} value={values[1]} greatest={greatest}/>
                <BandMood mood={Mood.Neutral} value={values[2]} greatest={greatest}/>
                <BandMood mood={Mood.Bad} value={values[3]} greatest={greatest}/>
                <BandMood mood={Mood.Awful} value={values[4]} greatest={greatest}/>
            </div>
            <div className="mood-band__band">
                <div className="mood-band__band-item radiating" style={{width: values[0] + "%"}}/>
                <div className="mood-band__band-item happy" style={{width: values[1] + "%"}}/>
                <div className="mood-band__band-item neutral" style={{width: values[2] + "%"}}/>
                <div className="mood-band__band-item bad" style={{width: values[3] + "%"}}/>
                <div className="mood-band__band-item awful" style={{width: values[4] + "%"}}/>
            </div>
        </div>
    );
}
