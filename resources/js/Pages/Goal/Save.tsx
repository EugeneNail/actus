import "./Save.sass"
import Form from "../../component/form/form";
import React, {useEffect} from "react";
import Field from "../../component/field/field";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import IconSelect from "../../component/icon-select/icon-select";
import {useFormState} from "../../hooks/use-form-state";
import {Head} from "@inertiajs/react";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import FormContent from "../../component/form/form-content";
import FormOptions from "../../component/form/form-options";
import Icon8 from "../../component/icon8/icon8";
import Goal from "../../model/goal";
import {Color} from "../../model/color";

interface Payload {
    name: string
    icon: number
}

type Props = {
    goal: Goal,
}

export default function Save({goal}: Props) {
    const willStore = window.location.pathname.includes("/new")
    const {data, setData, setField, errors, post, put} = useFormState<Payload>()

    useEffect(() => {
        setData({
            name: goal?.name ?? "",
            icon: goal?.icon ?? 100,
        })
    }, []);


    function save() {
        willStore
            ? post(`/goals`)
            : put(`/goals/${goal.id}`)
    }


    return (
        <div className="save-goal-page">
            <Head title={willStore ? "Новая цель" : data.name}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>{willStore ? "Новая цель" : data?.name}</FormTitle>
                    {!willStore && <FormOptions icon="delete" href={`/goals/${goal.id}/delete`}/>}
                </FormHeader>
                <FormContent>
                    <div className="save-goal-page__name-container wrapped">
                        <Icon8 className="save-goal-page__icon" id={data.icon}/>
                        <Field className="save-goal-page__field" name="name" label="Название" value={data.name} max={50} error={errors.name} onChange={setField}/>
                    </div>
                    <IconSelect className="save-goal-page__icon-select" name="icon" color={Color.Accent} value={data.icon} onChange={setField}/>
                </FormContent>
                <FormSubmitButton label="Сохранить" color={Color.Accent} onClick={save}/>
            </Form>
        </div>
    )
}
