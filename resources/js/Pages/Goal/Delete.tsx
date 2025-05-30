import React, {useEffect, useState} from "react";
import Form from "../../component/form/form";
import FormButtons from "../../component/form/form-button-container";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import {Color} from "../../model/color";
import {Head, router} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";
import FormContent from "../../component/form/form-content";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";

type Props = {
    name: string
    id: number
}

export default function Delete({name, id}: Props) {
    return (
        <div className="delete-goal-page page">
            <Head title={name}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>{name}</FormTitle>
                </FormHeader>
                <FormContent>
                    <p className="justified">Deleting the "{name}" goal will delete it from all your entries.</p>
                    <p className="justified">This action cannot be undone.</p>
                    <p className="justified">Are you sure you want to delete it?</p>
                </FormContent>
                <FormSubmitButton label="Delete" color={Color.Red} onClick={() => router.delete(`/goals/${id}`)}/>
            </Form>
        </div>
    )
}
