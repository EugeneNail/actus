import "./guest-page.sass"
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import FormButtons from "../../component/form/form-button-container";
import FormSubmitButton from "../../component/form/form-submit-button";
import React from "react";
import {useFormState} from "../../hooks/use-form-state";
import GuestLayout from "../../Layout/guest-layout";
import {Head, Link} from "@inertiajs/react";
import FormContent from "../../component/form/form-content";

interface Payload {
    name: string
    email: string
    password: string
    passwordConfirmation: string
}

export default function SignupPage() {
    const {data, setField, errors, post} = useFormState<Payload>()

    function signup() {
        post('/signup')
    }

    return (
        <GuestLayout>
            <Head title="Регистрация"/>
            <div className="guest-page">
                <Form>
                    <FormContent>
                        <img src="/img/logo/android-chrome-512x512.png" alt="" className="guest-page__logo"/>
                        <h1 className="guest-page__header">Actum</h1>
                        <Field name="name" label="Как вас зовут?" value={data?.name} max={20} error={errors.name} onChange={setField}/>
                        <Field name="email" label="Электронная почта" value={data?.email} email max={100} error={errors.email} onChange={setField}/>
                        <Field name="password" label="Пароль" value={data?.password} max={100} error={errors.password} onChange={setField} password/>
                        <Field name="passwordConfirmation" label="Повторите пароль" value={data?.passwordConfirmation} max={100} error={errors.passwordConfirmation} onChange={setField} password/>
                        <Link href="/login" className="guest-page-link">У меня уже есть аккаунт</Link>
                    </FormContent>
                    <FormSubmitButton label="Зарегистрироваться" onClick={signup}/>
                </Form>
            </div>
        </GuestLayout>
    )
}
