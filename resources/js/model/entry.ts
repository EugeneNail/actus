import {Mood} from "./mood";
import {Weather} from "./weather";
import Collection from "./collection";

export default class Entry {
    id: number = 0
    date: string = ""
    mood: Mood = Mood.Neutral
    weather: Weather = Weather.Sunny
    diary: string = ""
    collections: Collection[] = []
    photos: string[] = []
}
