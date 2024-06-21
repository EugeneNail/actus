import {ChangeEvent, useState} from "react";

export function useFormState<D>() {
    const [state, setState] = useState<D & {[key: string]: any}>()

    function setField(event: ChangeEvent<HTMLInputElement>) {
        event.preventDefault()
        setState({
            ...state,
            [event.target.name] : event.target.value
        })
    }

    return {state, setField, setState}
}
