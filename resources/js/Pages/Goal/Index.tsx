import "./Index.sass"
import React from "react";
import withLayout from "../../Layout/default-layout";
import {Head, Link} from "@inertiajs/react";
import Goal from "../../model/goal";
import GoalCard from "../../component/goal-card/goal-card";
import Icon from "../../component/icon/icon";

type Props = {
    goals: Goal[],
}


export default withLayout(Index)
function Index({goals}: Props) {
    return (
        <div className="goals-page">
            <Head title='Goals'/>
            <div className="goals-page__goals wrapped">
                {goals && goals.map(entry => (
                    <GoalCard key={entry.id} goal={entry}/>
                ))}
                <Link className="goals-page__button" href={'/goals/new'}>
                    <Icon className="goals-page__button-icon" name='add' bold/>
                </Link>
            </div>
        </div>
    )
}
