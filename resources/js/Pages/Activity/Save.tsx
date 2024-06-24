import "./Save.sass"
import Form from "../../component/form/form";
import React, {useEffect, useState} from "react";
import Field from "../../component/field/field";
import FormButtons from "../../component/form/form-button-container";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import FormDeleteButton from "../../component/form/form-delete-button";
import IconSelect from "../../component/icon-select/icon-select";
import Collection from "../../model/collection";
import {useFormState} from "../../hooks/use-form-state";
import Activity from "../../model/activity";
import {router} from "@inertiajs/react";

interface Payload {
    name: string
    icon: number
}

type Props = {
    collection: Collection,
    activity: Activity
}

export default function Save({collection, activity}: Props) {
    const willStore = window.location.pathname.includes("/new")
    const {data, setData, setField, errors, post, put} = useFormState<Payload>()


    useEffect(() => {
        setData({
            name: activity?.name ?? "",
            icon: activity?.icon ?? 100,
        })
    }, []);


    function save() {
        willStore
            ? post(`/collections/${collection.id}/activities`)
            : put(`/collections/${collection.id}/activities/${activity.id}`)
    }


    function getTitle(): string {
        return willStore ? "Новая активность" : data?.name
    }


    function getSubtitle(): string {
        return `${willStore ? "" : "Активность"} коллекции "${collection.name}"`
    }


    return (
        <div className="save-activity-page page">
            <Form title={getTitle()} subtitle={getSubtitle()}>
                <Field name="name" label="Название" icon="webhook" color={collection.color} value={data.name} max={20} error={errors.name} onChange={setField}/>
                <IconSelect className="save-activity-page__icon-select" name="icon" color={collection.color} value={data.icon} onChange={setField}/>
                <FormButtons>
                    <FormBackButton color={collection.color} />
                    <FormSubmitButton label="Сохранить" color={collection.color} onClick={save}/>
                    {!willStore && <FormDeleteButton onClick={() => router.get(`/collections${collection.id}/activities/${activity.id}/delete`)}/>}
                </FormButtons>
            </Form>
        </div>
    )
}
