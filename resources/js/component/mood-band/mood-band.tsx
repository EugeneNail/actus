import "./mood-band.sass"
import React from "react";
import BandMood from "./band-mood";
import {Mood} from "../../model/mood";
import MoodBandData from "../../model/mood-band-data";

type Props = {
    values: MoodBandData
}

export default function MoodBand({values}: Props) {
    const greatest = Math.max(
        values.radiating,
        values.happy,
        values.neutral,
        values.bad,
        values.awful
    )

    return (
        <div className="mood-band">
            <p className="mood-band__label">Mood Band</p>
            <div className="mood-band__moods">
                <BandMood mood={Mood.Radiating} value={values.radiating} greatest={greatest}/>
                <BandMood mood={Mood.Happy} value={values.happy} greatest={greatest}/>
                <BandMood mood={Mood.Neutral} value={values.neutral} greatest={greatest}/>
                <BandMood mood={Mood.Bad} value={values.bad} greatest={greatest}/>
                <BandMood mood={Mood.Awful} value={values.awful} greatest={greatest}/>
            </div>
            <div className="mood-band__band">
                <div className="mood-band__band-item radiating" style={{width: values.radiating + "%"}}/>
                <div className="mood-band__band-item happy" style={{width: values.happy + "%"}}/>
                <div className="mood-band__band-item neutral" style={{width: values.neutral + "%"}}/>
                <div className="mood-band__band-item bad" style={{width: values.bad + "%"}}/>
                <div className="mood-band__band-item awful" style={{width: values.awful + "%"}}/>
            </div>
        </div>
    );
}
