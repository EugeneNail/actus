import "./collection-card.sass"
import Collection from "../../model/collection";
import ActivityCard from "../activity-card/activity-card";
import Icon from "../icon/icon";
import classNames from "classnames";
import React from "react";
import {router} from "@inertiajs/react";
import selectColor from "../../service/select-color";

type Props = {
    collection: Collection
}

export default function CollectionCard({collection}: Props) {
    return (
        <div className="collection-card">
            <div className="collection-card__title-container" onClick={() => router.get(`/collections/${collection.id}`)}>
                <h6 className={classNames("collection-card__title", selectColor(collection.color))}>{collection.name}</h6>
            </div>
            <div className="collection-card__activities">
                {collection.activities && collection.activities.map(activity => (
                    <ActivityCard key={activity.id} activity={activity} collectionId={collection.id}/>
                ))}
                {(collection.activities?.length < 20 || collection.activities == null) && <div className="collection-card-button" onClick={() => {}}>
                    <div className={classNames("collection-card-button__icon-container", selectColor(collection.color))} >
                        <Icon className={classNames("collection-card-button__icon", selectColor(collection.color))} name="add" bold/>
                    </div>
                    <p className="collection-card-button__label">Добавить активность</p>
                </div>}
            </div>
        </div>
    )
}
