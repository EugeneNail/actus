import "./save.sass"
import Form from "../../component/form/form";
import FormBackButton from "../../component/form/form-back-button";
import FormSubmitButton from "../../component/form/form-submit-button";
import React, {ChangeEvent, useEffect} from "react";
import {DatePicker} from "@/component/date-picker/date-picker";
import {useFormState} from "@/hooks/use-form-state";
import {Head, router} from "@inertiajs/react";
import FormContent from "../../component/form/form-content";
import FormHeader from "../../component/form/form-header";
import FormTitle from "../../component/form/form-title";
import FormOptions from "../../component/form/form-options";
import Transaction from "@/model/transaction";
import Category from "@/model/category";
import Field from "@/component/field/field";
import SignPicker from "@/component/sign-picker/sign-picker";
import CategorySelector from "@/component/category-selector/category-selector";


type Props = {
    transaction: Transaction,
    categories: Category[]
}

type Payload = Transaction

export default function Save({transaction, categories}: Props) {
    const willStore = transaction.id == 0
    const {payload, setPayload, setField, errors, post, put} = useFormState<Payload>()


    useEffect(() => {
        setPayload(transaction)
    }, []);


    function save() {
        willStore ? post('/transactions') : put(`/transactions/${transaction.id}`)
    }


    return (
        <div className="save-transaction-page">
            <Head title={payload.date?.split('T')[0]}/>
            <Form>
                <FormHeader>
                    <FormBackButton/>
                    <FormTitle>
                        <DatePicker name="date" value={payload.date ?? new Date().toISOString()} error={errors.date} onChange={e => setField(e)}/>
                    </FormTitle>
                    {!willStore && <FormOptions icon="delete" href={`/transactions/${transaction.id}/delete`}/>}
                </FormHeader>
                <FormContent>
                    <Field name='description' label='Description' value={payload.description} max={50} onChange={setField} error={errors.description}/>
                    <CategorySelector categories={categories} value={payload.category} name='category' onChange={setField} />
                    <div className="save-transaction-page__value-container">
                        <SignPicker name='sign' value={payload.sign} onChange={setField}/>
                        <Field name='value' label='Amount' value={payload.value?.toString()} numeric onChange={setField} error={errors.value}/>
                    </div>
                </FormContent>
                <FormSubmitButton label={willStore ? 'Create' : 'Save'} onClick={save}/>
            </Form>
        </div>
    )
}
