import "./Index.sass"
import React from "react";
import Collection from "../../model/collection";
import CollectionCard from "../../component/collection-card/collection-card";
import Icon from "../../component/icon/icon";
import {router} from "@inertiajs/react";

type Props = {
    collections: Collection[]
}

export default function Index({collections}: Props) {
    return (
        <div className="collections-page page">
            {collections && collections.map((collection) =>
                <CollectionCard key={collection.id} collection={collection}/>
            )}
            {(collections == null || collections.length < 20) &&
                <div className="collections-page-button" onClick={() => router.get("/collections/new")}>
                    <div className="collections-page-button__title-container">
                        <Icon name="add" className="collections-page-button__icon" bold/>
                        <p className="collections-page-button__label">Добавить коллекцию</p>
                    </div>
                </div>}
        </div>
    )
}
