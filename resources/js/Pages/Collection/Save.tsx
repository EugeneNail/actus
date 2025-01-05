import React, {useEffect} from "react";
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import Palette from "../../component/palette/palette";
import {Color} from "../../model/color";
import {useFormState} from "../../hooks/use-form-state";
import {Head, router} from "@inertiajs/react";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import FormOptions from "../../component/form/form-options";
import FormContent from "../../component/form/form-content";

interface Payload {
    id: number
    name: string
    color: Color
}

export default function Save({id, name, color}: Payload) {
    const willStore = window.location.pathname.includes("/new")
    const {payload, setPayload, setField, errors, post, put} = useFormState<Payload>()


    useEffect(() => {
        setPayload({
            id: id ?? 0,
            name: name ?? '',
            color: color ?? Color.Red
        })
    }, []);


    function save() {
        willStore ? post('/collections') : put(`/collections/${id}`)
    }


    return (
        <div className="save-collection-page">
            <Head title={willStore ? "Новая коллекция" : payload.name}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>
                        {willStore ? "Новая коллекция" : payload.name}
                    </FormTitle>
                    <FormOptions icon="delete" href={`/collections/${id}/delete`}/>
                </FormHeader>
                <FormContent>
                    <Field name="name" label="Название" value={payload.name} max={20} error={errors.name} onChange={setField}/>
                    <Palette name="color" value={payload.color} onChange={setField}/>
                </FormContent>
                <FormSubmitButton color={payload.color} label="Сохранить" onClick={save}/>
            </Form>
        </div>
    )
}
