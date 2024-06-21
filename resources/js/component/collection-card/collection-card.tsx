import "./collection-card.sass"
import Collection from "../../model/collection";
import ActivityCard from "../activity-card/activity-card";
import Icon from "../icon/icon";
import classNames from "classnames";
import {Color} from "../../model/color";
import React from "react";

type Props = {
    collection: Collection
}

export default function CollectionCard({collection}: Props) {
    const titleClassName = classNames(
        "collection-card__title",
        {red: collection.color == Color.Red},
        {orange: collection.color == Color.Orange},
        {yellow: collection.color == Color.Yellow},
        {green: collection.color == Color.Green},
        {blue: collection.color == Color.Blue},
        {purple: collection.color == Color.Purple},
    )
    const buttonIconContainerClassName = classNames(
        "collection-card-button__icon-container",
        {red: collection.color == Color.Red},
        {orange: collection.color == Color.Orange},
        {yellow: collection.color == Color.Yellow},
        {green: collection.color == Color.Green},
        {blue: collection.color == Color.Blue},
        {purple: collection.color == Color.Purple},
    )
    const buttonIconClassName = classNames(
        "collection-card-button__icon",
        {red: collection.color == Color.Red},
        {orange: collection.color == Color.Orange},
        {yellow: collection.color == Color.Yellow},
        {green: collection.color == Color.Green},
        {blue: collection.color == Color.Blue},
        {purple: collection.color == Color.Purple},
    )

    return (
        <div className="collection-card">
            <div className="collection-card__title-container" onClick={() => {}}>
                <h6 className={titleClassName}>{collection.name}</h6>
            </div>
            <div className="collection-card__activities">
                {collection.activities && collection.activities.map(activity => (
                    <ActivityCard key={activity.id} activity={activity} collectionId={collection.id}/>
                ))}
                {(collection.activities?.length < 20 || collection.activities == null) && <div className="collection-card-button" onClick={() => {}}>
                    <div className={buttonIconContainerClassName} >
                        <Icon className={buttonIconClassName} name="add" bold/>
                    </div>
                    <p className="collection-card-button__label">Добавить активность</p>
                </div>}
            </div>
        </div>
    )
}
