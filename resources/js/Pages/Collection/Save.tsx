import React, {useEffect} from "react";
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import FormButtons from "../../component/form/form-button-container";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import FormDeleteButton from "../../component/form/form-delete-button";
import Palette from "../../component/palette/palette";
import {Color} from "../../model/color";
import {useFormState} from "../../hooks/use-form-state";
import {router} from "@inertiajs/react";

interface Payload {
    id: number
    name: string
    color: Color
}


export default function Save({id, name, color}: Payload) {
    const willStore = window.location.pathname.includes("/new")
    const {data, setData, setField, errors, post, put} = useFormState<Payload>()


    useEffect(() => {
        setData({
            id: id ?? 0,
            name: name ?? '',
            color: color ?? Color.Red
        })
    }, []);


    function save() {
        willStore ? post('/collections') : put(`/collections/${id}`)
    }


    return (
        <div className="save-collection-page page">
            <Form title={willStore ? "Новая коллекция" : data.name} subtitle={willStore ? "" : "Коллекция"}>
                <Field name="name" label="Название" icon="category" color={data.color} value={data.name} max={20} error={errors.name} onChange={setField}/>
                <Palette name="color" value={data.color} onChange={setField}/>
                <FormButtons>
                    <FormBackButton color={data.color}/>
                    <FormSubmitButton color={data.color} label="Сохранить" onClick={save}/>
                    {!willStore && <FormDeleteButton onClick={() => router.get("/collections/delete")}/>}
                </FormButtons>
            </Form>
        </div>
    )
}
