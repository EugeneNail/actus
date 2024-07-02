import "./guest-page.sass"
import Form from "../../component/form/form";
import Field from "../../component/field/field";
import FormButtons from "../../component/form/form-button-container";
import FormSubmitButton from "../../component/form/form-submit-button";
import React from "react";
import {useFormState} from "../../hooks/use-form-state";
import GuestLayout from "../../Layout/guest-layout";
import {Head, Link} from "@inertiajs/react";

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
            <div className="page">
                <Form title="Регистрация" subtitle={"это только начало"}>
                    <Field name="name" label="Как вас зовут?" icon="face" value={data?.name} max={20} error={errors.name} onChange={setField}/>
                    <Field name="email" label="Электронная почта" icon="mail" value={data?.email} email max={100} error={errors.email} onChange={setField}/>
                    <Field name="password" label="Пароль" icon="lock" value={data?.password} max={100} error={errors.password} onChange={setField} password/>
                    <Field name="passwordConfirmation" label="Повторите пароль" icon="lock" value={data?.passwordConfirmation} max={100} error={errors.passwordConfirmation} onChange={setField} password/>
                    <FormButtons>
                        <FormSubmitButton label="Зарегистрироваться" onClick={signup}/>
                    </FormButtons>
                </Form>
                <Link href="/login" className="guest-page-link">У меня уже есть аккаунт</Link>
            </div>
        </GuestLayout>
    )
}
