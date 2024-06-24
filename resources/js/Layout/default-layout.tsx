import "./default-layout.sass"
import React, {FC, ReactNode} from "react";
import Header from "../component/header/header";

type Props = {
    children: ReactNode
}
function DefaultLayout({children}: Props) {
    return (
        <div className="default-layout">
            {children}
            <Header/>
        </div>
    )
}


export default function withLayout(Component: FC) {
    return (props) => (
        <DefaultLayout>
            <Component {...props} />
        </DefaultLayout>
    );
};
