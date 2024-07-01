import Form from "../../component/form/form";
import FormButtons from "../../component/form/form-button-container";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import React, {useEffect} from "react";
import Collection from "../../model/collection";
import ActivityPicker from "../../component/activity-picker/activity-picker";
import {DatePicker} from "../../component/date-picker/date-picker";
import MoodSelect from "../../component/mood-select/mood-select";
import Diary from "../../component/diary/diary";
import WeatherSelect from "../../component/weather-select/weather-select";
import {Mood} from "../../model/mood";
import {Weather} from "../../model/weather";
import {useFormState} from "../../hooks/use-form-state";
import withLayout from "../../Layout/default-layout";


interface Payload {
    id: number
    mood: Mood
    date: string
    weather: Weather
    diary: string
    activities: number[]
}


type Props = {
    entry?: Payload
    collections: Collection[]
}


function Save({entry, collections}: Props) {
    const willStore = window.location.pathname.includes("/new")
    const {data, setData, setField, errors, post, put} = useFormState<Payload>()

    useEffect(() => {
        setData({
            ...data,
            date: new Date().toISOString().split('T')[0],
            mood: Mood.Neutral,
            weather: Weather.Sunny,
            activities: [],
            diary: "",
        })

        if (!willStore) {
            setData({
                id: entry.id,
                mood: entry.mood,
                date: entry.date,
                weather: entry.weather,
                diary: entry.diary,
                activities: entry.activities,
            })
        }
    }, []);


    function addActivity(id: number) {
        if (data.activities.includes(id)) {
            setData({
                ...data,
                activities: data.activities.filter(activityId => activityId != id)
            })
        } else {
            setData({
                ...data,
                activities: [...data.activities, id]
            })
        }
    }


    function save() {
        willStore ? post('/entries') : put(`/entries/${entry.id}`)
    }


    return (
        <div className="save-entry-page page">
            <Form title={willStore ? "Новая запись" : "Запись"} noBackground>
                <DatePicker active={willStore} name="date" value={data.date ?? new Date().toISOString()} error={errors.date} onChange={setField}/>
                <MoodSelect name="mood" value={data.mood ?? Mood.Neutral} onChange={setField}/>
                <WeatherSelect name="weather" value={data.weather ?? Weather.Sunny} onChange={setField}/>
                <ActivityPicker collections={collections} value={data.activities ?? []} toggleActivity={addActivity}/>
                <Diary name="notes" max={5000} value={data.diary ?? ""} onChange={setField}/>
                <FormButtons>
                    <FormBackButton/>
                    <FormSubmitButton label="Сохранить" onClick={save}/>
                </FormButtons>
            </Form>
        </div>
    )
}

export default withLayout(Save);
