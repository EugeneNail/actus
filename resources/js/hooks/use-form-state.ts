import {ChangeEvent, useState} from "react";
import {useForm} from "@inertiajs/react";

export function useFormState<D>() {
    const {data, setData, errors, post, put, get} = useForm<D & {[key: string]: any}>()

    function setField(event: ChangeEvent<HTMLInputElement>) {
        event.preventDefault()
        setData({
            ...data,
            [event.target.name] : event.target.value
        })
    }

    return {data, setData, setField, errors, post, put, get}
}
