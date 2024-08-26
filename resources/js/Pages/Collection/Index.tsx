import "./Index.sass"
import React from "react";
import Collection from "../../model/collection";
import CollectionCard from "../../component/collection-card/collection-card";
import Icon from "../../component/icon/icon";
import {Head, Link, router} from "@inertiajs/react";
import withLayout from "../../Layout/default-layout";

type Props = {
    collections: Collection[]
}

export default withLayout(Index)
function Index({collections}: Props) {
    return (
        <div className="collections-page page">
            <Head title='Коллекции'/>
            {collections && collections.map((collection) =>
                <CollectionCard key={collection.id} collection={collection}/>
            )}
            {(collections == null || collections.length < 20) &&
                <Link className="collections-page-button" href={"/collections/new"}>
                    <div className="collections-page-button__title-container">
                        <Icon name="add" className="collections-page-button__icon" bold/>
                        <p className="collections-page-button__label">Добавить коллекцию</p>
                    </div>
                </Link>}
        </div>
    )
}


