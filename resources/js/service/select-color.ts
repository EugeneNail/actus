import {Color} from "../model/color";

const colors : {[color: number]: string} = {
    [Color.Red]: "red",
    [Color.Orange]: "orange",
    [Color.Yellow]: "yellow",
    [Color.Green]: "green",
    [Color.Blue]: "blue",
    [Color.Purple]: "purple",
    [Color.Accent]: "accent",
}
export default function selectColor(color: Color): string {
    return colors[color];
}
