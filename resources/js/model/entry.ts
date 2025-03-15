import {Mood} from "./mood";
import {Weather} from "./weather";

export default class Entry {
    id: number = 0
    date: string = ""
    mood: Mood = Mood.Neutral
    weather: Weather = Weather.Sunny
    diary: string = ""
    photos: string[] = []
}
