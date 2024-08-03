import "./Delete.sass"
import React from "react";
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
    id: number,
    name: string,
    activityCount: number
}

export default function Delete({id, name, activityCount}: Props) {
    return (
        <div className="delete-collection-page page">
            <Head title={name}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>
                        {name}
                    </FormTitle>
                </FormHeader>
                <FormContent>
                    <p className="justified">Удаление коллекции удалит все ее активности ({activityCount}).</p>
                    <p className="justified">Активности также будут удалены из всех ваших записей. Это действие необратимо.</p>
                    <p className="justified">Вы действительно хотите удалить коллекцию?</p>
                </FormContent>
                <FormSubmitButton label="Удалить" color={Color.Red} onClick={() => router.delete(`/collections/${id}`)}/>
            </Form>
        </div>
    )
}
