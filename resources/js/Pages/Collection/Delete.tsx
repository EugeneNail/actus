import "./Delete.sass"
import React from "react";
import Form from "../../component/form/form";
import FormButtons from "../../component/form/form-button-container";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import {Color} from "../../model/color";
import {router} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";

type Props = {
    id: number,
    name: string,
    color: Color
    activityCount: number
}

export default withLayout(Delete);
function Delete({id, name, color, activityCount}: Props) {
    console.log(color)
    return (
        <div className="delete-collection-page page">
            <Form title={`Удалить коллекцию "${name}"?`}>
                <p className="justified">Удаление коллекции удалит все ее активности ({activityCount}).</p>
                <br/>
                <p className="justified">Активности также будут удалены из всех ваших записей. Это действие необратимо. Вы действительно хотите удалить коллекцию?</p>
                <FormButtons>
                    <FormBackButton color={color}/>
                    <FormSubmitButton label="Удалить" color={Color.Red} onClick={() => router.delete(`/collections/${id}`)}/>
                </FormButtons>
            </Form>
        </div>
    )
}
