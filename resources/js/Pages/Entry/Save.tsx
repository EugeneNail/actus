import Form from "../../component/form/form";
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
import {Head, router} from "@inertiajs/react";
import PhotoUploader from "../../component/photo-uploader/photo-uploader";
import axios from "axios";
import FormContent from "../../component/form/form-content";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import FormOptions from "../../component/form/form-options";
import Icon from "../../component/icon/icon";
import WorktimeSelector from "../../component/worktime-selector/worktime-selector";
import SleeptimeSelector from "../../component/sleeptime-selector/sleeptime-selector";
import WeightSelector from "../../component/weight-selector/weight-selector";
import GoalChecker from "../../component/goal-checker/goal-checker";
import Goal from "../../model/goal";


interface Payload {
    id: number
    mood: Mood
    completedGoals: number[]
    goals: Goal[]
    date: string
    weather: Weather
    sleeptime: number
    weight: number
    worktime: number
    diary: string
    activities: number[]
    photos: string[]
}


type Props = {
    entry?: Payload
    collections: Collection[]
}


export default function Save({entry, collections}: Props) {
    const willStore = window.location.pathname.includes("/new")
    const {data, setData, setField, errors, post, put} = useFormState<Payload>()

    useEffect(() => {
        console.log(entry)
        setData({
            ...data,
            date: new Date().toISOString().split('T')[0],
            mood: Mood.Neutral,
            goals: entry.goals,
            completedGoals: [],
            weather: Weather.Sunny,
            sleeptime: 1,
            weight: 70,
            worktime: 0,
            activities: [],
            diary: "",
            photos: []
        })

        if (!willStore) {
            setData({
                id: entry.id,
                mood: entry.mood,
                goals: entry.goals,
                completedGoals: entry.completedGoals,
                date: entry.date,
                weather: entry.weather,
                diary: entry.diary,
                sleeptime: entry.sleeptime,
                weight: entry.weight,
                worktime: entry.worktime,
                activities: entry.activities,
                photos: entry.photos,
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


    function addPhotos(urls: string[]) {
        setData({
            ...data,
            photos: [...data.photos, ...urls]
        })
    }


    async function deletePhoto(name: string) {
        const {status} = await axios.delete(`/photos/${name}`)
        if (status == 204) {
            setData({
                ...data,
                photos: data.photos.filter(photoName => photoName != name)
            })
        }
    }


    function save() {
        willStore ? post('/entries') : put(`/entries/${entry.id}`)
    }


    function toggleGoal(id: number) {
        if (data.completedGoals.includes(id)) {
            setData({
                ...data,
                completedGoals: data.completedGoals.filter(goalId => goalId != id)
            })
        } else {
            setData({
                ...data,
                completedGoals: [...data.completedGoals, id]
            })
        }
    }


    return (
        <div className="save-entry-page">
            <Head title={willStore ? "Новая запись" : data.date?.split('T')[0]}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>
                        <DatePicker active={willStore} name="date" value={data.date ?? new Date().toISOString()} disabled={!willStore} error={errors.date} onChange={setField}/>
                    </FormTitle>
                    <FormOptions icon="settings" href={"/collections"}/>
                </FormHeader>
                <FormContent>
                    <MoodSelect name="mood" value={data.mood ?? Mood.Neutral} onChange={setField}/>
                    <GoalChecker toggleGoal={toggleGoal} goals={data.goals ?? []} completedGoals={data.completedGoals ?? []}/>
                    <WeatherSelect name="weather" value={data.weather ?? Weather.Sunny} onChange={setField}/>
                    <SleeptimeSelector name='sleeptime' value={data.sleeptime} onChange={setField}/>
                    <WeightSelector name='weight' value={data.weight} onChange={setField}/>
                    <WorktimeSelector name='worktime' value={data.worktime} onChange={setField}/>
                    <ActivityPicker collections={collections} value={data.activities ?? []} toggleActivity={addActivity}/>
                    <Diary name="diary" max={10000} value={data.diary ?? ""} onChange={setField}/>
                    <PhotoUploader name="photos[]" values={data.photos} deletePhoto={deletePhoto} onPhotosUploaded={addPhotos}/>
                </FormContent>
                <FormSubmitButton label="Сохранить" onClick={save}/>
            </Form>
        </div>
    )
}
