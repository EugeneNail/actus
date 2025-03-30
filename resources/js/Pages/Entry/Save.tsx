import Form from "../../component/form/form";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import React, {ChangeEvent, useEffect} from "react";
import {DatePicker} from "@/component/date-picker/date-picker";
import MoodSelect from "../../component/mood-select/mood-select";
import Diary from "../../component/diary/diary";
import WeatherSelect from "../../component/weather-select/weather-select";
import {Mood} from "@/model/mood";
import {Weather} from "@/model/weather";
import {useFormState} from "@/hooks/use-form-state";
import {Head, router} from "@inertiajs/react";
import PhotoUploader from "../../component/photo-uploader/photo-uploader";
import axios from "axios";
import FormContent from "../../component/form/form-content";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import FormOptions from "../../component/form/form-options";
import GoalChecker from "../../component/goal-checker/goal-checker";
import Goal from "../../model/goal";


type Props = {
    id: number
    date: string
    goals: number[]
    latestGoalCompletions: { [key: number]: number }
    userGoals: Goal[]
    mood: Mood
    weather: Weather
    diary: string
    photos: string[]
}

type Payload = {
    id: number
    mood: Mood
    goals: number[]
    date: string
    weather: Weather
    diary: string
    photos: string[]
}


export default function Save(data: Props) {
    const willStore = data.id == 0
    const {payload, setPayload, setField, errors, post} = useFormState<Payload>()

    useEffect(() => {
        setPayload({
            id: data.id,
            mood: data.mood,
            goals: data.goals,
            date: data.date.split('T')[0],
            weather: data.weather,
            diary: data.diary,
            photos: data.photos,
        })
    }, []);


    function redirectToDate(event: ChangeEvent<HTMLInputElement>) {
        event.preventDefault()
        router.get(`/entries/${event.target.value}`)
    }


    function toggleGoal(id: number) {
        if (payload.goals.includes(id)) {
            setPayload({
                ...payload,
                goals: payload.goals.filter(goalId => goalId != id)
            })
        } else {
            setPayload({
                ...payload,
                goals: [...payload.goals, id]
            })
        }
    }


    function addPhotos(urls: string[]) {
        setPayload({
            ...payload,
            photos: [...payload.photos, ...urls]
        })
    }


    async function deletePhoto(name: string) {
        const {status} = await axios.delete(`/photos/${name}`)
        if (status == 204) {
            setPayload({
                ...payload,
                photos: payload.photos.filter(photoName => photoName != name)
            })
        }
    }


    function save() {
        post('/entries')
    }


    return (
        <div className="save-entry-page">
            <Head title={payload.date?.split('T')[0]}/>
            <Form>
                <FormHeader>
                    <FormBackButton action={() => router.get("/entries")}/>
                    <FormTitle>
                        <DatePicker name="date" value={payload.date ?? new Date().toISOString()} error={errors.date} onChange={redirectToDate}/>
                    </FormTitle>
                    <FormOptions icon="settings" href={"/collections"}/>
                </FormHeader>
                <FormContent>
                    <MoodSelect name="mood" value={payload.mood ?? Mood.Neutral} onChange={setField}/>
                    <GoalChecker toggleGoal={toggleGoal} userGoals={data.userGoals ?? []} goals={payload.goals ?? []} lastGoalCompletions={data.latestGoalCompletions ?? []}/>
                    <WeatherSelect name="weather" value={payload.weather ?? Weather.Sunny} onChange={setField}/>
                    <Diary name="diary" max={10000} value={payload.diary ?? ""} onChange={setField}/>
                    <PhotoUploader name="photos[]" values={payload.photos} deletePhoto={deletePhoto} onPhotosUploaded={addPhotos}/>
                </FormContent>
                <FormSubmitButton label={willStore ? 'Создать' : 'Сохранить'} onClick={save}/>
            </Form>
        </div>
    )
}
