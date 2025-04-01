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
    const {payload, setField, errors, post} = useFormState<Payload>()

    function signup() {
        post('/signup')
    }

    return (
        <GuestLayout>
            <Head title="Sign Up"/>
            <div className="guest-page">
                <Form>
                    <FormContent>
                        <img src="/img/logo/android-chrome-512x512.png" alt="" className="guest-page__logo"/>
                        <h1 className="guest-page__header">Actus</h1>
                        <Field name="name" label="What is your name?" value={payload?.name} max={20} error={errors.name} onChange={setField}/>
                        <Field name="email" label="Email" value={payload?.email} email max={100} error={errors.email} onChange={setField}/>
                        <Field name="password" label="Password" value={payload?.password} max={100} error={errors.password} onChange={setField} password/>
                        <Field name="passwordConfirmation" label="Repeat the password" value={payload?.passwordConfirmation} max={100} error={errors.passwordConfirmation} onChange={setField} password/>
                        <Link href="/login" className="guest-page-link">I already have an account</Link>
                    </FormContent>
                    <FormSubmitButton label="Sign Up" onClick={signup}/>
                </Form>
            </div>
        </GuestLayout>
    )
}
