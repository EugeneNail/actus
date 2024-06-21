import "./guest-page.sass"
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import FormButtons from "../../component/form/form-button-container";
import FormSubmitButton from "../../component/form/form-submit-button";
import React, {useState} from "react";
import {useFormState} from "../../hooks/use-form-state";
import {usePage} from "@inertiajs/react";
import GuestLayout from "../../Layout/guest-layout";
import {Inertia} from "@inertiajs/inertia"

interface IFormState {
    name: string
    email: string
    password: string
    passwordConfirmation: string
}

export default function SignupPage() {
    const {state, setField} = useFormState<IFormState>()
    const {errors} = usePage().props

    function signup() {
        Inertia.post("/signup", state)
    }

    return (
        <GuestLayout>
            <div className="page">
                <Form title="Регистрация" subtitle={"это только начало"}>
                    <Field name="name" label="Как вас зовут?" icon="face" value={state?.name} max={20} error={errors.name} onChange={setField}/>
                    <Field name="email" label="Электронная почта" icon="mail" value={state?.email} email max={100} error={errors.email} onChange={setField}/>
                    <Field name="password" label="Пароль" icon="lock" value={state?.password} max={100} error={errors.password} onChange={setField} password/>
                    <Field name="passwordConfirmation" label="Повторите пароль" icon="lock" value={state?.passwordConfirmation} max={100} error={errors.passwordConfirmation} onChange={setField} password/>
                    <FormButtons>
                        <FormSubmitButton label="Зарегистрироваться" onClick={signup}/>
                    </FormButtons>
                </Form>
            </div>
        </GuestLayout>
    )
}
