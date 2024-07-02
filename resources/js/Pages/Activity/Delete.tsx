import React, {useEffect, useState} from "react";
import Form from "../../component/form/form";
import FormButtons from "../../component/form/form-button-container";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import {Color} from "../../model/color";
import {Head, router} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";

type Props = {
    activityName: string
    activityId: number
    collectionId: number
}

export default withLayout(Delete);
function Delete({activityName, activityId, collectionId}: Props) {
    return (
        <div className="delete-activity-page page">
            <Head title={activityName}/>
            <Form title={`Удалить активность "${activityName}"?`}>
                <p className="justified">Удаление активности также удалит ее из всех ваших записей.</p>
                <br/>
                <p className="justified">Это действие необратимо. Вы действительно хотите удалить активность?</p>
                <FormButtons>
                    <FormBackButton/>
                    <FormSubmitButton label="Удалить" color={Color.Red} onClick={() => router.delete(`/collections/${collectionId}/activities/${activityId}`)}/>
                </FormButtons>
            </Form>
        </div>
    )
}
