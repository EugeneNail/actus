import Activity from "./activity";
import {Color} from "./color";

export default class Collection {
    id: number = 0
    name: string = ""
    color: Color = Color.Red
    activities: Activity[] = []
}
