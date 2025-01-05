import {ChangeEvent, useState} from "react";
import {useForm} from "@inertiajs/react";

export function useFormState<D>() {
    const {data:payload, setData: setPayload, errors, post, put, get} = useForm<D & {[key: string]: any}>()

    function setField(event: ChangeEvent<HTMLInputElement>) {
        event.preventDefault()
        setPayload({
            ...payload,
            [event.target.name] : event.target.value
        })
    }

    return {payload, setPayload, setField, errors, post, put, get}
}
