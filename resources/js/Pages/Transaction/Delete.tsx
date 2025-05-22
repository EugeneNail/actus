import Form from "../../component/form/form";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import {Color} from "../../model/color";
import {Head, router} from "@inertiajs/react";
import FormContent from "../../component/form/form-content";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import React from "react";

type Props = {
    id: number
}

export default function Delete({id}: Props) {
    return (
        <div className="delete-transaction-page page">
            <Head title={`Transaction ${id}`}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>{`Transaction ${id}`}</FormTitle>
                </FormHeader>
                <FormContent>
                    <p className="justified">Deleting transaction #{id} will delete it from all your statistics.</p>
                    <p className="justified">This action cannot be undone.</p>
                    <p className="justified">Are you sure you want to delete it?</p>
                </FormContent>
                <FormSubmitButton label="Delete" color={Color.Red} onClick={() => router.delete(`/transactions/${id}`)}/>
            </Form>
        </div>
    )
}
