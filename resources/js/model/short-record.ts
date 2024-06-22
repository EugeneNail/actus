import ShortCollection from "./short-collection";
import {Mood} from "./mood";
import {Weather} from "./weather";

export default class ShortRecord {
    id: number = 0
    date: string = ""
    mood: Mood = Mood.Neutral
    weather: Weather = Weather.Sunny
    notes: string = ""
    collections: ShortCollection[] = []
    photos: string[] = []
}
