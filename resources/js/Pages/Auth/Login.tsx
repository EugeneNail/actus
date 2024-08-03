import "./guest-page.sass"
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import {useFormState} from "../../hooks/use-form-state";
import FormSubmitButton from "../../component/form/form-submit-button";
import {Head, Link} from "@inertiajs/react";
import React from "react";
import FormContent from "../../component/form/form-content";

interface Payload {
    email: string
    password: string
}

export default function Login() {
    const {data, setField, errors, post} = useFormState<Payload>()

    function login() {
        post('/login')
    }

    return (
        <div className="guest-page">
            <Head title="Войти"/>
            <Form>
                <FormContent>
                    <img src="/img/logo/android-chrome-512x512.png" alt="" className="guest-page__logo"/>
                    <h1 className="guest-page__header">Actum</h1>
                    {/*<h2 className="guest-page__subheader">Войдите, чтобы продолжить</h2>*/}
                    <Field name="email" label="Электронная почта" value={data.email} email max={100} error={errors.email} onChange={setField}/>
                    <Field name="password" label="Пароль" value={data.password} max={100} error={errors.password} onChange={setField} password/>
                    <Link href="/signup" className="guest-page-link">У меня нет аккаунта</Link>
                </FormContent>
                <FormSubmitButton label="Войти" onClick={login}/>
            </Form>
        </div>
    )
}
