import React, {ChangeEvent} from "react";
import "./category-selector.sass"
import Category from "@/model/category";
import classNames from "classnames";
import Icon from "@/component/icon/icon";

type Props = {
    categories: Category[]
    value: number
    name: string
    className?: string
    onChange: (event: ChangeEvent<HTMLInputElement>) => void
}

export default function CategorySelector({categories, value, name, className, onChange}: Props) {
    function setCategory(category: Category) {
        const input = document.getElementById(name) as HTMLInputElement
        input.defaultValue = category.value.toString()
        input.dispatchEvent(new Event('input', {bubbles: true}))
    }

    return (
        <div className="category-selector">
            <input className="category-selector__input" id={name} name={name} onChange={onChange} type='number'/>
            {categories && categories.map(category => (
                <div key={category.name} className={classNames("category-selector__category", {'button accent primary': category.value == value})} onClick={() => setCategory(category)}>
                    <Icon className='category-selector__icon' name={category.icon} />
                    {category.name}
                </div>
            ))}
        </div>
    )
}
