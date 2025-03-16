import {Mood} from "./mood";
import {Weather} from "./weather";
import Goal from "@/model/goal";

export default class Entry {
    id: number = 0
    date: string = ""
    mood: Mood = Mood.Neutral
    weather: Weather = Weather.Sunny
    diary: string = ""
    photos: string[] = []
    goals: Goal[] = []
}
