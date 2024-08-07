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
    activityName: string
    activityId: number
    collectionId: number
}

export default function Delete({activityName, activityId, collectionId}: Props) {
    return (
        <div className="delete-activity-page page">
            <Head title={activityName}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>{activityName}</FormTitle>
                </FormHeader>
                <FormContent>
                    <p className="justified">Удаление активности "{activityName}" также удалит ее из всех ваших записей.</p>
                    <p className="justified">Это действие необратимо.</p>
                    <p className="justified">Вы действительно хотите удалить активность?</p>
                </FormContent>
                <FormSubmitButton label="Удалить" color={Color.Red} onClick={() => router.delete(`/collections/${collectionId}/activities/${activityId}`)}/>
            </Form>
        </div>
    )
}
