import "./guest-page.sass"
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import {useFormState} from "../../hooks/use-form-state";
import FormButtons from "../../component/form/form-button-container";
import FormSubmitButton from "../../component/form/form-submit-button";
import {Link, useForm} from "@inertiajs/react";
import React from "react";

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
        <div className="page">
            <Form title="Привет!" subtitle={"Войдите, чтобы продолжить"}>
                <Field name="email" label="Электронная почта" icon="mail" value={data.email} email max={100} error={errors.email} onChange={setField}/>
                <Field name="password" label="Пароль" icon="lock" value={data.password} max={100} error={errors.password} onChange={setField} password/>
                <FormButtons>
                    <FormSubmitButton label="Войти" onClick={login}/>
                </FormButtons>
            </Form>
            <Link href="/signup" className="guest-page-link">У меня нет аккаунта</Link>
        </div>
    )
}
