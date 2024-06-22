import Activity from "./activity";
import {Color} from "./color";

export default class Collection {
    id: number = 0
    name: string = ""
    userId: number = 0
    color: Color = Color.Red
    activities: Activity[] = []
}
