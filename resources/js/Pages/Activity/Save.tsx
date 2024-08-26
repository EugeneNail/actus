import "./Save.sass"
import Form from "../../component/form/form";
import React, {useEffect} from "react";
import Field from "../../component/field/field";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import IconSelect from "../../component/icon-select/icon-select";
import Collection from "../../model/collection";
import {useFormState} from "../../hooks/use-form-state";
import Activity from "../../model/activity";
import {Head, router} from "@inertiajs/react";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import FormContent from "../../component/form/form-content";
import FormOptions from "../../component/form/form-options";
import Icon8 from "../../component/icon8/icon8";

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


    return (
        <div className="save-activity-page">
            <Head title={willStore ? "Новая активность" : data.name}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>{willStore ? "Новая активность" : data?.name}</FormTitle>
                    {!willStore && <FormOptions icon="delete" href={`/collections/${collection.id}/activities/${activity.id}/delete`}/>}
                </FormHeader>
                <FormContent>
                    <div className="save-activity-page__name-container wrapped">
                        <Icon8 className="save-activity-page__icon" id={data.icon}/>
                        <Field className="save-activity-page__field" name="name" label="Название" value={data.name} max={20} error={errors.name} onChange={setField}/>
                    </div>
                    <IconSelect className="save-activity-page__icon-select" name="icon" color={collection.color} value={data.icon} onChange={setField}/>
                </FormContent>
                <FormSubmitButton label="Сохранить" color={collection.color} onClick={save}/>
            </Form>
        </div>
    )
}
